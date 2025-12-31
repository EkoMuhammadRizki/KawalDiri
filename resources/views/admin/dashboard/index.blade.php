@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Statistik dan ringkasan sistem')

@section('content')
<div class="container-fluid">

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Total Pengguna</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <div class="stats-icon" style="background-color: rgba(67, 56, 202, 0.1); color: #4338CA;">
                        <span class="material-icons-round">people</span>
                    </div>
                </div>
                <small class="text-muted">Pengguna terdaftar (non-admin)</small>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">Total Admin</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_admins'] }}</h2>
                    </div>
                    <div class="stats-icon" style="background-color: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                        <span class="material-icons-round">admin_panel_settings</span>
                    </div>
                </div>
                <small class="text-muted">Administrator sistem</small>
            </div>
        </div>

        <!-- New Users This Month -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">User Baru (Bulan Ini)</p>
                        <h2 class="fw-bold mb-0">{{ $stats['new_users_this_month'] }}</h2>
                    </div>
                    <div class="stats-icon" style="background-color: rgba(16, 185, 129, 0.1); color: #10B981;">
                        <span class="material-icons-round">person_add</span>
                    </div>
                </div>
                <small class="text-muted">Registrasi {{ now()->format('F Y') }}</small>
            </div>
        </div>

        <!-- Active Users (Last 30 Days) -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted small mb-1">User Aktif</p>
                        <h2 class="fw-bold mb-0">{{ $stats['active_users'] }}</h2>
                    </div>
                    <div class="stats-icon" style="background-color: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                        <span class="material-icons-round">trending_up</span>
                    </div>
                </div>
                <small class="text-muted">Aktif dalam 30 hari terakhir</small>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="stats-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon" style="background-color: rgba(67, 56, 202, 0.1); color: #4338CA; width: 64px; height: 64px;">
                        <span class="material-icons-round" style="font-size: 32px;">admin_panel_settings</span>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Selamat datang, {{ auth()->user()->name }}!</h4>
                        <p class="text-muted mb-0">Anda login sebagai Administrator. Gunakan panel ini untuk mengelola sistem KawalDiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection