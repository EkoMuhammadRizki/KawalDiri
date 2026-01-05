@extends('layouts.app')

@section('title', 'Pengaturan - KawalDiri')

@section('header_left')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb small fw-medium mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item active text-dark" aria-current="page">Pengaturan</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Pengaturan</h2>
            <p class="text-muted mb-0">Kelola preferensi dan konfigurasi akun Anda.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span> Pengaturan Akun
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4 mb-5">
                        <div class="profile-img-container" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            @php
                            $avatarColors = ['6366f1', '10b981', 'f59e0b', 'ef4444', '8b5cf6', '06b6d4', 'ec4899', '14b8a6'];
                            $userAvatar = Auth::user()->avatar ?? 1;
                            $avatarColor = $avatarColors[($userAvatar - 1) % 8];
                            @endphp
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ $avatarColor }}&color=fff&size=128"
                                class="profile-img"
                                id="currentAvatar"
                                data-username="{{ urlencode(Auth::user()->name) }}">
                            <div class="edit-badge"><span class="material-symbols-outlined fs-6">edit</span></div>
                        </div>
                        <div class="text-center text-md-start">
                            <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                            <p class="text-muted small mb-2">{{ Auth::user()->email }}</p>
                            <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Terverifikasi</span>
                            </div>
                        </div>
                    </div>

                    <form id="profileForm">
                        @csrf
                        {{-- Form Pengaturan Profil --}}
                        {{-- Field Nama dan Email dibuat read-only (tidak bisa diedit) dengan background khusus --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-readonly" name="name" value="{{ Auth::user()->name }}" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Alamat Email</label>
                                <input type="email" class="form-control form-control-readonly" value="{{ Auth::user()->email }}" readonly disabled>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <h6 class="fw-bold text-uppercase small tracking-widest mb-4">Kata Sandi & Keamanan</h6>
                    <form id="passwordForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Kata Sandi Saat Ini</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="current_password" id="currentPasswordInput">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('currentPasswordInput', this)">
                                        <span class="material-symbols-outlined fs-6">visibility</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="new_password" id="newPasswordInput">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('newPasswordInput', this)">
                                        <span class="material-symbols-outlined fs-6">visibility</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Konfirmasi Sandi</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="new_password_confirmation" id="confirmPasswordInput">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPasswordInput', this)">
                                        <span class="material-symbols-outlined fs-6">visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary mt-3" onclick="savePassword()">
                            <span class="material-symbols-outlined fs-6">lock_reset</span> Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">notifications</span> Notifikasi
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 fw-bold small">Notifikasi Pengumuman</p>
                            <span class="x-small text-muted">Terima siaran pesan dari Admin</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="announcementNotif" {{ Auth::user()->email_notifications ? 'checked' : '' }} onchange="saveNotifications()">
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">palette</span> Tampilan
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-4">
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="lightTheme" value="light" {{ (Auth::user()->theme_preference === 'light' || Auth::user()->theme_preference === 'system') ? 'checked' : '' }}>
                            <label class="theme-box w-100" for="lightTheme" onclick="changeTheme('light')">
                                <span class="material-symbols-outlined d-block mb-1">light_mode</span>
                                <span class="x-small fw-bold">Terang</span>
                            </label>
                        </div>
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="darkTheme" value="dark" {{ Auth::user()->theme_preference === 'dark' ? 'checked' : '' }}>
                            <label class="theme-box w-100" for="darkTheme" onclick="changeTheme('dark')">
                                <span class="material-symbols-outlined d-block mb-1">dark_mode</span>
                                <span class="x-small fw-bold">Gelap</span>
                            </label>
                        </div>
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="autoTheme" value="system" {{ Auth::user()->theme_preference === 'system' && Auth::user()->theme_preference !== 'light' && Auth::user()->theme_preference !== 'dark' ? 'checked' : '' }}>
                            <label class="theme-box w-100" for="autoTheme" onclick="changeTheme('system')">
                                <span class="material-symbols-outlined d-block mb-1">hdr_auto</span>
                                <span class="x-small fw-bold">Sistem</span>
                            </label>
                        </div>
                    </div>

                    <p class="small fw-bold mb-3">Warna Aksen</p>
                    <div class="d-flex gap-2">
                        <div class="accent-color-option {{ Auth::user()->accent_color === '#6366f1' ? 'active' : '' }}" onclick="changeAccentColor('#6366f1')">
                            <div style="width: 28px; height: 28px; background-color: #6366f1;" class="rounded-circle"></div>
                        </div>
                        <div class="accent-color-option {{ Auth::user()->accent_color === '#10b981' ? 'active' : '' }}" onclick="changeAccentColor('#10b981')">
                            <div style="width: 28px; height: 28px; background-color: #10b981;" class="rounded-circle"></div>
                        </div>
                        <div class="accent-color-option {{ Auth::user()->accent_color === '#7c3aed' ? 'active' : '' }}" onclick="changeAccentColor('#7c3aed')">
                            <div style="width: 28px; height: 28px; background-color: #7c3aed;" class="rounded-circle"></div>
                        </div>
                        <div class="accent-color-option {{ Auth::user()->accent_color === '#f43f5e' ? 'active' : '' }}" onclick="changeAccentColor('#f43f5e')">
                            <div style="width: 28px; height: 28px; background-color: #f43f5e;" class="rounded-circle"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Section -->
            <div class="card mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-3">Zona Berbahaya</h6>
                    <p class="text-muted small mb-4">Setelah Anda keluar, sesi Anda akan berakhir.</p>
                    <button class="btn btn-danger w-100 fw-bold d-flex align-items-center justify-content-center gap-2" onclick="confirmLogout()">
                        <span class="material-symbols-outlined">logout</span> Keluar dari Aplikasi
                    </button>
                </div>
            </div>

            <form id="logout-form-settings" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Avatar Selector Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pilih Avatar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-4">Pilih warna avatar yang Anda sukai</p>
                <div class="row g-3">
                    @php
                    $avatarColors = [
                    1 => ['color' => '6366f1', 'name' => 'Indigo'],
                    2 => ['color' => '10b981', 'name' => 'Hijau'],
                    3 => ['color' => 'f59e0b', 'name' => 'Kuning'],
                    4 => ['color' => 'ef4444', 'name' => 'Merah'],
                    5 => ['color' => '8b5cf6', 'name' => 'Ungu'],
                    6 => ['color' => '06b6d4', 'name' => 'Cyan'],
                    7 => ['color' => 'ec4899', 'name' => 'Pink'],
                    8 => ['color' => '14b8a6', 'name' => 'Teal']
                    ];
                    $currentAvatar = Auth::user()->avatar ?? 1;
                    @endphp
                    @foreach($avatarColors as $id => $avatar)
                    <div class="col-6 col-md-3">
                        <div class="avatar-option {{ $currentAvatar == $id ? 'active' : '' }}"
                            onclick="selectAvatar({{ $id }}, '{{ $avatar['color'] }}')"
                            data-avatar-id="{{ $id }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ $avatar['color'] }}&color=fff&size=80"
                                class="rounded-circle w-100">
                            <p class="text-center small mt-2 mb-0 fw-semibold">{{ $avatar['name'] }}</p>
                            <div class="avatar-check"><span class="material-symbols-outlined">check_circle</span></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveAvatar()">Simpan Avatar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .accent-color-option {
        cursor: pointer;
        padding: 3px;
        border: 3px solid transparent;
        border-radius: 50%;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .accent-color-option.active {
        border-color: var(--accent-color, #6366f1);
        padding: 3px;
    }

    .accent-color-option:hover:not(.active) {
        transform: scale(1.1);
        opacity: 0.8;
    }

    .accent-color-option:active {
        transform: scale(0.95);
    }

    /* Avatar Selector Styles */
    .avatar-option {
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 8px;
        border: 3px solid transparent;
        border-radius: 12px;
    }

    .avatar-option:hover {
        transform: scale(1.05);
        background-color: rgba(var(--accent-color-rgb), 0.1);
    }

    .avatar-option.active {
        border-color: var(--accent-color);
        background-color: rgba(var(--accent-color-rgb), 0.1);
    }

    .avatar-option .avatar-check {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: var(--accent-color);
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .avatar-option.active .avatar-check {
        display: flex;
    }

    .avatar-option .avatar-check .material-symbols-outlined {
        font-size: 16px;
    }

    /* Readonly Input Styles */
    .form-control-readonly {
        background-color: #e9ecef;
        opacity: 1;
        cursor: not-allowed;
    }

    [data-theme="dark"] .form-control-readonly {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #cbd5e1 !important;
    }
</style>

<!-- Settings Page JavaScript -->
<script src="{{ asset('js/halaman-pengaturan.js') }}"></script>
@endsection