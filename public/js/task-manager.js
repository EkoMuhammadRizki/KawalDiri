/**
 * Task Manager JavaScript
 * Mengelola interaksi antara UI dan backend untuk fitur Task Manager
 */

// Helper function untuk get CSRF token
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/**
 * Load tasks from server
 */
async function loadTasks(filters = {}) {
    try {
        const params = new URLSearchParams(filters);
        const response = await fetch(`/tasks?${params}`, {
            headers: {
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            renderTasks(data.tasks);
            console.log('✓ Tasks loaded:', data.tasks.data.length);
        }
    } catch (error) {
        console.error('Error loading tasks:', error);
    }
}

/**
 * Render tasks to table
 */
function renderTasks(tasksData) {
    const tbody = document.getElementById('taskTableBody');
    if (!tbody) return;

    if (tasksData.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" style="width: 150px; opacity: 0.5">
                    <p class="mt-3">Belum ada tugas</p>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    tasksData.data.forEach(task => {
        const priorityBadge = {
            'low': '<span class="badge bg-success-subtle text-success">Low</span>',
            'medium': '<span class="badge bg-warning-subtle text-warning">Medium</span>',
            'high': '<span class="badge bg-danger-subtle text-danger">High</span>'
        }[task.priority];

        const statusClass = task.status === 'completed' ? 'text-decoration-line-through text-muted' : 'fw-bold';
        const checkIcon = task.status === 'completed' ? 'check_circle' : 'radio_button_unchecked';
        const checkColor = task.status === 'completed' ? 'text-success' : 'text-secondary';

        html += `
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <span class="material-symbols-outlined cursor-pointer ${checkColor} hover-scale" 
                              onclick="toggleTaskStatus(${task.id})">
                            ${checkIcon}
                        </span>
                        <div>
                            <h6 class="mb-0 ${statusClass}">${task.title}</h6>
                            <small class="text-muted">${task.description || ''}</small>
                        </div>
                    </div>
                </td>
                <td>${priorityBadge}</td>
                <td>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <span class="material-symbols-outlined fs-6">calendar_today</span>
                        ${new Date(task.due_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                    </div>
                </td>
                <td>
                    <span class="badge bg-${task.status === 'completed' ? 'success' : 'secondary'}-subtle text-${task.status === 'completed' ? 'success' : 'secondary'} text-capitalize">
                        ${task.status}
                    </span>
                </td>
                <td class="text-end">
                    <button class="btn btn-icon btn-sm text-danger hover-bg-danger-subtle" onclick="deleteTask(${task.id})">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

/**
 * Submit new task via modal
 */
window.submitTask = async function () {
    console.log('submitTask called');

    const form = document.getElementById('taskForm');
    if (!form) {
        console.error('Task form not found');
        return;
    }

    const formData = new FormData(form);
    const taskData = {
        title: formData.get('title'),
        description: formData.get('description'),
        priority: formData.get('priority'),
        due_date: formData.get('due_date'),
    };

    try {
        const response = await fetch('/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify(taskData)
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
            if (modal) modal.hide();

            // Reset form
            form.reset();

            // Reload tasks (akan reload halaman atau update table)
            window.location.reload();
        } else {
            throw new Error(data.message || 'Gagal menambahkan tugas');
        }
    } catch (error) {
        console.error('Error submitting task:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menambahkan tugas'
        });
    }
};

/**
 * Toggle task status (complete/pending)
 */
window.toggleTaskStatus = async function (taskId) {
    try {
        const response = await fetch(`/tasks/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ toggle_status: true })
        });

        const data = await response.json();

        if (data.success) {
            // Reload page untuk update UI
            window.location.reload();
        }
    } catch (error) {
        console.error('Error toggling task status:', error);
    }
};

/**
 * Delete task with confirmation
 */
window.deleteTask = async function (taskId) {
    const result = await Swal.fire({
        title: 'Hapus Tugas?',
        text: 'Tugas yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(`/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Reload page
            window.location.reload();
        }
    } catch (error) {
        console.error('Error deleting task:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menghapus tugas'
        });
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    console.log('✓ Task Manager JS loaded');
});
