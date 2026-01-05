<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * TaskController
 * 
 * Controller untuk mengelola tugas pengguna.
 * Menyediakan operasi CRUD: tampilkan daftar, buat baru, update, dan hapus tugas.
 */
class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas pengguna.
     * 
     * Mendukung filter berdasarkan status (pending/completed),
     * pencarian berdasarkan judul, dan paginasi.
     * 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Ambil tugas user yang login, urutkan dari terbaru
        $query = Auth::user()->tasks()->latest();
        $filter = $request->query('filter', 'all');

        // Filter berdasarkan status jika dipilih
        if ($filter !== 'all') {
            if (in_array($filter, ['pending', 'completed'])) {
                $query->where('status', $filter);
            }
        }

        // Filter tambahan via parameter (untuk API atau fallback)
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Pencarian berdasarkan judul tugas
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Paginasi: 5 tugas per halaman
        $tasks = $query->paginate(5);

        // Jika request dari API (AJAX), kembalikan JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tasks' => $tasks
            ]);
        }

        // Tampilkan view dengan data tugas
        return view('dashboard.tasks', compact('tasks', 'filter'));
    }

    /**
     * Menyimpan tugas baru.
     * 
     * Validasi input dan simpan tugas baru ke database.
     * Pesan error menggunakan bahasa Indonesia yang ramah.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validasi input dengan pesan error Indonesia
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'nullable|in:pending,completed',
        ], [
            'title.required' => 'Waduh, judul tugasnya lupa diisi nih! 😅',
            'priority.required' => 'Seberapa penting nih? Prioritasnya dipilih dulu ya!',
            'due_date.required' => 'Kapan harus selesai? Tenggat waktunya diisi ya! 📅',
            'due_date.after_or_equal' => 'Masa deadline-nya di masa lalu? Move on dong! 😆',
        ]);

        // Buat tugas baru milik user yang login
        $task = Auth::user()->tasks()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Siap! Tugas baru berhasil ditambahkan! 🫡',
            'task' => $task
        ]);
    }

    /**
     * Memperbarui tugas yang ada.
     * 
     * Mendukung dua mode:
     * 1. Toggle status (pending <-> completed) - jika parameter toggle_status=true
     * 2. Update data tugas secara lengkap
     * 
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task): \Illuminate\Http\JsonResponse
    {
        // Verifikasi kepemilikan: hanya pemilik yang bisa update
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Mode 1: Toggle status saja (klik checkbox selesai/belum)
        if ($request->has('toggle_status') && $request->toggle_status) {
            if ($task->status === 'pending') {
                $task->markAsCompleted();  // Tandai sebagai selesai
            } else {
                $task->markAsPending();     // Kembalikan ke tertunda
            }

            return response()->json([
                'success' => true,
                'message' => 'Mantap! Status tugas berhasil diupdate! 🎉',
                'task' => $task->fresh()
            ]);
        }

        // Mode 2: Update data tugas secara lengkap
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'due_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:pending,completed',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Oke, tugas berhasil diperbarui! 👌',
            'task' => $task->fresh()
        ]);
    }

    /**
     * Menghapus tugas.
     * 
     * Hanya pemilik tugas yang dapat menghapus tugas miliknya.
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task): \Illuminate\Http\JsonResponse
    {
        // Verifikasi kepemilikan: hanya pemilik yang bisa hapus
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Hapus tugas dari database
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus! Satu beban berkurang. chaks! 😌'
        ]);
    }
}
