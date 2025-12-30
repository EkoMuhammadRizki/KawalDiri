@extends('layouts.app')

@section('title', 'Pengaturan - Life Manager')

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
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-2 px-4 rounded-3">
                <span class="material-symbols-outlined fs-5">restart_alt</span> Atur Ulang
            </button>
            <button class="btn btn-primary-custom d-flex align-items-center gap-2">
                <span class="material-symbols-outlined fs-5">save</span> Simpan Perubahan
            </button>
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
                        <div class="profile-img-container">
                            <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=1232e2&color=fff&size=128"
                                class="profile-img">
                            <div class="edit-badge"><span class="material-symbols-outlined fs-6">edit</span></div>
                        </div>
                        <div class="text-center text-md-start">
                            <h4 class="fw-bold mb-1">Jane Doe</h4>
                            <p class="text-muted small mb-2">jane.doe@lifemanager.com</p>
                            <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Terverifikasi</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Jane Doe">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <input type="email" class="form-control" value="jane.doe@lifemanager.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">@</span>
                                <input type="text" class="form-control" value="janedoe_99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor Telepon</label>
                            <input type="tel" class="form-control" placeholder="+62 812 0000 0000">
                        </div>
                    </div>

                    <hr class="my-5">

                    <h6 class="fw-bold text-uppercase small tracking-widest mb-4">Kata Sandi & Keamanan</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kata Sandi Baru</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Konfirmasi Sandi</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">notifications</span> Notifikasi
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="mb-0 fw-bold small">Notifikasi Email</p>
                            <span class="x-small text-muted">Update via email</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="mb-0 fw-bold small">Notifikasi Push</p>
                            <span class="x-small text-muted">Peringatan browser</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 fw-bold small">Ringkasan Mingguan</p>
                            <span class="x-small text-muted">Laporan aktivitas mingguan</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                    <hr>
                    <a href="#" class="text-primary small fw-bold text-decoration-none">Pengaturan Lanjutan →</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">palette</span> Tampilan
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-4">
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="lightTheme" checked>
                            <label class="theme-box w-100" for="lightTheme">
                                <span class="material-symbols-outlined d-block mb-1">light_mode</span>
                                <span class="x-small fw-bold">Terang</span>
                            </label>
                        </div>
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="darkTheme">
                            <label class="theme-box w-100" for="darkTheme">
                                <span class="material-symbols-outlined d-block mb-1">dark_mode</span>
                                <span class="x-small fw-bold">Gelap</span>
                            </label>
                        </div>
                        <div class="col-4 text-center">
                            <input type="radio" class="btn-check theme-radio" name="theme" id="autoTheme">
                            <label class="theme-box w-100" for="autoTheme">
                                <span class="material-symbols-outlined d-block mb-1">hdr_auto</span>
                                <span class="x-small fw-bold">Sistem</span>
                            </label>
                        </div>
                    </div>

                    <p class="small fw-bold mb-3">Warna Aksen</p>
                    <div class="d-flex gap-2">
                        <div class="rounded-circle border border-primary p-1">
                            <div style="width: 20px; height: 20px; background-color: #1232e2;" class="rounded-circle">
                            </div>
                        </div>
                        <div style="width: 28px; height: 28px; background-color: #10b981;"
                            class="rounded-circle cursor-pointer opacity-50"></div>
                        <div style="width: 28px; height: 28px; background-color: #7c3aed;"
                            class="rounded-circle cursor-pointer opacity-50"></div>
                        <div style="width: 28px; height: 28px; background-color: #f43f5e;"
                            class="rounded-circle cursor-pointer opacity-50"></div>
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

            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>

            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Konfirmasi Keluar',
                        text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>
@endsection