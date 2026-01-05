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


    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header fw-bold py-3 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">quiz</span> Pertanyaan Umum (FAQ)
                </div>
                <div class="accordion accordion-flush" id="faqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item" data-keywords="password sandi reset lupa kata sandi ganti password">
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

                    <!-- FAQ 2 -->
                    <div class="accordion-item" data-keywords="data aman privasi keamanan enkripsi pribadi">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apakah data pribadi saya aman?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Keamanan data adalah prioritas utama kami. Semua data dienkripsi menggunakan standar industri AES-256. Kami tidak pernah membagikan data pribadi Anda tanpa izin.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item" data-keywords="tugas task tambah baru buat todo">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Bagaimana cara menambahkan tugas baru?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Klik tombol "Tambah Tugas" di halaman Manajer Tugas, isi detail tugas seperti judul, deskripsi, prioritas, dan tanggal jatuh tempo, lalu klik "Simpan".
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item" data-keywords="transaksi keuangan uang tambah catat pengeluaran pemasukan finance">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Bagaimana cara mencatat transaksi keuangan?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Buka halaman Pelacak Keuangan dan klik tombol "Tambah Transaksi". Pilih tipe (pemasukan/pengeluaran), masukkan jumlah, kategori, dan deskripsi, lalu simpan.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="accordion-item" data-keywords="tema dark light gelap terang mode theme tampilan">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Bagaimana cara mengubah tema aplikasi?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Buka halaman Pengaturan dan cari bagian "Tema". Anda dapat memilih antara tema Terang, Gelap, atau mengikuti pengaturan sistem.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="accordion-item" data-keywords="hapus akun delete tutup buang remove">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                Bagaimana cara menghapus akun saya?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Untuk menghapus akun, buka Pengaturan > Reset Akun. Perhatikan bahwa tindakan ini akan menghapus semua data Anda secara permanen dan tidak dapat dibatalkan.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 7 -->
                    <div class="accordion-item" data-keywords="gratis bayar free harga biaya langganan berbayar">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                Apakah aplikasi ini gratis?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small lh-lg">
                                Ya! KawalDiri adalah aplikasi yang 100% gratis. Semua fitur tersedia tanpa biaya langganan atau pembayaran tersembunyi.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No results message -->
                <div id="noFaqResults" class="p-4 text-center text-muted d-none">
                    <span class="material-symbols-outlined fs-1 mb-2 d-block">search_off</span>
                    <p class="mb-0">Tidak ada FAQ yang cocok dengan pencarian Anda.</p>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Card Bantuan -->
        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3 text-center">Butuh bantuan lebih?</h5>
                <p class="text-muted small mb-4 text-center">Tim dukungan kami siap membantu Anda Senin - Jumat, 09:00 - 17:00 WIB.</p>

                <!-- Tombol WhatsApp -->
                <a href="https://wa.me/6285893803247" target="_blank" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 mb-4 rounded-3">
                    <span class="material-symbols-outlined fs-5">chat</span> Chat WhatsApp
                </a>

                <hr class="my-3">

                <!-- Form Email via Formspree -->
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">mail</span> Kirim Email
                </h6>
                <form action="https://formspree.io/f/xzdzwpwa" method="POST">
                    <input type="hidden" name="_subject" value="Pesan dari KawalDiri - Bantuan & Dukungan">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ auth()->user()->name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email Anda" value="{{ auth()->user()->email ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Subjek</label>
                        <input type="text" name="subject" class="form-control" placeholder="Masalah login, fitur, dll" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Pesan</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Jelaskan masalah atau pertanyaan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined fs-5">send</span> Kirim Email
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [data-theme="dark"] .accordion-button {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }

    [data-theme="dark"] .accordion-button:not(.collapsed) {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
    }

    [data-theme="dark"] .accordion-item {
        border-color: var(--border-color);
    }
</style>
@endpush
@endsection