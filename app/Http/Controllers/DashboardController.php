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

            $weeks[] = 'Week ' . (4 - $i);
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
    public function getRecentActivities()
    {
        $user = Auth::user();

        // Get last 5 tasks
        $recentTasks = $user->tasks()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($task) {
                return [
                    'type' => 'task',
                    'title' => $task->title,
                    'priority' => $task->priority,
                    'status' => $task->status,
                    'date' => $task->created_at->diffForHumans(),
                    'timestamp' => $task->created_at->timestamp, // For sorting
                    'icon' => 'task_alt',
                    'color' => $task->status === 'completed' ? 'success' : 'primary'
                ];
            });

        // Get last 5 transactions
        $recentTransactions = $user->transactions()
            ->latest('date')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                return [
                    'type' => 'transaction',
                    'title' => $transaction->title,
                    'category' => $transaction->category,
                    'amount' => 'Rp ' . number_format($transaction->amount, 0, ',', '.'),
                    'transaction_type' => $transaction->type,
                    'date' => $transaction->date->diffForHumans(),
                    'timestamp' => $transaction->date->timestamp, // For sorting
                    'icon' => $transaction->type === 'income' ? 'trending_up' : 'trending_down',
                    'color' => $transaction->type === 'income' ? 'success' : 'danger'
                ];
            });

        // Merge and sort by timestamp
        $activities = $recentTasks->merge($recentTransactions)
            ->sortByDesc('timestamp')
            ->take(10)
            ->values();

        return response()->json([
            'activities' => $activities
        ]);
    }
}
