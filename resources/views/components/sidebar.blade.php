<aside class="sidebar d-flex flex-column p-4">
    <div class="d-flex align-items-center gap-3 mb-5 px-2">
        <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background-color: var(--primary-color) !important;">
            <span class="material-symbols-outlined">spa</span>
        </div>
        <h1 class="h6 fw-bold mb-0">Kawal Diri</h1>
    </div>

    <nav class="nav flex-column flex-grow-1">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>Dasbor Pengguna
        </a>
        <a class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}" href="{{ route('tasks') }}">
            <span class="material-symbols-outlined">check_circle</span>Manajer Tugas
        </a>
        <a class="nav-link {{ request()->is('finance*') ? 'active' : '' }}" href="{{ route('finance') }}">
            <span class="material-symbols-outlined">payments</span>Pelacak Keuangan
        </a>
        <hr class="my-4">
        <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="{{ route('settings') }}">
            <span class="material-symbols-outlined">settings</span>Pengaturan
        </a>
        <a class="nav-link {{ request()->is('help*') ? 'active' : '' }}" href="{{ route('help') }}">
            <span class="material-symbols-outlined">help</span>Bantuan & Dukungan
        </a>
    </nav>

    <div class="border-top pt-4">
        @if(auth()->check())
        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 hover-bg">
            <a href="{{ route('settings') }}" class="d-flex align-items-center gap-3 text-decoration-none text-reset overflow-hidden flex-grow-1">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1232e2&color=fff" class="rounded-circle" width="40" height="40">
                <div class="overflow-hidden">
                    <p class="small fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</p>
                    <p class="x-small text-muted mb-0 text-truncate">{{ auth()->user()->email }}</p>
                </div>
            </a>
            <button onclick="confirmSidebarLogout()" class="btn btn-link text-muted p-0 ms-2" title="Keluar">
                <span class="material-symbols-outlined">logout</span>
            </button>
        </div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
        @else
        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 hover-bg">
            <a href="{{ route('settings') }}" class="d-flex align-items-center gap-3 text-decoration-none text-reset overflow-hidden flex-grow-1">
                <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=1232e2&color=fff" class="rounded-circle" width="40" height="40">
                <div class="overflow-hidden">
                    <p class="small fw-bold mb-0 text-truncate">Jane Doe</p>
                    <p class="x-small text-muted mb-0 text-truncate">jane@lifemanager.com</p>
                </div>
            </a>
            <button onclick="confirmSidebarLogout()" class="btn btn-link text-muted p-0 ms-2" title="Keluar">
                <span class="material-symbols-outlined">logout</span>
            </button>
        </div>
        @endif
    </div>
</aside>

<script>
    function confirmSidebarLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Apakah Anda yakin ingin keluar dari aplikasi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>