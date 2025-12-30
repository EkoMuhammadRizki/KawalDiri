<aside class="sidebar d-flex flex-column p-4">
    <div class="d-flex align-items-center gap-3 mb-5 px-2">
        <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background-color: var(--primary-color) !important;">
            <span class="material-symbols-outlined">spa</span>
        </div>
        <h1 class="h6 fw-bold mb-0">Life Manager</h1>
    </div>

    <nav class="nav flex-column flex-grow-1">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>Dasbor
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
        <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg cursor-pointer" onclick="document.getElementById('logout-form').submit()">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1232e2&color=fff" class="rounded-circle" width="40" height="40">
            <div class="overflow-hidden">
                <p class="small fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</p>
                <p class="x-small text-muted mb-0 text-truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
        @else
        <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg cursor-pointer">
            <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=1232e2&color=fff" class="rounded-circle" width="40" height="40">
            <div class="overflow-hidden">
                <p class="small fw-bold mb-0 text-truncate">Jane Doe</p>
                <p class="x-small text-muted mb-0 text-truncate">jane@lifemanager.com</p>
            </div>
        </div>
        @endif
    </div>
</aside>