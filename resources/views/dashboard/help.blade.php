@extends('layouts.app')

@section('title', 'Bantuan & Dukungan - Life Manager')

<!-- Bagian Kiri Header (Breadcrumb Navigasi) -->
@section('header_left')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb small fw-medium mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item active text-dark" aria-current="page">Bantuan & Dukungan</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <header class="mb-5">
        <h2 class="fw-bold mb-1">Bantuan & Dukungan</h2>
        <p class="text-muted">Pusat bantuan untuk pertanyaan dan masalah teknis Anda.</p>
    </header>

    <div class="search-container mb-5">
        <span class="material-symbols-outlined search-icon">search</span>
        <input type="text" class="form-control search-input shadow-sm" placeholder="Cari artikel bantuan, topik, atau pertanyaan...">
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header fw-bold py-3 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">quiz</span> Pertanyaan Umum (FAQ)
                </div>
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara mereset kata sandi saya?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Anda dapat mereset kata sandi melalui halaman Pengaturan di bagian Akun > Keamanan. Jika Anda tidak bisa masuk, gunakan opsi "Lupa Kata Sandi" pada halaman login, dan kami akan mengirimkan tautan reset ke email Anda.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Apakah data pribadi saya aman?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Keamanan data adalah prioritas utama kami. Semua data dienkripsi menggunakan standar industri AES-256. Kami tidak pernah membagikan data pribadi Anda tanpa izin.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <a href="#" class="card quick-link-card h-100 p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex p-3 mb-3" style="width: fit-content;">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <h5 class="fw-bold mb-1">Panduan Pengguna</h5>
                        <p class="text-muted small mb-0">Dokumentasi lengkap penggunaan aplikasi.</p>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="card quick-link-card h-100 p-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-3 d-inline-flex p-3 mb-3" style="width: fit-content;">
                            <span class="material-symbols-outlined">forum</span>
                        </div>
                        <h5 class="fw-bold mb-1">Forum Komunitas</h5>
                        <p class="text-muted small mb-0">Diskusi dan tips dari pengguna lain.</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 mb-4 text-center">
                <h5 class="fw-bold mb-3">Butuh bantuan lebih?</h5>
                <p class="text-muted small mb-4">Tim dukungan kami siap membantu Anda Senin - Jumat, 09:00 - 17:00 WIB.</p>
                <button class="btn btn-primary-custom w-100 d-flex align-items-center justify-content-center gap-2 mb-3">
                    <span class="material-symbols-outlined fs-5">chat</span> Chat Langsung
                </button>
                <a href="mailto:support@lifemanager.com" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2 rounded-3">
                    <span class="material-symbols-outlined fs-5">mail</span> Kirim Email
                </a>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">send</span> Kirim Pesan Cepat
                </h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Subjek</label>
                        <input type="text" class="form-control" placeholder="Masalah login, tagihan, dll">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Pesan</label>
                        <textarea class="form-control" rows="4" placeholder="Jelaskan masalah Anda..."></textarea>
                    </div>
                    <button type="button" class="btn btn-dark w-100 py-2 rounded-3 fw-bold">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection