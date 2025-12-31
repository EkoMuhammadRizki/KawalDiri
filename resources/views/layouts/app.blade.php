<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor Terpadu - Kawal Diri')</title>

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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @stack('styles')
</head>

<body class="bg-light">

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
</body>

</html>