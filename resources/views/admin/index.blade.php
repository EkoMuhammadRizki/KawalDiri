@extends('layouts.app')

@section('title', 'Admin Dashboard - KawalDiri')

@section('content')
<div class="page-header">
    <h1 class="page-title">📊 Admin Dashboard</h1>
</div>

<!-- Stats Overview -->
<div class="dashboard-grid mb-6">
    <div class="widget">
        <div class="widget-header">
            <span class="widget-title">👥 Total Users</span>
        </div>
        <div class="widget-value">1,245</div>
        <div class="widget-change positive">
            <i data-lucide="trending-up"></i>
            <span>+12% bulan ini</span>
        </div>
    </div>
    <div class="widget">
        <div class="widget-header">
            <span class="widget-title">📋 Total Tasks</span>
        </div>
        <div class="widget-value">15,782</div>
        <div class="widget-change positive">
            <i data-lucide="trending-up"></i>
            <span>+8% bulan ini</span>
        </div>
    </div>
    <div class="widget">
        <div class="widget-header">
            <span class="widget-title">💰 Total Transactions</span>
        </div>
        <div class="widget-value">45,321</div>
        <div class="widget-change positive">
            <i data-lucide="trending-up"></i>
            <span>+15% bulan ini</span>
        </div>
    </div>
    <div class="widget">
        <div class="widget-header">
            <span class="widget-title">📈 Active Now</span>
        </div>
        <div class="widget-value text-success">234</div>
        <div class="widget-change">
            <span>Online saat ini</span>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="dashboard-grid mb-6">
    <div class="widget widget-span-4">
        <div class="widget-header">
            <span class="widget-title">📈 User Activity (30 Hari)</span>
        </div>
        <div class="chart-container">
            <canvas id="activityChart"></canvas>
        </div>
    </div>
</div>

<!-- Quick Info -->
<div class="dashboard-grid">
    <div class="widget widget-span-2">
        <div class="widget-header">
            <span class="widget-title">🏆 Top Active Users</span>
        </div>
        <ul class="transaction-list">
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">J</div>
                <div class="transaction-details">
                    <div class="transaction-title">@johndoe</div>
                    <div class="transaction-category">156 tasks completed</div>
                </div>
                <span class="badge badge-success">Active</span>
            </li>
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">S</div>
                <div class="transaction-details">
                    <div class="transaction-title">@sarah</div>
                    <div class="transaction-category">142 tasks completed</div>
                </div>
                <span class="badge badge-success">Active</span>
            </li>
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">B</div>
                <div class="transaction-details">
                    <div class="transaction-title">@bobsmith</div>
                    <div class="transaction-category">98 tasks completed</div>
                </div>
                <span class="badge badge-success">Active</span>
            </li>
        </ul>
    </div>
    <div class="widget widget-span-2">
        <div class="widget-header">
            <span class="widget-title">🆕 Recent Registrations</span>
        </div>
        <ul class="transaction-list">
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">A</div>
                <div class="transaction-details">
                    <div class="transaction-title">Alice Wong</div>
                    <div class="transaction-category">5 menit yang lalu</div>
                </div>
                <span class="badge badge-info">New</span>
            </li>
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">M</div>
                <div class="transaction-details">
                    <div class="transaction-title">Michael Lee</div>
                    <div class="transaction-category">2 jam yang lalu</div>
                </div>
                <span class="badge badge-info">New</span>
            </li>
            <li class="transaction-item">
                <div class="user-avatar" style="width: 40px; height: 40px;">R</div>
                <div class="transaction-details">
                    <div class="transaction-title">Rachel Kim</div>
                    <div class="transaction-category">Kemarin</div>
                </div>
                <span class="badge badge-primary">Verified</span>
            </li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Chart(document.getElementById('activityChart'), {
            type: 'line',
            data: {
                labels: Array.from({
                    length: 30
                }, (_, i) => `${i + 1} Dec`),
                datasets: [{
                    label: 'Active Users',
                    data: [120, 150, 180, 160, 200, 220, 190, 210, 250, 230, 260, 240, 280, 290, 270, 300, 310, 290, 320, 330, 310, 340, 350, 330, 360, 370, 350, 380, 390, 400],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush