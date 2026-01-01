@extends('layouts.admin')

@section('title', 'Pusat Komunikasi')
@section('page-title', 'Siaran Pengumuman')
@section('page-subtitle', 'Kirim notifikasi ke semua pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-icons-round">check_circle</span>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('admin.announcements.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Judul Pengumuman</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="title" name="title" placeholder="Contoh: Pemeliharaan Sistem, Fitur Baru, dll" required>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-bold">Isi Pesan</label>
                        <textarea class="form-control bg-light border-0" id="message" name="message" rows="6" placeholder="Tulis pesan pengumuman Anda di sini..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 rounded-3">
                            <span class="material-icons-round">send</span>
                            Kirim Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-4 bg-primary-subtle">
            <div class="card-body p-4">
                <div class="d-flex gap-3">
                    <div class="bg-primary text-white p-2 rounded-3 h-100">
                        <span class="material-icons-round">info</span>
                    </div>
                    <div>
                        <h6 class="fw-bold text-primary mb-1">Informasi</h6>
                        <p class="small text-muted mb-0">
                            Pengumuman yang dikirim akan muncul di notifikasi (lonceng) pada dashboard setiap pengguna.
                            Pastikan pesan yang dikirim jelas dan relevan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection