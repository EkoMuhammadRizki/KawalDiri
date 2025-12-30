@extends('layouts.app')

@section('title', 'Pelacak Keuangan - KawalDiri')

@section('header_left')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb small fw-medium mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item active text-dark" aria-current="page">Pelacak Keuangan</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0">Pelacak Keuangan</h2>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary d-flex align-items-center gap-2 px-4 rounded-3 shadow-sm" style="background-color: var(--primary-color); border-color: var(--primary-color);" data-bs-toggle="modal" data-bs-target="#transactionModal">
                <span class="material-symbols-outlined fs-5">add</span>
                <span class="fw-semibold">Tambah Transaksi</span>
            </button>
        </div>
    </header>

    <!-- Stat Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-center">
                    <span class="material-symbols-outlined position-absolute opacity-10" style="font-size: 5rem; top: 25px; right: 20px;">account_balance</span>
                    <div class="position-relative z-1">
                        <p class="text-muted small fw-semibold mb-2">Total Saldo</p>
                        <h3 class="fw-bold mb-2">Rp 12.450.000</h3>
                        <span class="badge bg-success-subtle text-success rounded-pill fw-bold d-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">trending_up</span> +2.5% bln lalu
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-center">
                    <span class="material-symbols-outlined position-absolute opacity-10" style="font-size: 5rem; top: 25px; right: 20px;">payments</span>
                    <div class="position-relative z-1">
                        <p class="text-muted small fw-semibold mb-2">Pendapatan Bulanan</p>
                        <h3 class="fw-bold mb-3 text-success">+Rp 4.200.000</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-center">
                    <span class="material-symbols-outlined position-absolute opacity-10" style="font-size: 5rem; top: 25px; right: 20px;">credit_card</span>
                    <div class="position-relative z-1">
                        <p class="text-muted small fw-semibold mb-2">Pengeluaran Bulanan</p>
                        <h3 class="fw-bold mb-3 text-danger">-Rp 1.850.000</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Transactions -->
        <div class="col-lg-8">
            <div class="finance-table-card h-100">
                <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
                    <button class="btn btn-link text-decoration-none fw-bold small p-0" style="color: var(--primary-color);">Lihat Semua</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Transaksi</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined fs-5">coffee</span>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Kopi Kenangan</p>
                                            <p class="x-small text-muted mb-0">Kartu •••• 4521</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="small fw-medium">Makanan & Minuman</td>
                                <td class="small text-muted">24 Okt 2023</td>
                                <td><span class="badge bg-success-subtle text-success rounded-pill fw-bold">Selesai</span></td>
                                <td class="text-end fw-bold">-Rp 55.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined fs-5">work</span>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Gaji Bulanan</p>
                                            <p class="x-small text-muted mb-0">Setoran Langsung</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="small fw-medium">Pendapatan</td>
                                <td class="small text-muted">23 Okt 2023</td>
                                <td><span class="badge bg-success-subtle text-success rounded-pill fw-bold">Selesai</span></td>
                                <td class="text-end fw-bold text-success">+Rp 4.100.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined fs-5">bolt</span>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold small">Tagihan Listrik</p>
                                            <p class="x-small text-muted mb-0">Auto-Debet</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="small fw-medium">Utilitas</td>
                                <td class="small text-muted">20 Okt 2023</td>
                                <td><span class="badge bg-warning-subtle text-warning rounded-pill fw-bold">Tertunda</span></td>
                                <td class="text-end fw-bold">-Rp 1.200.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Budget Circular Chart -->
        <div class="col-lg-4">
            <div class="finance-table-card p-4 h-100">
                <h5 class="fw-bold mb-4">Sisa Anggaran</h5>
                <div class="d-flex flex-column align-items-center py-4">
                    <div class="position-relative d-flex align-items-center justify-content-center">
                        <svg class="circle-chart" viewBox="0 0 36 36">
                            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle-progress" stroke-dasharray="65, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="position-absolute text-center">
                            <h2 class="fw-black mb-0">65%</h2>
                            <p class="x-small text-muted text-uppercase fw-bold mb-0">Tersisa</p>
                        </div>
                    </div>

                    <div class="w-100 mt-5 space-y-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Total Anggaran</span>
                            <span class="fw-bold small">Rp 5.000.000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium"><span class="badge bg-light border p-1 me-1 text-dark">65%</span> Terpakai</span>
                            <span class="fw-bold small text-danger">Rp 1.850.000</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="text-muted small fw-bold">Sisa</span>
                            <span class="fw-bold text-success">Rp 3.150.000</span>
                        </div>
                    </div>

                    <button class="btn btn-outline-secondary w-100 mt-4 py-2 rounded-3 fw-bold small">
                        Sesuaikan Anggaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('modals')
@include('components.modals.transaction-modal')
@endpush

@endsection