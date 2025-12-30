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
        <button class="btn btn-primary-custom d-none d-md-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#taskModal">
            <span class="material-symbols-outlined fs-5">add</span>
            <span>Tugas Baru</span>
        </button>
    </header>

    <!-- Filters & Search -->
    <div class="row align-items-center mb-4 g-3">
        <div class="col-lg-6">
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
                    @if($filter == 'all' || $filter == 'pending')
                    <!-- Item 1 -->
                    <tr>
                        <td class="text-center">
                            <input class="form-check-input status-checkbox" type="checkbox" onclick="Swal.fire('Selesai!', 'Tugas ditandai selesai.', 'success')">
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark">Kirim Laporan Keuangan Q3</span>
                                <span class="small text-muted">Analisis arus pendapatan dan siapkan draf akhir.</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-priority bg-danger-subtle text-danger text-uppercase">Tinggi</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 small fw-semibold text-danger">
                                <span class="material-symbols-outlined fs-6">calendar_today</span>
                                Hari Ini
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"><span class="material-symbols-outlined fs-6">edit</span></button>
                                <button class="btn btn-sm btn-light text-danger"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 2 -->
                    <tr>
                        <td class="text-center">
                            <input class="form-check-input status-checkbox" type="checkbox" onclick="Swal.fire('Selesai!', 'Tugas ditandai selesai.', 'success')">
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark">Belanja Bulanan</span>
                                <span class="small text-muted">Susu, telur, roti, sayuran, dan biji kopi.</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-priority bg-warning-subtle text-warning text-uppercase">Sedang</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 small fw-semibold text-muted">
                                <span class="material-symbols-outlined fs-6">event</span>
                                Besok
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"><span class="material-symbols-outlined fs-6">edit</span></button>
                                <button class="btn btn-sm btn-light text-danger"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @if($filter == 'all' || $filter == 'completed')
                    <!-- Item 3 (Completed) -->
                    <tr class="bg-light">
                        <td class="text-center">
                            <input class="form-check-input status-checkbox" type="checkbox" checked onclick="Swal.fire('Dikembalikan!', 'Tugas dikembalikan ke pending.', 'info')">
                        </td>
                        <td>
                            <div class="d-flex flex-column opacity-50">
                                <span class="fw-bold text-decoration-line-through">Tinjau PR #405</span>
                                <span class="small">Review kode untuk alur otentikasi baru.</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-priority bg-secondary-subtle text-secondary text-uppercase">Selesai</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 small text-muted opacity-50">
                                <span class="material-symbols-outlined fs-6">check_circle</span>
                                Kemarin
                            </div>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-light opacity-50"><span class="material-symbols-outlined fs-6">undo</span></button>
                        </td>
                    </tr>
                    @endif
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