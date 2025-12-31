<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KawalDiri - Partner Pertumbuhanmu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (Static) -->
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --finance-color: #059669;
            --bg-light: #fafafa;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            overflow-x: hidden;
        }


        /* Hero Background Decorations */
        .hero-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        /* Navbar Customization */
        .navbar {
            background-color: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid #f1f5f9;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main) !important;
            margin: 0 10px;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Buttons */
        .btn-kd-primary {
            background-color: var(--text-main);
            color: white;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
        }

        .btn-kd-primary:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
            color: white;
        }

        .btn-kd-gradient {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 15px;
            padding: 15px 35px;
            font-weight: 700;
            border: none;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        /* Dashboard Mockup */
        .mockup-container {
            background: white;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: relative;
        }

        .card-stat {
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        .section-padding {
            padding: 100px 0;
        }

        .font-black {
            font-weight: 900;
        }

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
</head>

<body>


    <div class="main-content">
        @include('components.navbar')

        @yield('content')

        @include('components.footer')
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>