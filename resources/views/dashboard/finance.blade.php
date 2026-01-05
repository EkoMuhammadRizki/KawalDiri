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
            <button class="btn btn-light border d-flex align-items-center justify-content-center bg-white rounded-3 shadow-sm position-relative" style="width: 42px; height: 42px;" data-bs-toggle="modal" data-bs-target="#notificationModal">
                <span class="material-symbols-outlined text-secondary">notifications</span>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle notification-dot {{ isset($unreadNotificationsCount) && $unreadNotificationsCount > 0 ? '' : 'd-none' }}">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </button>
            <button class="btn btn-primary-custom d-flex align-items-center gap-2 px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#transactionModal">
                <span class="material-symbols-outlined fs-5">add</span>
                <span class="fw-semibold">Tambah Transaksi</span>
            </button>
        </div>
    </header>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body position-relative overflow-hidden d-flex flex-column justify-content-center">
                    <span class="material-symbols-outlined position-absolute opacity-10" style="font-size: 5rem; top: 25px; right: 20px;">account_balance</span>
                    <div class="position-relative z-1">
                        <p class="text-muted small fw-semibold mb-2">Total Saldo</p>
                        <h3 class="fw-bold mb-2">Rp {{ number_format($monthlyIncome - $monthlyExpenses, 0, ',', '.') }}</h3>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill fw-bold d-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">wallet</span> Cash Flow
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
                        <p class="text-muted small fw-semibold mb-2">Pendapatan Bulan Ini</p>
                        <h3 class="fw-bold mb-3 text-success">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <p class="text-muted small fw-semibold mb-2">Pengeluaran Bulan Ini</p>
                        <h3 class="fw-bold mb-3 text-danger">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</h3>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Transactions -->
        <!-- Recent Transactions -->
        <div class="col-lg-8">
            <div class="finance-table-card h-100 rounded-4 overflow-hidden">
                <div class="p-3 border-bottom">
                    <h5 class="fw-bold mb-3 px-1">Transaksi Terbaru</h5>
                    <form action="{{ route('finance') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-3"><span class="material-symbols-outlined text-muted">search</span></span>
                            <input type="text" name="search" class="form-control border-start-0 rounded-end-3 py-2" placeholder="Cari transaksi..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transaksi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hapus</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody">
                            @forelse($transactions as $trx)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle p-2 bg-{{ $trx->type == 'income' ? 'success' : 'danger' }}-subtle text-{{ $trx->type == 'income' ? 'success' : 'danger' }} d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                            <span class="material-symbols-outlined fs-5">{{ $trx->type == 'income' ? 'trending_up' : 'trending_down' }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $trx->title }}</h6>
                                            <small class="text-muted">{{ $trx->date->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $trx->category }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $trx->status == 'paid' ? 'success' : 'warning' }}-subtle text-{{ $trx->status == 'paid' ? 'success' : 'warning' }} text-capitalize">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold {{ $trx->type == 'income' ? 'text-success' : 'text-danger' }}">
                                    {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-sm text-danger hover-bg-danger-subtle" onclick="deleteTransaction({{ $trx->id }})">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-icon btn-sm text-primary hover-bg-primary-subtle"
                                        data-json="{{ json_encode($trx) }}"
                                        onclick="openEditTransaction(this)">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <span class="material-symbols-outlined text-muted fs-1 opacity-25 mb-3">receipt_long</span>
                                        <h6 class="fw-bold text-muted">Belum ada transaksi</h6>
                                        <p class="small text-muted mb-0">Riwayat transaksi Anda akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="p-3 bg-white border-top d-flex justify-content-center">
                    {{ $transactions->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>

        <!-- Budget Circular Chart -->
        <div class="col-lg-4">
            <div class="finance-table-card p-4 bg-white border-0 shadow-sm rounded-4">
                <h5 class="fw-bold mb-4">Sisa Anggaran</h5>
                <div class="align-items-center">
                    <div class="position-relative d-flex align-items-center justify-content-center">
                        <svg class="circle-chart" viewBox="0 0 36 36">
                            <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle-progress" stroke-dasharray="{{ $budgetUsedPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="position-absolute text-center">
                            <h2 class="fw-black mb-0" id="budgetPercent">{{ number_format($budgetUsedPercent, 0) }}%</h2>
                            <p class="x-small text-muted text-uppercase fw-bold mb-0">Terpakai</p>
                        </div>
                    </div>

                    <div class="w-100 mt-5 space-y-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Total Anggaran</span>
                            <span class="fw-bold small" data-budget-total>Rp {{ number_format($budget, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium">Terpakai</span>
                            <span class="fw-bold small text-danger" data-budget-used>Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="text-muted small fw-bold">Sisa</span>
                            <span class="fw-bold text-success" data-budget-remaining>Rp {{ number_format($budgetRemaining, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button class="btn btn-outline-secondary w-100 mt-4 py-2 rounded-3 fw-bold small" data-bs-toggle="modal" data-bs-target="#budgetModal">
                        Atur Anggaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('components.modals.transaction-modal')
@include('components.modals.budget-modal')
@include('components.modals.notification-modal')
@endpush

@section('scripts')
<script src="{{ asset('js/pelacak-keuangan.js') }}"></script>
@endsection