<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Get all notifications sent by admin (conceptually, actually we query the notifications table generally, 
        // but for now we just show the form and maybe history if we want)
        // Since Laravel's notifications table is polymorphic, querying "all sent announcements" is a bit manual 
        // unless we log them separately. For now, we'll just show the form.
        return view('admin.announcements.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Kirim notifikasi ke semua user yang role-nya 'user' DAN mengaktifkan notifikasi
        $users = User::where('role', 'user')
            ->where('email_notifications', true) // Hanya kirim ke yang mengaktifkan notifikasi
            ->get();

        Notification::send($users, new AdminAnnouncement($request->title, $request->message));

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil disiarkan ke semua pengguna.');
    }
}
