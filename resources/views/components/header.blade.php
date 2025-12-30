<!-- Komponen Header Global -->
<!-- Header ini menyesuaikan tampilan berdasarkan halaman yang aktif. -->
<!-- Jika di Dashboard: Tampilkan Search Bar dan background putih penuh. -->
<!-- Jika di Halaman Lain: Sembunyikan Search Bar, tampilkan Breadcrumb, dan background transparan. -->
<header class="d-flex align-items-center mb-4 {{ request()->is('dashboard') ? 'justify-content-between bg-white p-3 rounded-3 shadow-sm' : 'justify-content-between' }}">
    <!-- Logika Kondisional: Tampilkan Search Bar HANYA di Dashboard -->
    @if(request()->is('dashboard'))
    <div class="input-group w-50">
        <span class="input-group-text bg-light border-0"><span class="material-symbols-outlined text-muted">search</span></span>
        <input type="text" class="form-control bg-light border-0" placeholder="Cari tugas, transaksi...">
    </div>
    @else
    <div class="d-flex align-items-center">
        @yield('header_left')
    </div>
    @endif
    <div class="d-flex align-items-center gap-3 {{ request()->is('dashboard') ? '' : 'bg-white p-3 rounded-3 shadow-sm' }}">
        <span class="text-muted d-none d-md-block">
            <span class="material-symbols-outlined align-middle me-1">calendar_today</span>Hari ini, {{ date('d M') }}
        </span>
        <div class="position-relative p-2 cursor-pointer" onclick="Swal.fire('Notifikasi', 'Tidak ada notifikasi baru', 'info')">
            <span class="material-symbols-outlined">notifications</span>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        </div>
    </div>
</header>