<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * IsAdmin Middleware - Proteksi Route Khusus Administrator
 * 
 * Middleware ini digunakan untuk melindungi route-route admin dashboard.
 * Hanya user dengan role = 'admin' yang boleh mengakses route yang dilindungi.
 * 
 * Diterapkan di: routes/web.php pada group Route::middleware(['auth', 'isAdmin'])
 */
class IsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * Method ini dijalankan sebelum request mencapai controller.
     * Alur pengecekan:
     * 1. Cek apakah user sudah login (autentikasi)
     * 2. Cek apakah user yang login memiliki role = 'admin' (autorisasi)
     * 3. Jika gagal, redirect/abort dengan pesan error
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // **PENGECEKAN 1: Apakah user sudah login?**
        // Jika belum login, redirect ke halaman login admin
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        // **PENGECEKAN 2: Apakah user memiliki role 'admin'?**
        // Jika role bukan 'admin', tolak akses dengan HTTP 403 Forbidden
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan administrator.');
        }

        // Jika semua pengecekan lolos, lanjutkan ke controller
        return $next($request);
    }
}
