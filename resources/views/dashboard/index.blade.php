@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Ringkasan Dasbor</h2>
            <p class="text-muted small">Pantau produktivitas dan pengeluaran Anda dalam satu tempat.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-light border d-flex align-items-center gap-2 bg-white rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#taskModal">
                <span class="material-symbols-outlined text-primary">add_task</span>
                <span class="fw-medium">Tugas Baru</span>
            </button>
            <button class="btn btn-primary-custom d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#transactionModal">
                <span class="material-symbols-outlined">add</span>
                <span>Transaksi</span>
            </button>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="row g-4 mb-4">
        <!-- Tasks KPI -->
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-indigo-light text-primary rounded-3 p-2">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}% Selesai</span>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Tugas Selesai</p>
                    <h3 class="fw-black mb-0">{{ $completedTasks }}<span class="text-muted h6 fw-normal">/{{ $totalTasks }}</span></h3>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Expense KPI -->
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-rose-light text-danger rounded-3 p-2">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Pengeluaran Bulan Ini</p>
                    <h3 class="fw-black mb-0 text-danger">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</h3>
                </div>
                <p class="x-small text-muted mb-0 mt-2">vs Pendapatan: Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Balance KPI -->
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-emerald-light text-success rounded-3 p-2">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Sisa Saldo</p>
                    <h3 class="fw-black mb-0 {{ $totalBalance >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </h3>
                </div>
                <p class="x-small text-muted mb-0 mt-2">Total cash flow bersih</p>
            </div>
        </div>

        <!-- Pending Tasks KPI -->
        <div class="col-md-6 col-xl-3">
            <div class="card kpi-card p-3 border-0 shadow-sm h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-amber-light text-warning rounded-3 p-2">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    @if($overdueTasks > 0)
                    <span class="badge bg-danger-subtle text-danger rounded-pill">{{ $overdueTasks }} Terlewat</span>
                    @endif
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Tugas Tertunda</p>
                    <h3 class="fw-black mb-0">{{ $pendingTasks }}</h3>
                </div>
                <p class="x-small text-muted mb-0 mt-2">Segera selesaikan tugas Anda</p>
            </div>
        </div>
    </div>

    <!-- Charts & Activities Row -->
    <div class="row g-4">
        <!-- Productivity Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Tren Produktivitas</h5>
                    <!-- <button class="btn btn-sm btn-light border rounded-pill px-3">Bulan Ini</button> -->
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 300px; width: 100%;">
                        <canvas id="productivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Pengeluaran</h5>
                </div>
                <div class="card-body px-4 pb-4 d-flex align-items-center justify-content-center">
                    <div style="height: 250px; width: 100%;">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-4">
                    <div id="recentActivitiesContainer">
                        <!-- Content loaded via JS -->
                        <div class="d-flex justify-content-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
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

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard Logic -->
<script src="{{ asset('js/dashboard.js') }}"></script>

<!-- Task & Finance Logic (for Modals) -->
<script src="{{ asset('js/task-manager.js') }}"></script>
<script src="{{ asset('js/finance-tracker.js') }}"></script>
@endsection
@endsection