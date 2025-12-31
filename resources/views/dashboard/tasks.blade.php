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
        <button class="btn btn-primary-custom d-none d-md-flex align-items-center gap-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#taskModal">
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
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">assignment_add</span>
                                <h6 class="fw-bold text-muted">Belum ada tugas</h6>
                                <p class="small text-muted mb-0">Tugas yang Anda buat akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 d-flex justify-content-between align-items-center bg-white border-top">
            <span class="small text-muted">Menampilkan <b>1</b> sampai <b>3</b> dari <b>12</b> hasil</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                </ul>
            </nav>
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