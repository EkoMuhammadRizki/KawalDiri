<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LupaSandiController extends Controller
{
    /**
     * Menampilkan form reset password langsung (tanpa email).
     */
    public function showLinkRequestForm()
    {
        return view('auth.lupa-sandi');
    }

    /**
     * Langsung reset password tanpa kirim email.
     * User input: email + password baru
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password baru wajib diisi!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika email tidak ditemukan
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar di sistem kami.',
            ]);
        }

        // Update password langsung
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }

    /**
     * Method ini tidak digunakan lagi (dihapus alur email)
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Redirect ke lupa sandi karena tidak pakai token lagi
        return redirect()->route('lupa-sandi');
    }

    /**
     * Method ini tidak digunakan lagi (dihapus alur email)
     */
    public function reset(Request $request)
    {
        // Redirect ke lupa sandi karena tidak pakai token lagi
        return redirect()->route('lupa-sandi');
    }
}
