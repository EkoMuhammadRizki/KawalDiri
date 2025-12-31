<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function index()
    {
        // Statistik untuk dashboard
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'new_users_this_month' => User::where('role', 'user')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'active_users' => User::where('role', 'user')
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }

    /**
     * Tampilkan daftar user
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search Filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users', compact('users'));
    }
}
