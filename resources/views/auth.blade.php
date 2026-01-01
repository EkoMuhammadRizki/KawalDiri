<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - KawalDiri</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo Favicon.png') }}">

    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS (Static) -->
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --overlay-gradient: linear-gradient(135deg, #5b42f3 0%, #6366f1 100%);
            --bg-gradient: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);
            --input-bg: #F3F4F6;
            --text-main: #1f2937;
            --text-muted: #6b7280;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100%;
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* External Header (Logo) */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
            z-index: 10;
        }

        .auth-header img {
            height: 50px;
            width: auto;
        }

        /* Main Container */
        .container-auth {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            /* Soft shadow */
            position: relative;
            overflow: hidden;
            width: 1100px;
            /* Slightly wider */
            max-width: 95%;
            min-height: 600px;
            /* Compact to fit everything */
        }

        /* Forms Area */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 60px;
            text-align: left;
            width: 50%;
        }

        /* Mobile handling logic remains similar but hidden */
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container-auth.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container-auth.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        /* Overlay (Purple Panel) */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
            border-radius: 0 30px 30px 0;
            /* Initially right side rounded */
        }

        .container-auth.right-panel-active .overlay-container {
            transform: translateX(-100%);
            border-radius: 30px 0 0 30px;
            /* Switch rounded side */
        }

        .overlay {
            background: linear-gradient(135deg, #5b46e5 0%, #7c3aed 100%);
            /* Strong purple */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container-auth.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container-auth.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container-auth.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        h1.title-main {
            font-weight: 800;
            font-size: 1.6rem;
            color: #111827;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .gradient-text {
            background: linear-gradient(90deg, #d946ef, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        /* Inputs */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-custom {
            background-color: var(--input-bg);
            border: 1px solid transparent;
            padding: 0.65rem 1rem 0.65rem 2.8rem;
            /* Space for icon */
            border-radius: 10px;
            width: 100%;
            outline: none;
            transition: 0.3s;
            color: var(--text-main);
            font-weight: 500;
        }

        .form-control-custom::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .form-control-custom:focus {
            background-color: #fff;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 0.75rem;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 20px;
            color: #9ca3af;
            font-size: 20px;
            pointer-events: none;
        }

        .password-toggle-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 20px;
            cursor: pointer;
            z-index: 5;
            user-select: none;
            transition: color 0.3s;
        }

        .password-toggle-icon:hover {
            color: #6366f1;
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.9rem;
            border-radius: 12px;
            width: 100%;
            margin-top: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
            transition: 0.3s;
            font-size: 1rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .btn-outline-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: 0.3s;
            margin-top: 2rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Checkbox */
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.15em;
            border-radius: 4px;
            border: 2px solid #d1d5db;
        }

        .form-check-input:checked {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
        }

        /* Floating Icons in Overlay */
        .floating-icon-wrapper {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 24px;
            backdrop-filter: blur(12px);
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 120px;
            height: 130px;
            justify-content: center;
        }

        .icon-box {
            background: white;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7c3aed;
            margin-bottom: 12px;
            font-size: 24px;
        }

        .icon-label {
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .container-auth {
                width: 100%;
                min-height: auto;
                height: auto;
                margin: 20px;
                border-radius: 20px;
            }

            .form-container {
                position: relative;
                width: 100%;
                height: auto;
                padding: 40px 30px;
            }

            .overlay-container {
                display: none;
            }

            .sign-in-container,
            .sign-up-container {
                width: 100%;
                opacity: 1;
                z-index: 1;
            }

            .sign-in-container {
                display: block;
            }

            .sign-up-container {
                display: none;
            }

            .container-auth.right-panel-active .sign-in-container {
                display: none;
            }

            .container-auth.right-panel-active .sign-up-container {
                display: block;
                transform: none;
                opacity: 1;
                animation: none;
            }

            .mobile-toggle {
                display: block;
                margin-top: 2rem;
                text-align: center;
                color: #8b5cf6;
                font-weight: 600;
                cursor: pointer;
            }
        }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none;
            }
        }

        /* Footer Links */
        .auth-footer {
            margin-top: 1rem;
            display: flex;
            gap: 2rem;
            z-index: 100;
            position: relative;
        }

        .auth-footer a {
            color: #ffffff;
            /* Explicit White for visibility on vibrant background */
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            /* Shadow for legibility */
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .auth-footer a:hover {
            color: #6b7280;
        }

        .btn-back-home {
            position: absolute;
            top: 25px;
            left: 25px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
    </style>
    @include('components.loading-overlay')
</head>

<body>
    <a href="{{ url('/') }}" class="btn-back-home">
        <span class="material-symbols-rounded" style="font-size: 20px;">arrow_back</span>
        <span>Kembali</span>
    </a>
    <div class="auth-header">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/Logo.png') }}" alt="KawalDiri Logo">
        </a>
    </div>

    <!-- Main Card -->
    <div class="container-auth {{ request()->routeIs('register') ? 'right-panel-active' : '' }}" id="container">

        <!-- LOGIN FORM -->
        <div class="form-container sign-in-container">
            <form action="{{ route('login.post') }}" method="POST" novalidate id="loginForm" style="width: 100%;">
                @csrf
                <div class="text-start w-100 mb-2">
                    <h1 class="title-main">Selamat <br><span class="gradient-text">Datang Kembali.</span></h1>
                    <p class="subtitle">Masuk untuk melanjutkan perjalanan produktif Anda.</p>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger p-2 small w-100 rounded-3 border-0 bg-danger-subtle text-danger mb-4">
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="w-100">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">alternate_email</span>
                        <input type="email" name="email" class="form-control-custom" placeholder="nama@email.com" value="{{ old('email') }}" required />
                    </div>
                </div>

                <div class="w-100">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">lock</span>
                        <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required />
                        <span class="material-symbols-rounded password-toggle-icon">visibility_off</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center w-100 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label small text-muted ms-1" for="rememberMe">Ingat Saya</label>
                    </div>
                    <a href="#" class="text-decoration-none fw-bold small" style="color: #6366f1;">Lupa sandi?</a>
                </div>

                <button type="submit" class="btn-primary-custom">Masuk Sekarang</button>

                <div class="mobile-toggle" id="mobileSignUp">Belum punya akun? Daftar Gratis</div>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div class="form-container sign-up-container">
            <form action="{{ route('register.post') }}" method="POST" novalidate id="registerForm" style="width: 100%;">
                @csrf
                <div class="text-start w-100 mb-2">
                    <h1 class="title-main">Buat <br><span class="gradient-text">Akun Baru.</span></h1>
                    <p class="subtitle">Daftar sekarang untuk memulai perjalanan Anda.</p>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger p-2 small w-100 rounded-3 border-0 bg-danger-subtle text-danger mb-4">
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="w-100">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">person</span>
                        <input type="text" name="name" class="form-control-custom" placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required />
                    </div>
                </div>

                <div class="w-100">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">alternate_email</span>
                        <input type="email" name="email" class="form-control-custom" placeholder="nama@email.com" value="{{ old('email') }}" required />
                    </div>
                </div>

                <div class="w-100 position-relative mb-4">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">lock</span>
                        <input type="password" name="password" class="form-control-custom" id="registerPassword" placeholder="Buat kata sandi" required />
                        <span class="material-symbols-rounded password-toggle-icon">visibility_off</span>
                    </div>
                    <!-- Password Strength Meter (Floating) -->
                    <div id="passwordStrengthBox" style="display: none; position: absolute; bottom: -22px; left: 0; width: 100%; z-index: 10;">
                        <div class="progress" style="height: 4px; border-radius: 2px; background-color: #e9ecef;">
                            <div class="progress-bar transition-width duration-300" role="progressbar" id="passwordStrengthBar" style="width: 0%; border-radius: 2px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mt-1 mb-0 text-muted fw-bold" style="font-size: 0.65rem; text-align: right; line-height: 1;" id="passwordStrengthText"></p>
                    </div>
                </div>



                <div class="w-100">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-group-custom">
                        <span class="material-symbols-rounded input-icon">lock_reset</span>
                        <input type="password" name="password_confirmation" class="form-control-custom" id="confirmPassword" placeholder="Ulangi kata sandi" required />
                        <span class="material-symbols-rounded password-toggle-icon">visibility_off</span>
                    </div>
                </div>

                <div class="form-check text-start w-100 mb-4 mt-2">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckTerms" required>
                    <label class="form-check-label small text-muted ms-1" for="flexCheckTerms" style="font-size: 0.8rem; line-height: 1.4;">
                        Saya setuju dengan <a href="#" class="fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal" style="color: #6366f1;">Kebijakan Privasi</a> & <a href="#" class="fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal" style="color: #6366f1;">Syarat & Ketentuan</a>
                    </label>
                </div>

                <button type="submit" class="btn-primary-custom">Daftar Sekarang</button>

                <div class="mobile-toggle" id="mobileSignIn">Sudah punya akun? Masuk</div>
            </form>
        </div>

        <!-- OVERLAY PANEL -->
        <div class="overlay-container">
            <div class="overlay">
                <!-- Overlay Left (Visible when Registering) -->
                <div class="overlay-panel overlay-left">
                    <div class="mb-5">
                        <span class="material-symbols-rounded" style="font-size: 64px; color: rgba(255,255,255,0.9);">waving_hand</span>
                    </div>

                    <h2 class="fw-bold display-6 mb-3 text-white">Sudah Punya Akun?</h2>
                    <p class="mb-5 text-white fs-6 px-4">Tetap terhubung dengan target finansial dan produktivitas harian Anda.</p>

                    <button class="btn-outline-custom" id="signIn">Masuk</button>
                </div>

                <!-- Overlay Right (Visible when Logging In) -->
                <div class="overlay-panel overlay-right">
                    <div class="d-flex gap-4 mb-5">
                        <div class="floating-icon-wrapper">
                            <div class="icon-box">
                                <span class="material-symbols-rounded fw-bold">check_circle</span>
                            </div>
                            <span class="icon-label">Tugas</span>
                        </div>
                        <div class="floating-icon-wrapper">
                            <div class="icon-box">
                                <span class="material-symbols-rounded fw-bold">account_balance_wallet</span>
                            </div>
                            <span class="icon-label">Keuangan</span>
                        </div>
                    </div>

                    <h2 class="fw-bold display-6 mb-3 text-white">Baru di KawalDiri?</h2>
                    <p class="mb-5 text-white fs-6 px-4">Mulai perjalanan Anda menuju kebebasan finansial dan hidup yang lebih teratur.</p>

                    <button class="btn-outline-custom" id="signUp">Daftar Gratis</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="auth-footer">
        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Kebijakan Privasi</a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a>
        <a href="#">Pusat Bantuan</a>
    </div>

    <!-- Modal Terms -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold font-monospace" id="termsModalLabel" style="font-family: 'Montserrat', sans-serif;">Kebijakan Privasi & Syarat Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="font-family: 'Montserrat', sans-serif;">
                    <p class="text-muted small mb-4">Terakhir diperbarui: 01 Januari 2026</p>

                    <h6 class="fw-bold text-primary mb-2">1. Pendahuluan</h6>
                    <p class="small text-secondary mb-3">Selamat datang di KawalDiri. Dengan mendaftar, mengakses, atau menggunakan aplikasi ini, Anda setuju untuk terikat dengan syarat dan ketentuan ini. Kami berkomitmen untuk melindungi privasi data Anda dan memberikan pengalaman pengguna yang aman.</p>

                    <h6 class="fw-bold text-primary mb-2">2. Pengumpulan Data</h6>
                    <p class="small text-secondary mb-3">Kami mengumpulkan informasi dasar seperti nama dan alamat email untuk keperluan otentikasi. Data keuangan dan tugas yang Anda masukkan disimpan secara privat dan hanya dapat diakses oleh Anda.</p>

                    <h6 class="fw-bold text-primary mb-2">3. Keamanan Informasi</h6>
                    <p class="small text-secondary mb-3">Kami menggunakan standar keamanan industri untuk melindungi informasi pribadi Anda dari akses tidak sah, pengungkapan, atau penyalahgunaan.</p>

                    <h6 class="fw-bold text-primary mb-2">4. Tanggung Jawab Pengguna</h6>
                    <p class="small text-secondary mb-3">Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi akun Anda. Segala aktivitas yang terjadi di bawah akun Anda adalah tanggung jawab Anda sepenuhnya.</p>

                    <h6 class="fw-bold text-primary mb-2">5. Persetujuan</h6>
                    <p class="small text-secondary mb-0">Dengan mencentang kotak persetujuan pada formulir pendaftaran, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh kebijakan ini.</p>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal" style="background: linear-gradient(90deg, #6366f1, #8b5cf6); border: none;">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Init Auth Toggle Logic
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const mobileSignUp = document.getElementById('mobileSignUp');
        const mobileSignIn = document.getElementById('mobileSignIn');

        if (signUpButton && container) {
            signUpButton.addEventListener('click', () => container.classList.add("right-panel-active"));
        }

        if (signInButton && container) {
            signInButton.addEventListener('click', () => container.classList.remove("right-panel-active"));
        }

        // Mobile Fallback
        if (mobileSignUp) mobileSignUp.addEventListener('click', () => container.classList.add("right-panel-active"));
        if (mobileSignIn) mobileSignIn.addEventListener('click', () => container.classList.remove("right-panel-active"));

        // Validation Logic (SweetAlert)
        // Validation Logic (SweetAlert)
        function initValidation() {
            // Password Strength Logic
            const registerPassword = document.getElementById('registerPassword');
            const strengthBox = document.getElementById('passwordStrengthBox');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');

            if (registerPassword) {
                registerPassword.addEventListener('input', function() {
                    const password = this.value;
                    const minLength = 8;
                    let strength = 0;

                    if (password.length > 0) {
                        strengthBox.style.display = 'block';
                    } else {
                        strengthBox.style.display = 'none';
                        return;
                    }

                    // Strength Calculation
                    if (password.length >= minLength) strength += 1;
                    if (/[A-Z]/.test(password)) strength += 1;
                    if (/[0-9]/.test(password)) strength += 1;
                    if (/[^A-Za-z0-9]/.test(password)) strength += 1;

                    let width = '0%';
                    let color = 'bg-danger';
                    let text = 'Lemah';

                    switch (strength) {
                        case 0:
                        case 1:
                            width = '25%';
                            color = 'bg-danger';
                            text = 'Lemah';
                            break;
                        case 2:
                            width = '50%';
                            color = 'bg-warning';
                            text = 'Sedang';
                            break;
                        case 3:
                            width = '75%';
                            color = 'bg-info';
                            text = 'Kuat';
                            break;
                        case 4:
                            width = '100%';
                            color = 'bg-success';
                            text = 'Sangat Kuat';
                            break;
                    }

                    // Strict Length Check Override
                    if (password.length < 8) {
                        width = '10%';
                        color = 'bg-danger';
                        text = 'Minimal 8 Karakter';
                    }

                    strengthBar.style.width = width;
                    strengthBar.className = `progress-bar ${color}`;
                    strengthText.textContent = text;
                    strengthText.className = `mt-1 mb-0 fw-bold small text-end ${color.replace('bg-', 'text-')}`;
                });
            }

            // --- Password Toggle Logic ---
            const toggleIcons = document.querySelectorAll('.password-toggle-icon');
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input && input.tagName === 'INPUT') {
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);

                        // Toggle Icon Text
                        this.innerText = type === 'password' ? 'visibility_off' : 'visibility';
                    }
                });
            });

            // Login Form
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const email = loginForm.querySelector('input[name="email"]');
                    const password = loginForm.querySelector('input[name="password"]');

                    if (!email.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap isi alamat Email Anda.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => email.focus(), 300));
                        return;
                    }
                    if (!password.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap isi Kata Sandi Anda.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => password.focus(), 300));
                        return;
                    }
                });
            }

            // Register Form
            const registerForm = document.getElementById('registerForm');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const name = registerForm.querySelector('input[name="name"]');
                    const email = registerForm.querySelector('input[name="email"]');
                    const password = registerForm.querySelector('input[name="password"]');
                    const confirmPassword = registerForm.querySelector('input[name="password_confirmation"]');
                    const terms = registerForm.querySelector('input[id="flexCheckTerms"]');

                    // Base Validation
                    if (!name.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap isi Nama Lengkap Anda.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => name.focus(), 300));
                        return;
                    }
                    if (!email.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap isi alamat Email Anda.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => email.focus(), 300));
                        return;
                    }

                    // Password Validation
                    if (!password.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap buat Kata Sandi.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => password.focus(), 300));
                        return;
                    }
                    if (password.value.length < 8) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Kata sandi minimal harus 8 karakter.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => password.focus(), 300));
                        return;
                    }

                    // Confirm Password Logic
                    if (!confirmPassword.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Harap konfirmasi Kata Sandi Anda.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => confirmPassword.focus(), 300));
                        return;
                    }
                    if (password.value !== confirmPassword.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Kata Sandi Tidak Cocok',
                            text: 'Kata sandi dan konfirmasi kata sandi harus sama.',
                            confirmButtonColor: '#8b5cf6'
                        }).then(() => setTimeout(() => confirmPassword.focus(), 300));
                        return;
                    }

                    if (!terms.checked) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Anda harus menyetujui Syarat & Ketentuan.',
                            confirmButtonColor: '#8b5cf6'
                        });
                        return;
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', initValidation);
    </script>
</body>

</html>