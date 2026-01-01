@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola pengguna dan administrator sistem')

@section('content')
<div class="container-fluid">

    <!-- Filter & Search -->
    <form action="{{ route('admin.users') }}" method="GET" class="row mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <span class="material-icons-round text-muted">search</span>
                </span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari user..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" disabled title="Fitur ini belum tersedia (kolom status tidak ada di DB)">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

    </form>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Users Table Card -->
    <div class="stats-card p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: #F9FAFB; border-bottom: 2px solid #E5E7EB;">
                    <tr>
                        <th class="px-4 py-3 text-muted text-uppercase" style="font-size: 0.75rem; font-weight: 600;">User</th>
                        <th class="px-4 py-3 text-muted text-uppercase" style="font-size: 0.75rem; font-weight: 600;">Email</th>
                        <th class="px-4 py-3 text-muted text-uppercase" style="font-size: 0.75rem; font-weight: 600;">Role</th>
                        <th class="px-4 py-3 text-muted text-uppercase" style="font-size: 0.75rem; font-weight: 600;">Status</th>
                        <th class="px-4 py-3 text-muted text-uppercase text-end" style="font-size: 0.75rem; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle {{ $user->role == 'admin' ? 'bg-warning' : 'bg-primary' }} text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role == 'admin')
                            <span class="badge" style="background-color: rgba(245, 158, 11, 0.1); color: #F59E0B; font-weight: 600;">Admin</span>
                            @else
                            <span class="badge" style="background-color: rgba(67, 56, 202, 0.1); color: #4338CA; font-weight: 600;">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-success">🟢 Aktif</span>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <button class="btn btn-sm btn-light text-danger" title="Hapus" onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
                                <span class="material-icons-round" style="font-size: 18px;">delete</span>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-4 border-top">
            <small class="text-muted">Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</small>
            <div>
                {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Hapus User?',
            text: `User "${userName}" akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush