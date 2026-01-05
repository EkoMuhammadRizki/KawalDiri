@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Ringkasan statistik dan aktivitas sistem')

@section('content')
<!-- Stats Overview -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted fw-bold">TOTAL USERS</span>
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <span class="material-icons-round">people</span>
                </div>
            </div>
            <h2 class="fw-bold mb-1">1,245</h2>
            <div class="d-flex align-items-center text-success small">
                <span class="material-icons-round fs-6 me-1">trending_up</span>
                <span class="fw-bold">+12%</span>
                <span class="text-muted ms-2">bulan ini</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted fw-bold">TOTAL TASKS</span>
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <span class="material-icons-round">check_circle</span>
                </div>
            </div>
            <h2 class="fw-bold mb-1">15,782</h2>
            <div class="d-flex align-items-center text-success small">
                <span class="material-icons-round fs-6 me-1">trending_up</span>
                <span class="fw-bold">+8%</span>
                <span class="text-muted ms-2">bulan ini</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted fw-bold">TRANSACTIONS</span>
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <span class="material-icons-round">payments</span>
                </div>
            </div>
            <h2 class="fw-bold mb-1">45,321</h2>
            <div class="d-flex align-items-center text-success small">
                <span class="material-icons-round fs-6 me-1">trending_up</span>
                <span class="fw-bold">+15%</span>
                <span class="text-muted ms-2">bulan ini</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted fw-bold">ACTIVE NOW</span>
                <div class="stats-icon bg-info bg-opacity-10 text-info">
                    <span class="material-icons-round">bolt</span>
                </div>
            </div>
            <h2 class="fw-bold mb-1">234</h2>
            <div class="d-flex align-items-center text-info small">
                <span class="material-icons-round fs-6 me-1">fiber_manual_record</span>
                <span class="fw-bold">Online</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <div class="col-12">
        <div class="stats-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">User Activity (30 Hari)</h5>
                <button class="btn btn-sm btn-light">
                    <span class="material-icons-round fs-6">more_horiz</span>
                </button>
            </div>
            <div style="height: 300px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Info -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">Top Active Users</h5>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">J</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">@johndoe</h6>
                        <small class="text-muted">156 tasks completed</small>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                </div>
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-success text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">S</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">@sarah</h6>
                        <small class="text-muted">142 tasks completed</small>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                </div>
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-warning text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">B</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">@bobsmith</h6>
                        <small class="text-muted">98 tasks completed</small>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stats-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">Recent Registrations</h5>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-info text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">A</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Alice Wong</h6>
                        <small class="text-muted">5 menit yang lalu</small>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info">New</span>
                </div>
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">M</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Michael Lee</h6>
                        <small class="text-muted">2 jam yang lalu</small>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info">New</span>
                </div>
                <div class="list-group-item px-0 border-0 d-flex align-items-center gap-3">
                    <div class="avatar bg-danger text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">R</div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Rachel Kim</h6>
                        <small class="text-muted">Kemarin</small>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Verified</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin/dasbor-admin.js') }}"></script>
@endpush