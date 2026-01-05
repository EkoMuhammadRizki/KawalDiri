<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * TransactionController
 * 
 * Controller untuk mengelola transaksi keuangan pengguna.
 * Menyediakan operasi CRUD: tampilkan daftar, buat baru, update, dan hapus transaksi.
 * Juga menghitung statistik anggaran bulanan.
 */
class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi pengguna.
     * 
     * Mendukung filter berdasarkan tipe (income/expense), kategori,
     * pencarian berdasarkan judul, dan paginasi.
     * Juga menghitung statistik anggaran untuk ditampilkan di sidebar.
     * 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Ambil transaksi user yang login, urutkan dari tanggal terbaru
        $query = Auth::user()->transactions()->latest('date');

        // Filter berdasarkan tipe (income/expense)
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Pencarian berdasarkan judul transaksi
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Paginasi: 5 transaksi per halaman
        $transactions = $query->paginate(5);

        // Hitung statistik anggaran bulanan
        $user = Auth::user();

        // Total pengeluaran bulan ini
        $monthlyExpenses = $user->transactions()
            ->thisMonth()
            ->expense()
            ->sum('amount');

        // Total pemasukan bulan ini
        $monthlyIncome = $user->transactions()
            ->thisMonth()
            ->income()
            ->sum('amount');

        // Kalkulasi persentase dan sisa anggaran
        $budget = $user->budget ?? 0;
        $budgetUsedPercent = $budget > 0 ? ($monthlyExpenses / $budget) * 100 : 0;
        $budgetRemaining = $budget - $monthlyExpenses;

        // Jika request dari API (AJAX), kembalikan JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'transactions' => $transactions,
                'stats' => [
                    'budget' => $budget,
                    'monthly_expenses' => $monthlyExpenses,
                    'monthly_income' => $monthlyIncome,
                    'budget_used_percent' => round($budgetUsedPercent, 2),
                    'budget_remaining' => $budgetRemaining,
                ]
            ]);
        }

        // Tampilkan view dengan data transaksi dan statistik
        return view('dashboard.finance', compact('transactions', 'monthlyExpenses', 'monthlyIncome', 'budget', 'budgetUsedPercent', 'budgetRemaining'));
    }

    /**
     * Menyimpan transaksi baru.
     * 
     * Validasi input dan simpan transaksi baru ke database.
     * Pesan error menggunakan bahasa Indonesia yang ramah.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validasi input dengan pesan error Indonesia
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'sometimes|in:paid,pending',
        ], [
            'title.required' => 'Waduh, transaksinya buat apa nih? Judulnya diisi dulu ya! 😅',
            'category.required' => 'Kategorinya lupa dipilih nih! 😬',
            'amount.required' => 'Nominalnya berapa? Jangan kosong ya! 💸',
            'amount.min' => 'Masa nominalnya minus? Yang bener ah! 😆',
            'date.required' => 'Kapan nih transaksinya? Tanggalnya diisi ya! 📅',
        ]);

        // Set default status ke 'paid' jika tidak diisi
        $validated['status'] = $validated['status'] ?? 'paid';

        // Buat transaksi baru milik user yang login
        $transaction = Auth::user()->transactions()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mantap! Transaksi baru berhasil dicatat! 🤑',
            'transaction' => $transaction
        ]);
    }

    /**
     * Memperbarui transaksi yang ada.
     * 
     * Hanya pemilik transaksi yang dapat mengupdate transaksi miliknya.
     * 
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Transaction $transaction): \Illuminate\Http\JsonResponse
    {
        // Verifikasi kepemilikan: hanya pemilik yang bisa update
        if ($transaction->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Validasi input dengan pesan error Indonesia
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'sometimes|in:paid,pending',
        ], [
            'title.required' => 'Judulnya jangan dihapus dong, nanti lupa! 😅',
            'category.required' => 'Kategorinya harus tetap ada ya!',
            'amount.required' => 'Nominalnya jangan kosong dong! 💸',
            'amount.min' => 'Nominalnya ga boleh minus ya!',
            'date.required' => 'Tanggalnya jangan sampai kosong ya! 📅',
        ]);

        // Update data transaksi
        $transaction->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sip! Data transaksi berhasil diperbarui! 📝',
            'transaction' => $transaction
        ]);
    }

    /**
     * Menghapus transaksi.
     * 
     * Hanya pemilik transaksi yang dapat menghapus transaksi miliknya.
     * 
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Transaction $transaction): \Illuminate\Http\JsonResponse
    {
        // Verifikasi kepemilikan: hanya pemilik yang bisa hapus
        if ($transaction->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Hapus transaksi dari database
        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Oke, transaksi berhasil dihapus! 🗑️'
        ]);
    }
}
