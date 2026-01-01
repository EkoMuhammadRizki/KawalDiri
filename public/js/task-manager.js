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
                <td colspan="6" class="text-center py-5 text-muted">
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
                <td class="text-center">
                    <button class="btn btn-icon btn-sm text-danger hover-bg-danger-subtle" onclick="deleteTask(${task.id})">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-icon btn-sm text-primary hover-bg-primary-subtle" 
                            data-json='${JSON.stringify(task).replace(/'/g, "&apos;")}'
                            onclick="openEditTask(this)">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                </td>
            </tr>
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
    const taskId = formData.get('id');
    const taskData = {
        title: formData.get('title'),
        description: formData.get('description'),
        priority: formData.get('priority'),
        status: formData.get('status'),
        due_date: formData.get('due_date'),
    };

    const url = taskId ? `/tasks/${taskId}` : '/tasks';
    const method = taskId ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
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
                title: taskId ? 'Siap Merubah! 🛠️' : 'Mantap! 🎉',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
            if (modal) modal.hide();

            // Reset form
            form.reset();
            document.getElementById('taskId').value = ''; // Clear ID

            // Reload tasks
            window.location.reload();
        } else {
            throw new Error(data.message || 'Gagal menyimpan tugas');
        }
    } catch (error) {
        console.error('Error submitting task:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops! 😬',
            text: error.message || 'Terjadi kesalahan saat menyimpan tugas'
        });
    }
};

/**
 * Open Modal to Edit Task
 */
window.openEditTask = function (btn) {
    const data = JSON.parse(btn.getAttribute('data-json'));

    // Reset form first
    const form = document.getElementById('taskForm');
    form.reset();

    // Fill ID
    document.getElementById('taskId').value = data.id;

    // Fill Fields
    document.getElementById('taskName').value = data.title;
    document.getElementById('taskCategory').value = data.description; // Description used as Category
    document.getElementById('taskCategory').value = data.description; // Description used as Category
    document.getElementById('taskPriority').value = data.priority;
    document.getElementById('taskStatus').value = data.status;

    // Date (Handle YYYY-MM-DD format)
    if (data.due_date) {
        const dateDate = new Date(data.due_date);
        const yyyy = dateDate.getFullYear();
        const mm = String(dateDate.getMonth() + 1).padStart(2, '0');
        const dd = String(dateDate.getDate()).padStart(2, '0');
        document.getElementById('taskDueDate').value = `${yyyy}-${mm}-${dd}`;
    }

    // Update Modal Title & Button
    document.getElementById('taskModalLabel').textContent = 'Edit Tugas';
    document.querySelector('#taskModal .btn-modern-primary').textContent = 'Update Tugas';

    // Show Modal
    const modal = new bootstrap.Modal(document.getElementById('taskModal'));
    modal.show();

    // Reset modal on close/hide to default state (Create mode)
    document.getElementById('taskModal').addEventListener('hidden.bs.modal', function () {
        form.reset();
        document.getElementById('taskId').value = '';
        document.getElementById('taskModalLabel').textContent = 'Buat Tugas Baru';
        document.querySelector('#taskModal .btn-modern-primary').textContent = 'Simpan Tugas';
    }, { once: true });
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
        text: 'Tugas yang dihapus tidak dapat dikembalikan! Yakin? 🤔',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Aja!',
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
                text: data.message, // "Tugas berhasil dihapus! Satu beban berkurang. chaks! 😌"
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
            text: 'Duh, ada masalah saat menghapus tugas 😔'
        });
    }
};

// Initialize on page load
// Initialize on page load
window.initTaskManager = function () {
    console.log('✓ Task Manager JS Check');

    // Init logic if needed (e.g. specific listeners not handled inline)
    // Most task listeners are inline (onclick) which works fine with Swup replacement
    // But modal events need reattachment

    const taskModalEl = document.getElementById('taskModal');
    if (taskModalEl) {
        taskModalEl.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('taskForm');
            if (form) form.reset();
            const idInput = document.getElementById('taskId');
            if (idInput) idInput.value = '';
            const label = document.getElementById('taskModalLabel');
            if (label) label.textContent = 'Buat Tugas Baru';
            const btn = document.querySelector('#taskModal .btn-modern-primary');
            if (btn) btn.textContent = 'Simpan Tugas';
        });
    }
};

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('taskTableBody')) {
        window.initTaskManager();
    }
});
console.log('✓ Task Manager JS loaded');
});
