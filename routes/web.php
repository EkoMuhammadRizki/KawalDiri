<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Rute Web)
|--------------------------------------------------------------------------
|
| Di sini adalah tempat mendaftarkan rute web untuk aplikasi.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditetapkan ke grup middleware "web".
|
*/

// ==========================================
// Halaman Utama (Landing Page)
// ==========================================
// Menampilkan halaman depan website saat user pertama kali berkunjung.
Route::get('/', function () {
    return view('home');
})->name('home');

// ==========================================
// Rute Otentikasi (Login & Register)
// ==========================================
// Menampilkan halaman login & register (Satu view 'auth')
Route::get('/login', function () {
    return view('auth');
})->name('login');

Route::get('/register', function () {
    return view('auth');
})->name('register');

// Proses Login & Register
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// ==========================================
// Rute Halaman Dashboard (Panel Pengguna)
// ==========================================
// Grup rute untuk fitur-fitur di dalam dashboard.
// Catatan: Nanti bisa ditambahkan middleware(['auth']) untuk keamanan.

// Grup rute untuk fitur-fitur di dalam dashboard.
Route::middleware(['auth'])->group(function () {
    // Halaman Utama Dashboard (Ringkasan)
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Halaman Manajer Tugas (To-Do List)
    Route::get('/tasks', function () {
        return view('dashboard.tasks', ['filter' => request()->query('filter', 'all')]);
    })->name('tasks');

    // Halaman Pelacak Keuangan (Finance Tracker)
    Route::get('/finance', function () {
        return view('dashboard.finance');
    })->name('finance');

    // Halaman Pengaturan (Settings)
    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('settings');

    // Halaman Bantuan & Dukungan (Help Center)
    Route::get('/help', function () {
        return view('dashboard.help');
    })->name('help');
});

// ==========================================
// Rute Admin (Admin Panel)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes (Tidak perlu login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    // Protected Admin Routes (Harus login sebagai admin)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Manajemen Users
        Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
    });
});
