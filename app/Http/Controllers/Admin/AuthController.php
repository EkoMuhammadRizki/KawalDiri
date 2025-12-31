<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Cek apakah user adalah admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun ini bukan akun administrator.',
                ]);
            }

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // Login gagal
        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
