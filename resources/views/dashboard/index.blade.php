@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Ringkasan Dasbor</h2>
            <p class="text-muted small">Pantau produktivitas dan pengeluaran Anda dalam satu tempat.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-light border d-flex align-items-center gap-2 bg-white rounded-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                <span class="material-symbols-outlined">add_task</span> Tugas Baru
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2" style="background-color: #3F51B5; border-color: #3F51B5;" data-bs-toggle="modal" data-bs-target="#transactionModal">
                <span class="material-symbols-outlined">add</span> Transaksi
            </button>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-indigo-light"><span class="material-symbols-outlined">check_circle</span></div>
                    <span class="badge bg-secondary-subtle text-secondary">0%</span>
                </div>
                <div>
                    <p class="text-muted small mb-1">Tugas Selesai Hari Ini</p>
                    <h3 class="fw-bold">0<span class="text-muted h5">/0</span></h3>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: 0%; background-color: #3F51B5;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-emerald-light"><span class="material-symbols-outlined">payments</span></div>
                    <span class="badge bg-secondary-subtle text-secondary">-</span>
                </div>
                <div>
                    <p class="text-muted small mb-1">Uang Terpakai Hari Ini</p>
                    <h3 class="fw-bold">Rp 0</h3>
                </div>
                <p class="x-small text-muted mb-0">vs Rp 0 kemarin</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 text-center align-items-center justify-content-center border-primary-subtle">
                <div class="icon-box bg-indigo-light mb-2"><span class="material-symbols-outlined">event_upcoming</span></div>
                <p class="text-muted small mb-0">Berikutnya</p>
                <h6 class="fw-bold">Tidak ada jadwal</h6>
                <span class="text-muted small">-</span>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 text-center align-items-center justify-content-center">
                <div class="icon-box bg-emerald-light mb-2"><span class="material-symbols-outlined">edit_note</span></div>
                <p class="text-muted small mb-0">Catatan Cepat</p>
                <h6 class="fw-bold">Tidak ada catatan</h6>
                <span class="text-muted small">-</span>
            </div>
        </div>
    </div>

    <!-- Main Chart & Activity -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">Tren Produktivitas & Pengeluaran</h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>7 Hari Terakhir</option>
                    </select>
                </div>
                <div style="height: 250px; background: #f8fafc; border-radius: 8px;" class="d-flex align-items-center justify-content-center w-100 position-relative">
                    <p class="text-muted mt-5">Belum ada data grafik</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center border-bottom">
                    Aktivitas Terbaru
                </div>
                <div class="card-body p-0 overflow-auto d-flex align-items-center justify-content-center">
                    <div class="text-center py-5">
                        <span class="material-symbols-outlined text-muted fs-1 opacity-25">history</span>
                        <p class="text-muted small mt-2">Belum ada aktivitas terbaru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@push('modals')
@include('components.modals.task-modal')
@include('components.modals.transaction-modal')
@endpush

@endsection