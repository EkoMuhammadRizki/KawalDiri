<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * DashboardController
 * 
 * Controller untuk mengelola halaman dasbor utama pengguna.
 * Menyediakan data statistik, grafik produktivitas, pengeluaran, dan aktivitas terbaru.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor utama.
     * 
     * Mengambil data statistik meliputi:
     * - Jumlah total tugas, tugas selesai, tugas tertunda, dan tugas terlewat
     * - Pemasukan dan pengeluaran bulan ini
     * - Saldo total (pemasukan - pengeluaran)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Hitung statistik tugas
        $totalTasks = $user->tasks()->count();                    // Total semua tugas
        $completedTasks = $user->tasks()->completed()->count();   // Tugas yang sudah selesai
        $pendingTasks = $user->tasks()->pending()->count();       // Tugas yang masih tertunda
        $overdueTasks = $user->tasks()->overdue()->count();       // Tugas yang sudah melewati tenggat

        // Hitung statistik keuangan bulan ini
        $monthlyIncome = $user->transactions()->thisMonth()->income()->sum('amount');     // Total pemasukan
        $monthlyExpenses = $user->transactions()->thisMonth()->expense()->sum('amount'); // Total pengeluaran
        $totalBalance = $monthlyIncome - $monthlyExpenses;                               // Saldo bersih

        // Kirim data ke view dasbor
        return view('dashboard.index', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'overdueTasks',
            'monthlyIncome',
            'monthlyExpenses',
            'totalBalance'
        ));
    }

    /**
     * Mengambil data produktivitas untuk grafik (4 minggu terakhir).
     * 
     * Data digunakan untuk menampilkan grafik batang/garis yang menunjukkan
     * jumlah tugas yang diselesaikan per minggu dalam 4 minggu terakhir.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductivityData()
    {
        $user = Auth::user();
        $weeks = [];      // Label minggu untuk sumbu X grafik
        $completed = [];  // Jumlah tugas selesai untuk sumbu Y grafik

        // Loop 4 minggu terakhir (dari minggu ke-3 sebelumnya sampai minggu ini)
        for ($i = 3; $i >= 0; $i--) {
            // Tentukan rentang waktu untuk setiap minggu
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();

            // Format label dalam bahasa Indonesia (contoh: "Minggu 1 Jan 2026")
            $date = Carbon::now()->subWeeks($i)->locale('id');
            $weeks[] = 'Minggu ' . $date->weekOfMonth . ' ' . $date->translatedFormat('M Y');

            // Hitung jumlah tugas yang diselesaikan dalam rentang minggu tersebut
            $completed[] = $user->tasks()
                ->whereBetween('completed_at', [$weekStart, $weekEnd])
                ->count();
        }

        // Kembalikan data dalam format JSON untuk Chart.js
        return response()->json([
            'labels' => $weeks,
            'data' => $completed
        ]);
    }

    /**
     * Mengambil data pengeluaran berdasarkan kategori untuk grafik donat.
     * 
     * Data digunakan untuk menampilkan grafik donat yang menunjukkan
     * distribusi pengeluaran berdasarkan kategori dalam bulan ini.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExpenseData()
    {
        $user = Auth::user();

        // Ambil pengeluaran bulan ini, kelompokkan berdasarkan kategori
        $expenses = $user->transactions()
            ->thisMonth()
            ->expense()
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Pisahkan nama kategori dan jumlah untuk grafik
        $categories = $expenses->pluck('category')->toArray();
        $amounts = $expenses->pluck('total')->toArray();

        // Kembalikan data dalam format JSON untuk Chart.js
        return response()->json([
            'labels' => $categories,
            'data' => $amounts
        ]);
    }

    /**
     * Mengambil aktivitas terbaru (tugas dan transaksi digabung).
     * 
     * Menggabungkan tugas dan transaksi terbaru pengguna, mengurutkan
     * berdasarkan waktu terbaru, dan mengembalikan data dengan paginasi.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentActivities(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);  // Halaman saat ini (default: 1)
        $perPage = 5;                         // Jumlah item per halaman

        // Ambil 20 tugas terbaru dan format menjadi struktur aktivitas
        $recentTasks = $user->tasks()
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($task) {
                return [
                    'type' => 'task',
                    'title' => $task->title,
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'date' => $task->created_at->diffForHumans(),      // Format: "5 menit yang lalu"
                    'timestamp' => $task->created_at->timestamp,       // Untuk sorting
                    'icon' => 'task_alt',
                    'color' => $task->status === 'completed' ? 'success' : 'primary'
                ];
            });

        // Ambil 20 transaksi terbaru dan format menjadi struktur aktivitas
        $recentTransactions = $user->transactions()
            ->latest('date')
            ->limit(20)
            ->get()
            ->map(function ($transaction) {
                return [
                    'type' => 'transaction',
                    'title' => $transaction->title,
                    'category' => $transaction->category,
                    'amount' => 'Rp ' . number_format($transaction->amount, 0, ',', '.'),
                    'transaction_type' => $transaction->type,
                    'date' => $transaction->date->diffForHumans(),
                    'timestamp' => $transaction->date->timestamp,
                    'icon' => $transaction->type === 'income' ? 'trending_up' : 'trending_down',
                    'color' => $transaction->type === 'income' ? 'success' : 'danger'
                ];
            });

        // Gabungkan tugas dan transaksi, urutkan berdasarkan waktu terbaru
        $allActivities = $recentTasks->merge($recentTransactions)->sortByDesc('timestamp')->values();

        // Paginasi manual
        $total = $allActivities->count();
        $paginatedItems = $allActivities->forPage($page, $perPage)->values();
        $hasMore = ($page * $perPage) < $total;  // Cek apakah masih ada halaman berikutnya

        // Kembalikan data dengan metadata paginasi
        return response()->json([
            'activities' => $paginatedItems,
            'pagination' => [
                'current_page' => (int)$page,
                'per_page' => $perPage,
                'has_more' => $hasMore,
                'total' => $total
            ]
        ]);
    }
}
