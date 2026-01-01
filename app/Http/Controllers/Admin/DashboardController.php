<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Admin DashboardController - Menangani Dashboard & Manajemen User Admin
 * 
 * Controller ini bertanggung jawab untuk:
 * - Menampilkan statistik dashboard admin (total users, new users, dll)
 * - Menampilkan daftar user dengan fitur pencarian dan filter
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik
     * 
     * Method ini mengambil data statistik dari database:
     * - Total user (non-admin)
     * - Total admin
     * - User baru bulan ini
     * - User aktif (registrasi dalam 30 hari terakhir)
     * 
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        // Mengumpulkan statistik untuk dashboard admin
        $stats = [
            // Hitung total user dengan role = 'user' (bukan admin)
            'total_users' => User::where('role', 'user')->count(),

            // Hitung total user dengan role = 'admin'
            'total_admins' => User::where('role', 'admin')->count(),

            // Hitung user baru yang terdaftar di bulan dan tahun saat ini
            'new_users_this_month' => User::where('role', 'user')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            // Hitung user yang registrasi dalam 30 hari terakhir
            'active_users' => User::where('role', 'user')
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
        ];

        // Kirim data stats ke view dashboard admin
        return view('admin.dashboard.index', compact('stats'));
    }
}
