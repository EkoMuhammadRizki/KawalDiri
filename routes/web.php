<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Rute Web)
|--------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan rute web untuk aplikasi Anda.
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
// Menampilkan halaman login.
Route::get('/login', function () {
    return view('auth');
})->name('login');

// Menampilkan halaman registrasi (menggunakan view yang sama dengan login).
Route::get('/register', function () {
    return view('auth');
})->name('register');

// Proses logout user.
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ==========================================
// Rute Halaman Dashboard (Panel Pengguna)
// ==========================================
// Grup rute untuk fitur-fitur di dalam dashboard.
// Catatan: Nanti bisa ditambahkan middleware(['auth']) untuk keamanan.

// Halaman Utama Dashboard (Ringkasan)
Route::get('/dashboard', function () {
    return view('dashboard.index'); // Menampilkan view resources/views/dashboard/index.blade.php
})->name('dashboard');

// Halaman Manajer Tugas (To-Do List)
Route::get('/tasks', function () {
    return view('dashboard.tasks', ['filter' => request()->query('filter', 'all')]);
})->name('tasks');

// Halaman Pelacak Keuangan (Finance Tracker)
Route::get('/finance', function () {
    return view('dashboard.finance'); // Menampilkan view resources/views/dashboard/finance.blade.php
})->name('finance');

// Halaman Pengaturan (Settings)
Route::get('/settings', function () {
    return view('dashboard.settings'); // Menampilkan view resources/views/dashboard/settings.blade.php
})->name('settings');

// Halaman Bantuan & Dukungan (Help Center)
Route::get('/help', function () {
    return view('dashboard.help'); // Menampilkan view resources/views/dashboard/help.blade.php
})->name('help');

// ==========================================
// Rute Admin (Placeholder/Sementara)
// ==========================================
Route::prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    // Manajemen User
    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');
});
