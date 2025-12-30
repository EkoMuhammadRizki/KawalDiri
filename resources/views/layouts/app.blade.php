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
    <link href="{{ asset('css/custom-bootstrap.css') }}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" data-swup-ignore-script></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" data-swup-ignore-script></script>

    @stack('styles')
</head>

<body>

    @include('components.sidebar')

    <div class="main-content">
        <div id="swup" class="transition-fade">
            @include('components.header')
            @yield('content')
        </div>
    </div>

    <!-- Modals Stack -->
    @stack('modals')

    <!-- Bootstrap Bundle JS -->
    <!-- data-swup-ignore-script ditambahkan untuk mencegah inisialisasi ulang saat navigasi, menghindari masalah background modal menumpuk -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-swup-ignore-script></script>

    <!-- Swup JS -->
    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://unpkg.com/@swup/scripts-plugin@2"></script>
    <script src="https://unpkg.com/@swup/head-plugin@2"></script>
    <script src="https://unpkg.com/@swup/preload-plugin@3"></script>

    <style>
        .transition-fade {
            transition: 0.3s ease-in-out;
            opacity: 1;
            transform: scale(1);
        }

        html.is-animating .transition-fade {
            opacity: 0;
            transform: scale(0.99);
        }
    </style>

    @stack('scripts')

    <script>
        window.swup = new Swup({
            plugins: [new SwupScriptsPlugin(), new SwupHeadPlugin(), new SwupPreloadPlugin()],
            containers: ["#swup"],
            cache: true,
            linkSelector: 'a[href^="' + window.location.origin + '"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), .nav-link'
        });

        // Manual Active State Management for Sidebar
        swup.hooks.on('content:replace', () => {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                const linkPath = new URL(href, window.location.origin).pathname;

                // Simple strict match or "starts with" for sub-routes
                if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Re-init Sidebar Profile Toggle if exists (defensive)
            if (window.toggleProfileMenu) {
                // Ensure events are attached if they were lost (though sidebar is static, safe to check)
            }
        });
    </script>
</body>

</html>