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
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Halaman Manajer Tugas (To-Do List)
    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');

    // Halaman Pelacak Keuangan (Finance Tracker)
    Route::get('/finance', [App\Http\Controllers\TransactionController::class, 'index'])->name('finance');
    Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [App\Http\Controllers\TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [App\Http\Controllers\TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Dashboard Data API
    Route::get('/api/dashboard/productivity', [App\Http\Controllers\DashboardController::class, 'getProductivityData'])->name('dashboard.productivity');
    Route::get('/api/dashboard/expenses', [App\Http\Controllers\DashboardController::class, 'getExpenseData'])->name('dashboard.expenses');
    Route::get('/api/dashboard/activities', [App\Http\Controllers\DashboardController::class, 'getRecentActivities'])->name('dashboard.activities');

    // Halaman Pengaturan (Settings)
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'show'])->name('settings');

    // API endpoints untuk Settings
    Route::put('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/avatar', [App\Http\Controllers\SettingsController::class, 'updateAvatar'])->name('settings.avatar');
    Route::put('/settings/password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/preferences', [App\Http\Controllers\SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::put('/settings/notifications', [App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/budget', [App\Http\Controllers\SettingsController::class, 'updateBudget'])->name('settings.budget');
    Route::post('/settings/reset', [App\Http\Controllers\SettingsController::class, 'reset'])->name('settings.reset');

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
