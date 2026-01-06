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
Route::get('/', function () {
    return view('home');
})->name('home');

// ==========================================
// Rute Otentikasi (Login & Register)
// ==========================================
Route::get('/login', function () {
    return view('auth');
})->name('login');

Route::get('/register', function () {
    return view('auth');
})->name('register');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/lupa-sandi', [App\Http\Controllers\LupaSandiController::class, 'showLinkRequestForm'])->name('lupa-sandi');
Route::post('/lupa-sandi/email', [App\Http\Controllers\LupaSandiController::class, 'sendResetLinkEmail'])->name('lupa-sandi.email');
Route::get('/reset-sandi/{token}', [App\Http\Controllers\LupaSandiController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-sandi', [App\Http\Controllers\LupaSandiController::class, 'reset'])->name('password.update');

// ==========================================
// Rute Bagian Halaman Dashboard (Panel Pengguna)
// ==========================================
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

    // Notification Routes
    Route::post('/notifications/mark-read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Halaman Pengaturan (Settings)
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'show'])->name('settings');
    Route::put('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/avatar', [App\Http\Controllers\SettingsController::class, 'updateAvatar'])->name('settings.avatar');
    Route::put('/settings/password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/preferences', [App\Http\Controllers\SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::put('/settings/notifications', [App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/budget', [App\Http\Controllers\SettingsController::class, 'updateBudget'])->name('settings.budget');
    Route::post('/settings/reset', [App\Http\Controllers\SettingsController::class, 'reset'])->name('settings.reset');

    // Halaman Bantuan & Dukungan (Help Center)
    Route::get('/help', [App\Http\Controllers\HelpController::class, 'index'])->name('help');
    Route::post('/help/send-message', [App\Http\Controllers\HelpController::class, 'sendMessage'])->name('help.send');
    Route::get('/help/search', [App\Http\Controllers\HelpController::class, 'searchFaq'])->name('help.search');
});

// ==========================================
// Rute BagianAdmin (Admin Panel)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    // Protected Admin Routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Manajemen Users (Using new UserController)
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Pusat Komunikasi (Siaran Pengumuman)
        Route::get('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store');
    });
});
