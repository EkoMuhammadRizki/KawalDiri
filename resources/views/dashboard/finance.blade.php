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
            <button class="btn btn-primary d-flex align-items-center gap-2 px-4 rounded-pill shadow-sm" style="background-color: var(--primary-color); border-color: var(--primary-color);" data-bs-toggle="modal" data-bs-target="#transactionModal">
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
                        <h3 class="fw-bold mb-2">Rp 0</h3>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill fw-bold d-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">remove</span> 0%
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
                        <h3 class="fw-bold mb-3 text-success">Rp 0</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <h3 class="fw-bold mb-3 text-danger">Rp 0</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">receipt_long</span>
                                        <h6 class="fw-bold text-muted">Belum ada transaksi</h6>
                                        <p class="small text-muted mb-0">Riwayat transaksi Anda akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Budget Circular Chart -->
        <div class="col-lg-4">
            <div class="finance-table-card p-4 h-100 bg-white border-0 shadow-sm rounded-4" style="background-color: #ffffff !important;">
                <h5 class="fw-bold mb-4">Sisa Anggaran</h5>
                <div class="d-flex flex-column align-items-center py-4">
                    <div class="position-relative d-flex align-items-center justify-content-center">
                        <svg class="circle-chart" viewBox="0 0 36 36">
                            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle-progress" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="position-absolute text-center">
                            <h2 class="fw-black mb-0">100%</h2>
                            <p class="x-small text-muted text-uppercase fw-bold mb-0">Tersisa</p>
                        </div>
                    </div>

                    <div class="w-100 mt-5 space-y-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Total Anggaran</span>
                            <span class="fw-bold small">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium"><span class="badge bg-light border p-1 me-1 text-dark">0%</span> Terpakai</span>
                            <span class="fw-bold small text-danger">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="text-muted small fw-bold">Sisa</span>
                            <span class="fw-bold text-success">Rp 0</span>
                        </div>
                    </div>

                    <button class="btn btn-outline-secondary w-100 mt-4 py-2 rounded-3 fw-bold small">
                        Atur Anggaran
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