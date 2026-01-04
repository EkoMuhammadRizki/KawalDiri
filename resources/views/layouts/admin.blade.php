<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - KawalDiri</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Admin Layout Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin-layout.css') }}">

    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="bg-primary text-white p-2 rounded-3">

                <div class="d-flex align-items-center gap-2">
                    <span class="material-icons-round text-white" style="font-size: 32px;">security</span>
                    <div>
                        <h5 class="mb-0 fw-bold text-white">KawalDiri</h5>
                        <small class="text-white-50" style="font-size: 0.8rem;">Admin Panel</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="material-icons-round">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <span class="material-icons-round">people</span>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <p class="small text-muted fw-bold px-3 mt-3 mb-1 text-uppercase" style="font-size: 0.7rem;">Pusat Komunikasi</p>
                    <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                        <span class="material-icons-round">campaign</span>
                        <span>Siaran Pengumuman</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Topbar -->
        <div class="admin-topbar">
            <div>
                <h4 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h4>
                <small class="text-muted">@yield('page-subtitle', 'Selamat datang di panel admin')</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-secondary d-flex align-items-center gap-2" onclick="confirmGoToLanding()">
                    <span class="material-icons-round">home</span>
                    Landing Page
                </button>
                <button type="button" class="btn btn-logout d-flex align-items-center gap-2" onclick="confirmLogout()">
                    <span class="material-icons-round">logout</span>
                    Logout
                </button>
            </div>
        </div>

        <!-- Content -->
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Logout Form (Hidden) -->
    <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Admin Layout Scripts -->
    <script src="{{ asset('js/admin/admin-layout.js') }}"></script>

    <!-- Admin SPA Navigation -->
    <script src="{{ asset('js/admin/admin-spa.js') }}"></script>

    @stack('scripts')
</body>

</html>