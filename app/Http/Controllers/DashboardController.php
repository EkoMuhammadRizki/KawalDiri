<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        $user = Auth::user();

        // Overview statistics
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->completed()->count();
        $pendingTasks = $user->tasks()->pending()->count();
        $overdueTasks = $user->tasks()->overdue()->count();

        $monthlyIncome = $user->transactions()->thisMonth()->income()->sum('amount');
        $monthlyExpenses = $user->transactions()->thisMonth()->expense()->sum('amount');
        $totalBalance = $monthlyIncome - $monthlyExpenses;

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
     * Get productivity data for chart (last 4 weeks).
     */
    public function getProductivityData()
    {
        $user = Auth::user();
        $weeks = [];
        $completed = [];

        // Get data for last 4 weeks
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();

            $date = Carbon::now()->subWeeks($i)->locale('id');
            // Example: Minggu 1 Jan 2026
            $weeks[] = 'Minggu ' . $date->weekOfMonth . ' ' . $date->translatedFormat('M Y');
            $completed[] = $user->tasks()
                ->whereBetween('completed_at', [$weekStart, $weekEnd])
                ->count();
        }

        return response()->json([
            'labels' => $weeks,
            'data' => $completed
        ]);
    }

    /**
     * Get expense data by category for chart (current month).
     */
    public function getExpenseData()
    {
        $user = Auth::user();

        $expenses = $user->transactions()
            ->thisMonth()
            ->expense()
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $categories = $expenses->pluck('category')->toArray();
        $amounts = $expenses->pluck('total')->toArray();

        return response()->json([
            'labels' => $categories,
            'data' => $amounts
        ]);
    }

    /**
     * Get recent activities (tasks and transactions combined).
     */
    public function getRecentActivities(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);
        $perPage = 5;

        // Get a pool of recent items (e.g., 20 from each to ensure enough data for pagination)
        // Note: For deep pagination this is not efficient, but for "Recent Activities" it's acceptable.

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
                    'date' => $task->created_at->diffForHumans(),
                    'timestamp' => $task->created_at->timestamp,
                    'icon' => 'task_alt',
                    'color' => $task->status === 'completed' ? 'success' : 'primary'
                ];
            });

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

        // Merge and sort
        $allActivities = $recentTasks->merge($recentTransactions)->sortByDesc('timestamp')->values();

        // Manual Pagination
        $total = $allActivities->count();
        $paginatedItems = $allActivities->forPage($page, $perPage)->values();

        // Calculate pagination metadata
        $hasMore = ($page * $perPage) < $total;

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
