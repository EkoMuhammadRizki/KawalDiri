<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * AuthController - Menangani Proses Otentikasi Pengguna (User)
 * 
 * Controller ini bertanggung jawab untuk:
 * - Login: Memverifikasi kredensial dan membuat sesi pengguna
 * - Register: Mendaftarkan pengguna baru ke sistem
 * - Logout: Menghapus sesi pengguna dan membatalkan token
 */
class AuthController extends Controller
{
    /**
     * Login - Memproses login pengguna
     * 
     * Method ini menerima email dan password dari form login,
     * memvalidasinya, kemudian mencoba autentikasi menggunakan Laravel Auth.
     * Jika berhasil, user akan dialihkan ke dashboard. Jika gagal, akan
     * dikembalikan ke halaman login dengan pesan error.
     * 
     * @param Request $request - Berisi email, password, dan remember checkbox
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input: Email harus valid, password wajib diisi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Mencoba login dengan kredensial yang diberikan
        // Parameter kedua ($request->remember) mengaktifkan fitur "Ingat Saya"
        if (Auth::attempt($credentials, $request->remember)) {
            // Regenerasi session ID untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Redirect ke halaman yang dimaksud (default: dashboard)
            return redirect()->intended('dashboard');
        }

        // Jika login gagal, kembalikan pesan error dan input email sebelumnya
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Register - Mendaftarkan pengguna baru
     * 
     * Method ini memvalidasi data pendaftaran (nama, email, password),
     * membuat user baru di database, kemudian langsung login otomatis
     * dan redirect ke dashboard.
     * 
     * @param Request $request - Berisi name, email, dan password
     * @return RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi data registrasi
        // - name: Required, maksimal 255 karakter
        // - email: Harus unique di tabel users
        // - password: Minimal 8 karakter
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru dengan data yang sudah divalidasi
        // Password di-hash menggunakan bcrypt untuk keamanan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);

        // Redirect ke dashboard
        return redirect('/dashboard');
    }

    /**
     * Logout - Mengeluarkan pengguna dari sistem
     * 
     * Method ini logout user, menghapus session, dan regenerasi
     * CSRF token untuk keamanan. User akan dialihkan ke halaman utama.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout user dari sistem
        Auth::logout();

        // Invalidasi/hapus semua data session
        $request->session()->invalidate();

        // Regenerasi CSRF token untuk mencegah CSRF attack
        $request->session()->regenerateToken();

        // Redirect ke halaman home/landing page
        return redirect('/');
    }
}
