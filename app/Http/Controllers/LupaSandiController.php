<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LupaSandiController extends Controller
{
    /**
     * Menampilkan form permintaan link reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.lupa-sandi');
    }

    /**
     * Mengirimkan email link reset password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kita akan mengirimkan link reset password menggunakan Password Facade
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Menampilkan form reset password (input password baru).
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-sandi')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Memproses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Reset password user
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Update password dengan hashing baru
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        // Jika berhasil, redirect ke login dengan pesan sukses
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika gagal, kembalikan dengan error
        return back()->withErrors(['email' => [__($status)]]);
    }
}
