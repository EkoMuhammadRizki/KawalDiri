<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the user's transactions.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->latest('date');

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search by title
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(10);

        // Calculate budget stats
        $user = Auth::user();
        $monthlyExpenses = $user->transactions()
            ->thisMonth()
            ->expense()
            ->sum('amount');

        $monthlyIncome = $user->transactions()
            ->thisMonth()
            ->income()
            ->sum('amount');

        $budget = $user->budget ?? 0;
        $budgetUsedPercent = $budget > 0 ? ($monthlyExpenses / $budget) * 100 : 0;
        $budgetRemaining = $budget - $monthlyExpenses;

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

        return view('dashboard.finance', compact('transactions', 'monthlyExpenses', 'monthlyIncome', 'budget', 'budgetUsedPercent', 'budgetRemaining'));
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'sometimes|in:paid,pending',
        ]);

        $validated['status'] = $validated['status'] ?? 'paid';

        $transaction = Auth::user()->transactions()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditambahkan!',
            'transaction' => $transaction
        ]);
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(Transaction $transaction)
    {
        // Pastikan transaction milik user yang sedang login
        if ($transaction->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus!'
        ]);
    }
}
