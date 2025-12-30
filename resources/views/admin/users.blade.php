@extends('layouts.app')

@section('title', 'User Management - KawalDiri')

@section('content')
<div class="page-header">
    <h1 class="page-title">👥 User Management</h1>
</div>

<!-- Filters -->
<div class="filters mb-6">
    <input type="text" class="form-input" placeholder="🔍 Cari user..." style="max-width: 300px;">
    <select class="filter-select">
        <option value="">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
    </select>
    <select class="filter-select">
        <option value="">Semua Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
</div>

<!-- Users Table -->
<div class="widget">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <th style="text-align: left; padding: var(--space-4); font-weight: 600; color: var(--text-muted); font-size: var(--text-sm);">USER</th>
                <th style="text-align: left; padding: var(--space-4); font-weight: 600; color: var(--text-muted); font-size: var(--text-sm);">EMAIL</th>
                <th style="text-align: left; padding: var(--space-4); font-weight: 600; color: var(--text-muted); font-size: var(--text-sm);">ROLE</th>
                <th style="text-align: left; padding: var(--space-4); font-weight: 600; color: var(--text-muted); font-size: var(--text-sm);">STATUS</th>
                <th style="text-align: right; padding: var(--space-4); font-weight: 600; color: var(--text-muted); font-size: var(--text-sm);">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: var(--space-4);">
                    <div class="flex items-center gap-3">
                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">J</div>
                        <div>
                            <div style="font-weight: 500;">John Doe</div>
                            <div class="text-muted text-sm">@johndoe</div>
                        </div>
                    </div>
                </td>
                <td style="padding: var(--space-4);">john@example.com</td>
                <td style="padding: var(--space-4);"><span class="badge badge-primary">User</span></td>
                <td style="padding: var(--space-4);"><span class="badge badge-success">🟢 Aktif</span></td>
                <td style="padding: var(--space-4); text-align: right;">
                    <button class="btn btn-icon btn-ghost" title="Nonaktifkan"><i data-lucide="lock"></i></button>
                    <button class="btn btn-icon btn-ghost" title="Edit"><i data-lucide="edit"></i></button>
                    <button class="btn btn-icon btn-ghost text-danger" title="Hapus" onclick="confirmDelete()"><i data-lucide="trash-2"></i></button>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: var(--space-4);">
                    <div class="flex items-center gap-3">
                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">S</div>
                        <div>
                            <div style="font-weight: 500;">Sarah Lee</div>
                            <div class="text-muted text-sm">@sarah</div>
                        </div>
                    </div>
                </td>
                <td style="padding: var(--space-4);">sarah@example.com</td>
                <td style="padding: var(--space-4);"><span class="badge badge-warning">Admin</span></td>
                <td style="padding: var(--space-4);"><span class="badge badge-success">🟢 Aktif</span></td>
                <td style="padding: var(--space-4); text-align: right;">
                    <button class="btn btn-icon btn-ghost" title="Nonaktifkan"><i data-lucide="lock"></i></button>
                    <button class="btn btn-icon btn-ghost" title="Edit"><i data-lucide="edit"></i></button>
                    <button class="btn btn-icon btn-ghost text-danger" title="Hapus" onclick="confirmDelete()"><i data-lucide="trash-2"></i></button>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: var(--space-4);">
                    <div class="flex items-center gap-3">
                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px; background: var(--neutral-400);">B</div>
                        <div>
                            <div style="font-weight: 500;">Bob Smith</div>
                            <div class="text-muted text-sm">@bobsmith</div>
                        </div>
                    </div>
                </td>
                <td style="padding: var(--space-4);">bob@example.com</td>
                <td style="padding: var(--space-4);"><span class="badge badge-primary">User</span></td>
                <td style="padding: var(--space-4);"><span class="badge badge-danger">🔴 Nonaktif</span></td>
                <td style="padding: var(--space-4); text-align: right;">
                    <button class="btn btn-icon btn-ghost" title="Aktifkan"><i data-lucide="unlock"></i></button>
                    <button class="btn btn-icon btn-ghost" title="Edit"><i data-lucide="edit"></i></button>
                    <button class="btn btn-icon btn-ghost text-danger" title="Hapus" onclick="confirmDelete()"><i data-lucide="trash-2"></i></button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between items-center p-4" style="border-top: 1px solid var(--border-color);">
        <span class="text-muted text-sm">Showing 1-10 of 1,245 users</span>
        <div class="flex gap-2">
            <button class="btn btn-ghost btn-sm">← Prev</button>
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-ghost btn-sm">2</button>
            <button class="btn btn-ghost btn-sm">3</button>
            <button class="btn btn-ghost btn-sm">Next →</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus User?',
            text: 'Data user akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Dihapus!', 'User berhasil dihapus.', 'success');
            }
        });
    }
</script>
@endpush