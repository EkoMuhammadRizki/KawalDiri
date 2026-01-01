<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings
     */
    public function show(): \Illuminate\View\View
    {
        return view('dashboard.settings');
    }

    /**
     * Update profile user (nama, username, phone)
     */
    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'user' => $user
        ]);
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Validasi password lama
        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Kata sandi saat ini salah.',
            ]);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diubah!'
        ]);
    }

    /**
     * Update preferensi tema & accent color
     */
    public function updatePreferences(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'theme_preference' => 'required|in:light,dark,system',
            'accent_color' => 'required|string|max:7', // Format hex color
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil diperbarui!',
            'preferences' => [
                'theme_preference' => $user->theme_preference,
                'accent_color' => $user->accent_color,
            ]
        ]);
    }

    /**
     * Update pengaturan notifikasi
     */
    public function updateNotifications(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_notifications' => 'required|boolean', // Kita gunakan kolom ini untuk "Notifikasi Pengumuman"
        ]);

        $user->update([
            'email_notifications' => $validated['email_notifications'],
            // Weekly reports kita set false atau biarkan default, karena sudah dihapus dari UI
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan notifikasi berhasil diperbarui!'
        ]);
    }

    /**
     * Update avatar user
     */
    public function updateAvatar(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'avatar' => 'required|integer|min:1|max:8',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil diperbarui!',
            'avatar' => $user->avatar
        ]);
    }

    /**
     * Reset semua pengaturan ke default
     */
    public function reset(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        // Reset hanya preferensi, bukan data pribadi
        $user->update([
            'theme_preference' => 'system',
            'accent_color' => '#6366f1',
            'email_notifications' => true,
            'weekly_reports' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil dikembalikan ke default!'
        ]);
    }

    /**
     * Update user budget
     */
    public function updateBudget(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'budget' => 'required|numeric|min:0',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggaran berhasil diperbarui!',
            'budget' => $user->budget
        ]);
    }
}
