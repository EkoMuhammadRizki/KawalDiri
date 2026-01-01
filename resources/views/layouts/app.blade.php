<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dasbor Terpadu - Kawal Diri')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo Favicon.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Custom CSS -->
    <!-- Custom CSS & Vite -->
    <!-- Custom CSS (Static) -->
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <!-- Theme Manager -->
    <style>
        :root {

            /* Default Accent Color */
            --accent-color: {
                    {
                    Auth: :check() ? Auth::user()->accent_color: '#6366f1'
                }
            }

            ;
            --accent-color-rgb: 99,
            102,
            241;
            --accent-color-hover: #5558e3;
            --accent-color-light: #818cf8;

            /* Light Mode Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #1a202c;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* Dark Mode Colors */
        [data-theme="dark"] {
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --bg-tertiary: #4a5568;
            --text-primary: #f7fafc;
            --text-secondary: #e2e8f0;
            --text-muted: #cbd5e0;
            --border-color: #4a5568;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0, 4);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.5);
        }

        /* Apply theme colors */
        body {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Comprehensive Styling */
        [data-theme="dark"] .bg-light {
            background-color: var(--bg-secondary) !important;
        }

        [data-theme="dark"] .bg-white,
        [data-theme="dark"] .card {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .card-header {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        [data-theme="dark"] .text-dark {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .border,
        [data-theme="dark"] .border-bottom {
            border-color: var(--border-color) !important;
        }

        /* Sidebar Dark Mode */
        [data-theme="dark"] .sidebar {
            background-color: var(--bg-primary) !important;
            border-right-color: var(--border-color) !important;
        }

        [data-theme="dark"] .sidebar .nav-link {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .sidebar .nav-link:hover {
            background-color: var(--bg-tertiary) !important;
        }

        [data-theme="dark"] .sidebar .nav-link.active {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
        }

        [data-theme="dark"] .offcanvas {
            background-color: var(--bg-primary) !important;
        }

        /* Forms Dark Mode */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--accent-color-rgb), 0.25);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-muted);
        }

        [data-theme="dark"] .input-group-text {
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        /* Buttons Dark Mode */
        [data-theme="dark"] .btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .btn-outline-secondary:hover {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
        }

        [data-theme="dark"] .btn-light {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .btn-light:hover {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        /* Tables Dark Mode */
        [data-theme="dark"] .table {
            color: var(--text-primary);
        }

        [data-theme="dark"] .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.03);
        }

        [data-theme="dark"] .table-hover>tbody>tr:hover {
            background-color: var(--bg-tertiary);
        }

        /* Modals Dark Mode */
        [data-theme="dark"] .modal-content {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-footer {
            border-color: var(--border-color);
        }

        /* Badges & Alerts Dark Mode */
        [data-theme="dark"] .badge {
            color: #ffffff;
        }

        [data-theme="dark"] .alert {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        /* Breadcrumb Dark Mode */
        [data-theme="dark"] .breadcrumb-item+.breadcrumb-item::before {
            color: var(--text-muted);
        }

        [data-theme="dark"] .breadcrumb-item a {
            color: var(--text-secondary);
        }

        /* Dropdowns Dark Mode */
        [data-theme="dark"] .dropdown-menu {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .dropdown-item {
            color: var(--text-primary);
        }

        [data-theme="dark"] .dropdown-item:hover {
            background-color: var(--bg-tertiary);
        }

        /* List Groups Dark Mode */
        [data-theme="dark"] .list-group-item {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* Accordion Dark Mode */
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

        /* Accent color application */
        .btn-primary-custom,
        .bg-primary,
        .badge.bg-primary {
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        .btn-primary-custom:hover {
            background-color: var(--accent-color-hover) !important;
        }

        .text-primary {
            color: var(--accent-color) !important;
        }

        .border-primary {
            border-color: var(--accent-color) !important;
        }

        .material-symbols-outlined.text-primary {
            color: var(--accent-color) !important;
        }

        /* Sidebar active link */
        .sidebar .nav-link.active {
            background-color: var(--accent-color) !important;
        }

        /* Progress bars, badges, etc */
        .progress-bar,
        .badge.bg-primary-subtle {
            background-color: var(--accent-color) !important;
        }

        /* SweetAlert Dark Mode */
        [data-theme="dark"] .swal2-popup {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] .swal2-title,
        [data-theme="dark"] .swal2-content {
            color: var(--text-primary) !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-light"
    data-user-theme="{{ Auth::check() ? Auth::user()->theme_preference : 'system' }}"
    data-user-accent="{{ Auth::check() ? Auth::user()->accent_color : '#6366f1' }}">


    <div class="main-wrapper">
        @include('components.sidebar')

        <div class="main-content">
            <!-- Header (Mobile Toggle + Page Title) -->
            <header class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom d-md-none">
                <button class="btn btn-light border d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h5 class="fw-bold mb-0">@yield('title', 'Dashboard')</h5>
                <div style="width: 40px;"></div> <!-- Spacer -->
            </header>

            <main id="swup" class="transition-fade">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modals Stack -->
    @stack('modals')

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Manager -->
    <script src="{{ asset('js/theme-manager.js') }}"></script>

    <!-- Swup JS -->
    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://unpkg.com/@swup/scripts-plugin@2"></script>
    <script src="https://unpkg.com/@swup/head-plugin@2"></script>

    <script>
        const swup = new Swup({
            containers: ["#swup"],
            plugins: [new SwupScriptsPlugin(), new SwupHeadPlugin()],
            linkSelector: 'a[href^="' + window.location.origin + '"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), .nav-link'
        });

        // Function to update sidebar icon based on route
        function updateSidebarIcon() {
            const currentPath = window.location.pathname;
            const iconElement = document.querySelector('.sidebar .material-symbols-outlined');

            if (!iconElement) return;

            const iconMap = {
                '/dashboard': 'dashboard',
                '/tasks': 'check_circle',
                '/finance': 'payments',
                '/settings': 'settings',
                '/help': 'help'
            };

            let newIcon = 'spa'; // default
            for (const [path, icon] of Object.entries(iconMap)) {
                if (currentPath === path || currentPath.startsWith(path + '/')) {
                    newIcon = icon;
                    break;
                }
            }
            iconElement.textContent = newIcon;
        }

        // Re-init logic after Swup transition
        function reinitScripts() {
            // Re-initialize Bootstrap components
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Update Sidebar Active State
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                const linkPath = new URL(href, window.location.origin).pathname;
                if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Update Sidebar Icon
            updateSidebarIcon();

            // Re-init Sidebar Profile Toggle if exists
            if (window.toggleProfileMenu) {
                // Ensure events are attached if they were lost
            }
        }

        swup.hooks.on('content:replace', reinitScripts);

        // Run on initial load too
        document.addEventListener('DOMContentLoaded', () => {
            updateSidebarIcon();
        });
    </script>
    @yield('scripts')
</body>

</html>