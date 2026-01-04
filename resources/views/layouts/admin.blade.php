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

    @stack('styles')

    <style>
        :root {
            --primary-color: #4338CA;
            --primary-hover: #3730A3;
            --emerald-acc: #10B981;
            --bg-light: #F3F4F6;
            --text-main: #111827;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            border-right: 1px solid #E5E7EB;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-nav {
            padding: 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(67, 56, 202, 0.1);
            color: var(--primary-color);
        }

        /* Main Content */
        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Topbar */
        .admin-topbar {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem 1.75rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.75rem;
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout {
            background: #FEF2F2;
            color: #EF4444;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #FEE2E2;
            color: #DC2626;
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #4B5563;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
            color: #1F2937;
        }
    </style>
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-no-swup>
                        <span class="material-icons-round">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" data-no-swup>
                        <span class="material-icons-round">people</span>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <p class="small text-muted fw-bold px-3 mt-3 mb-1 text-uppercase" style="font-size: 0.7rem;">Pusat Komunikasi</p>
                    <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" data-no-swup>
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

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin Ingin Keluar?',
                text: 'Anda akan keluar dari panel admin.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4338CA',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        function confirmGoToLanding() {
            Swal.fire({
                title: 'Kembali ke Landing Page?',
                text: 'Anda akan diarahkan ke halaman utama.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Ke Landing Page',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/';
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>