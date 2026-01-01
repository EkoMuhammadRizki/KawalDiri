<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->tasks()->latest();
        $filter = $request->query('filter', 'all');

        // Filter by status or priority
        if ($filter !== 'all') {
            // Check if filter is status
            if (in_array($filter, ['pending', 'completed'])) {
                $query->where('status', $filter);
            }
        }

        // Additional filters if provided explicitly (api/fallback)
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Search by title
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tasks' => $tasks
            ]);
        }

        return view('dashboard.tasks', compact('tasks', 'filter'));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = Auth::user()->tasks()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan!',
            'task' => $task
        ]);
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Toggle status jika request hanya toggle
        if ($request->has('toggle_status') && $request->toggle_status) {
            if ($task->status === 'pending') {
                $task->markAsCompleted();
            } else {
                $task->markAsPending();
            }

            return response()->json([
                'success' => true,
                'message' => 'Status tugas berhasil diubah!',
                'task' => $task->fresh()
            ]);
        }

        // Update normal
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
            'message' => 'Tugas berhasil diperbarui!',
            'task' => $task->fresh()
        ]);
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus!'
        ]);
    }
}
