@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Ringkasan Dasbor</h2>
            <p class="text-muted small">Pantau produktivitas dan pengeluaran Anda dalam satu tempat.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-light border d-flex align-items-center gap-2 bg-white" data-bs-toggle="modal" data-bs-target="#taskModal">
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
                    <span class="badge bg-success-subtle text-success">+12%</span>
                </div>
                <div>
                    <p class="text-muted small mb-1">Tugas Selesai Hari Ini</p>
                    <h3 class="fw-bold">5<span class="text-muted h5">/8</span></h3>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: 62.5%; background-color: #3F51B5;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="icon-box bg-emerald-light"><span class="material-symbols-outlined">payments</span></div>
                    <span class="badge bg-success-subtle text-success">Aman</span>
                </div>
                <div>
                    <p class="text-muted small mb-1">Uang Terpakai Hari Ini</p>
                    <h3 class="fw-bold">Rp 450k</h3>
                </div>
                <p class="x-small text-muted mb-0">vs Rp 475k kemarin</p>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 text-center align-items-center justify-content-center border-primary-subtle">
                <div class="icon-box bg-indigo-light mb-2"><span class="material-symbols-outlined">event_upcoming</span></div>
                <p class="text-muted small mb-0">Berikutnya</p>
                <h6 class="fw-bold">Sinkronisasi Tim</h6>
                <span class="text-primary small">14:00 WIB</span>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 text-center align-items-center justify-content-center">
                <div class="icon-box bg-emerald-light mb-2"><span class="material-symbols-outlined">edit_note</span></div>
                <p class="text-muted small mb-0">Catatan Cepat</p>
                <h6 class="fw-bold">Daftar Belanja</h6>
                <span class="text-success small">3 item ditambahkan</span>
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
                        <option>30 Hari Terakhir</option>
                    </select>
                </div>
                <div style="height: 250px; background: #f8fafc; border-radius: 8px;" class="d-flex align-items-center justify-content-center w-100 position-relative">
                    <!-- Re-inserting the SVG Chart for better visual than just '[Grafik]' -->
                    <svg class="w-100 h-100 overflow-visible" preserveAspectRatio="none" viewBox="0 0 800 250">
                        <!-- Grid lines -->
                        <line stroke="#e2e8f0" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="200" y2="200"></line>
                        <line stroke="#e2e8f0" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="150" y2="150"></line>
                        <line stroke="#e2e8f0" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="100" y2="100"></line>
                        <line stroke="#e2e8f0" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
                        <!-- Bars (Spending) -->
                        <rect fill="#10B981" height="100" opacity="0.8" rx="4" width="40" x="50" y="100"></rect>
                        <rect fill="#10B981" height="80" opacity="0.8" rx="4" width="40" x="160" y="120"></rect>
                        <rect fill="#10B981" height="120" opacity="0.8" rx="4" width="40" x="270" y="80"></rect>
                        <rect fill="#10B981" height="60" opacity="0.8" rx="4" width="40" x="380" y="140"></rect>
                        <rect fill="#10B981" height="90" opacity="0.8" rx="4" width="40" x="490" y="110"></rect>
                        <rect fill="#10B981" height="70" opacity="0.8" rx="4" width="40" x="600" y="130"></rect>
                        <rect fill="#10B981" height="130" opacity="0.8" rx="4" width="40" x="710" y="70"></rect>
                        <!-- Line (Productivity) -->
                        <path d="M70 140 C120 120, 180 60, 290 90 S 400 50, 510 70 S 620 100, 730 40" fill="none" stroke="#3F51B5" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></path>
                        <circle cx="70" cy="140" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="180" cy="95" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="290" cy="90" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="400" cy="65" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="510" cy="70" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="620" cy="90" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                        <circle cx="730" cy="40" fill="white" r="5" stroke="#3F51B5" stroke-width="3"></circle>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center border-bottom">
                    Aktivitas Terbaru
                    <button class="btn btn-link btn-sm text-decoration-none p-0">Lihat Semua</button>
                </div>
                <div class="card-body p-0 overflow-auto">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center border-0 p-3">
                            <div class="activity-icon bg-indigo-light me-3"><span class="material-symbols-outlined">check</span></div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-bold">Laporan Q3 Selesai</p>
                                <span class="text-muted x-small">Tugas • 2 jam lalu</span>
                            </div>
                            <span class="text-primary small fw-bold">+10 poin</span>
                        </div>
                        <div class="list-group-item d-flex align-items-center border-0 p-3">
                            <div class="activity-icon bg-emerald-light me-3"><span class="material-symbols-outlined">shopping_cart</span></div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-bold">Pasar Modern</p>
                                <span class="text-muted x-small">Pengeluaran • 4 jam lalu</span>
                            </div>
                            <span class="text-dark small fw-bold">-Rp 42k</span>
                        </div>
                        <div class="list-group-item d-flex align-items-center border-0 p-3">
                            <div class="activity-icon bg-indigo-light me-3"><span class="material-symbols-outlined">fitness_center</span></div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-bold">Gym Sore</p>
                                <span class="text-muted x-small">Tugas • Kemarin</span>
                            </div>
                            <span class="text-primary small fw-bold">+5 poin</span>
                        </div>
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