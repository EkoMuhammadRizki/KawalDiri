@extends('layouts.app')

@section('title', 'Pengelola Tugas - KawalDiri')

@section('header_left')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb small fw-medium mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item active text-dark" aria-current="page">Manajer Tugas</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <header class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-black mb-0" style="font-weight: 900; letter-spacing: -1px;">Pengelola Tugas</h2>
        </div>
        <button class="btn btn-primary-custom d-none d-md-flex align-items-center gap-2 rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
            <span class="material-symbols-outlined fs-5">add</span>
            <span>Tugas Baru</span>
        </button>
    </header>

    <!-- Filters & Search -->
    <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-6">
            <!-- Tab Navigasi Filter: Menggunakan parameter 'filter' dari URL untuk menentukan state aktif -->
            <ul class="nav nav-underline gap-4">
                <li class="nav-item">
                    <a class="nav-link py-3 px-0 cursor-pointer {{ $filter == 'all' ? 'active border-primary' : 'border-transparent text-muted' }}"
                        href="{{ route('tasks', ['filter' => 'all']) }}">Semua Tugas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 px-0 cursor-pointer {{ $filter == 'pending' ? 'active border-primary' : 'border-transparent text-muted' }}"
                        href="{{ route('tasks', ['filter' => 'pending']) }}">Tertunda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 px-0 cursor-pointer {{ $filter == 'completed' ? 'active border-primary' : 'border-transparent text-muted' }}"
                        href="{{ route('tasks', ['filter' => 'completed']) }}">Selesai</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><span class="material-symbols-outlined text-muted">search</span></span>
                <input type="text" class="form-control border-start-0 rounded-end-3 py-2" placeholder="Cari tugas...">
            </div>
        </div>
    </div>

    <!-- Task List Card -->
    <div class="task-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;"></th>
                        <th>Detail Tugas</th>
                        <th style="width: 150px;">Prioritas</th>
                        <th style="width: 200px;">Tenggat Waktu</th>
                        <th class="text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="taskTableBody">
                    @forelse($tasks as $task)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="material-symbols-outlined cursor-pointer {{ $task->status === 'completed' ? 'text-success' : 'text-secondary' }} hover-scale"
                                    onclick="toggleTaskStatus({{ $task->id }})">
                                    {{ $task->status === 'completed' ? 'check_circle' : 'radio_button_unchecked' }}
                                </span>
                                <div>
                                    <h6 class="mb-0 {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : 'fw-bold' }}">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->description }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                            $badges = [
                            'low' => 'bg-success-subtle text-success',
                            'medium' => 'bg-warning-subtle text-warning',
                            'high' => 'bg-danger-subtle text-danger'
                            ];
                            @endphp
                            <span class="badge {{ $badges[$task->priority] ?? 'bg-secondary' }} text-uppercase">{{ $task->priority }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 text-muted small">
                                <span class="material-symbols-outlined fs-6">calendar_today</span>
                                {{ $task->due_date->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $task->status === 'completed' ? 'success' : 'secondary' }}-subtle text-{{ $task->status === 'completed' ? 'success' : 'secondary' }} text-capitalize">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-sm text-danger hover-bg-danger-subtle" onclick="deleteTask({{ $task->id }})">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">assignment_add</span>
                                <h6 class="fw-bold text-muted">Belum ada tugas</h6>
                                <p class="small text-muted mb-0">Tugas yang Anda buat akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 bg-white border-top rounded-bottom-4">
            {{ $tasks->appends(['filter' => $filter])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Mobile FAB -->
<button class="fab-mobile d-md-none border-0 position-fixed bottom-0 end-0 m-4 rounded-circle btn btn-primary shadow-lg p-3" data-bs-toggle="modal" data-bs-target="#taskModal">
    <span class="material-symbols-outlined fs-2">add</span>
</button>

@push('modals')
@include('components.modals.task-modal')
@endpush

@section('scripts')
<script src="{{ asset('js/task-manager.js') }}"></script>
@endsection

@endsection

@push('styles')
<style>
    .nav-underline .nav-link {
        color: #5d6389;
        font-weight: 500;
    }

    .nav-underline .nav-link.active {
        color: #4051b5;
        font-weight: 700;
        border-bottom-width: 2px;
    }

    .nav-underline .nav-link:hover {
        color: #4051b5;
    }
</style>
@endpush