<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Admin AuthController - Menangani Otentikasi Administrator
 * 
 * Controller khusus untuk login/logout admin. Memiliki validasi tambahan
 * untuk memastikan hanya user dengan role 'admin' yang bisa akses.
 */
class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     * 
     * Menampilkan form login khusus untuk administrator di route /admin/login.
     * Halaman ini terpisah dari login user biasa.
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     * 
     * Memvalidasi email/username dan password, kemudian melakukan autentikasi.
     * Mendukung login dengan EMAIL atau USERNAME secara otomatis.
     * Jika berhasil login, dilakukan pengecekan tambahan pada kolom 'role'.
     * Hanya user dengan role = 'admin' yang diizinkan masuk ke dashboard admin.
     * 
     * @param Request $request - Berisi email/username, password, dan checkbox remember
     * @return RedirectResponse
     * @throws ValidationException - Jika kredensial salah atau bukan admin
     */
    public function login(Request $request)
    {
        // Validasi input login: email/username wajib diisi, password wajib diisi
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Ambil input dari user
        $login = $request->input('email');
        $password = $request->input('password');

        // Deteksi apakah input adalah email atau username
        // Jika mengandung '@', anggap sebagai email, jika tidak maka username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Siapkan credentials untuk login
        $credentials = [
            $fieldType => $login,
            'password' => $password
        ];

        // Coba login dengan kredensial yang diberikan
        // Parameter kedua mengecek apakah "remember me" dicentang
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // **VALIDASI KHUSUS ADMIN**
            // Cek apakah user yang login memiliki role 'admin'
            if (Auth::user()->role !== 'admin') {
                // Jika bukan admin, logout paksa dan lempar error
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun ini bukan akun administrator.',
                ]);
            }

            // Regenerate session ID untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Redirect ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // Login gagal (email/username/password salah)
        throw ValidationException::withMessages([
            'email' => 'Email/Username atau password salah.',
        ]);
    }

    /**
     * Logout admin
     * 
     * Mengeluarkan admin dari sistem, menghapus session, dan
     * regenerasi CSRF token. Admin diarahkan kembali ke halaman login admin.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout dari sistem
        Auth::logout();

        // Invalidasi semua data session
        $request->session()->invalidate();

        // Regenerasi CSRF token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login admin
        return redirect()->route('admin.login');
    }
}
