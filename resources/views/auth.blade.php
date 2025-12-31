<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - KawalDiri</title>

    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS (Static) -->
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">

    <style>
        /* Global Reset to prevent gaps */
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow-x: hidden;
            background-color: #f8fafc;
        }

        /* Sliding Auth Page Styles - Scoped inline for reliability with Swup */
        .auth-page .transition-fade {
            transition: 0.3s ease-in-out;
            opacity: 1;
            transform: scale(1);
        }

        html.is-animating .auth-page .transition-fade {
            opacity: 0;
            transform: scale(0.99);
        }

        .auth-page {
            /* Root variables scoped if possible */
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --secondary-color: #f43f5e;
            --bg-light: #f8fafc;

            font-family: 'Montserrat', sans-serif;
            width: 100%;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            margin: 0;
        }

        /* Background Blobs */
        .auth-page .blob {
            position: absolute;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
            border-radius: 50%;
            animation: pulse 8s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.2);
            }
        }

        /* Sliding Container Styles */
        .auth-page .container-auth {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.05), 0 10px 10px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
            width: 1000px;
            max-width: 100%;
            min-height: 600px;
        }

        .auth-page .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: #fff;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            text-align: left;
        }

        .auth-page .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .auth-page .container-auth.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .auth-page .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .auth-page .container-auth.right-panel-active .sign-up-container {
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

        .auth-page .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .auth-page .container-auth.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .auth-page .overlay {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
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

        .auth-page .container-auth.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .auth-page .overlay-panel {
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

        .auth-page .overlay-left {
            transform: translateX(-20%);
        }

        .auth-page .container-auth.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .auth-page .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .auth-page .container-auth.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        /* Form Customization */
        .auth-page .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
            font-weight: 500;
            margin-bottom: 0.5rem;
            width: 100%;
        }

        .auth-page .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
            background-color: #fff;
        }

        .auth-page .input-group-icon {
            position: relative;
            width: 100%;
            background-color: #f8fafc;
        }

        .auth-page .input-wrapper {
            position: relative;
            width: 100%;
        }

        .auth-page .input-wrapper .material-symbols-outlined {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 5;
            font-size: 20px;
            pointer-events: none;
        }

        .auth-page .input-group-block {
            width: 100%;
            margin-bottom: 1rem;
            text-align: left;
        }

        .auth-page .input-label {
            display: block;
            text-align: left;
            margin-bottom: 0.4rem;
            width: 100%;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .auth-page .btn-auth {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 0.75rem;
            padding: 0.8rem 2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white;
            transition: 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .auth-page .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .auth-page .btn-outline-white {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.8rem 2rem;
            font-weight: 700;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .auth-page .btn-outline-white:hover {
            background: #fff;
            color: var(--primary-color);
        }

        .auth-page .text-gradient {
            background: linear-gradient(to right, #4f46e5, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Floating Icons for Overlay */
        .auth-page .floating-icon-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 15px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(5px);
            width: 80px;
            height: 90px;
            justify-content: center;
        }

        .auth-page .icon-circle {
            width: 30px;
            height: 30px;
            background: #fff;
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .auth-page .welcome-text h2 {
            line-height: 1.2;
        }

        @media (max-width: 768px) {
            .auth-page .container-auth {
                min-height: 800px;
                width: 100%;
                margin: 20px;
            }

            .auth-page .form-container {
                width: 100%;
                height: 50%;
                transition: none;
            }

            .auth-page .overlay-container {
                display: none;
            }

            .auth-page .sign-in-container,
            .auth-page .sign-up-container {
                width: 100%;
                position: relative;
                height: auto;
                opacity: 1;
                z-index: 1;
                animation: none;
                padding: 40px;
            }

            .auth-page .container-auth {
                height: auto;
                display: block;
                overflow: visible;
            }

            .auth-page .sign-up-container {
                display: none;
            }

            .auth-page .container-auth.right-panel-active .sign-up-container {
                display: block;
                transform: none;
            }

            .auth-page .container-auth.right-panel-active .sign-in-container {
                display: none;
                transform: none;
            }

            .auth-page .mobile-toggle {
                display: block;
                margin-top: 20px;
                color: var(--primary-color);
                font-weight: bold;
                cursor: pointer;
            }
        }

        @media (min-width: 769px) {
            .auth-page .mobile-toggle {
                display: none;
            }
        }

        .auth-page .btn-back-home {
            position: absolute;
            top: 25px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            z-index: 100;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .auth-page .btn-back-home:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .overlay-left .btn-back-home {
            left: 30px;
        }

        .overlay-right .btn-back-home {
            right: 30px;
        }
    </style>
</head>

<body>

    <div class="auth-page" style="width: 100%; display: flex; justify-content: center;">
        <div class="blob bg-primary" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
        <div class="blob bg-danger" style="width: 300px; height: 300px; bottom: -50px; right: -50px;"></div>

        <div class="container-auth {{ request()->routeIs('register') ? 'right-panel-active' : '' }}" id="container">

            <!-- LOGIN FORM -->
            <div class="form-container sign-in-container">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px;">
                            <span class="material-symbols-outlined fs-5">grid_view</span>
                        </div>
                        <h3 class="fw-bold mb-0">KawalDiri</h3>
                    </div>

                    <div class="welcome-text mb-4">
                        <h2 class="fw-black mb-0">Selamat <span class="text-gradient">Datang</span></h2>
                        <h2 class="fw-black text-gradient">Kembali.</h2>
                    </div>

                    <p class="text-muted small mb-4">Masuk untuk melanjutkan perjalanan produktif Anda.</p>

                    @if ($errors->any())
                    <div class="alert alert-danger p-2 small w-100">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="input-group-block">
                        <label class="input-label">Email</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined">alternate_email</span>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required value="{{ old('email') }}" />
                        </div>
                    </div>

                    <div class="input-group-block">
                        <label class="input-label">Kata Sandi</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required />
                        </div>
                        <div class="text-end mt-1">
                            <a href="#" class="text-decoration-none fw-bold text-primary" style="font-size: 0.75rem;">Lupa Sandi?</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start w-100 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                            <label class="form-check-label small fw-medium" for="rememberMe">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth">Masuk Sekarang</button>

                    <div class="mobile-toggle" id="mobileSignUp">Belum punya akun? Daftar dulu</div>
                </form>
            </div>

            <!-- REGISTER FORM -->
            <div class="form-container sign-up-container">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px;">
                            <span class="material-symbols-outlined fs-5">grid_view</span>
                        </div>
                        <h3 class="fw-bold mb-0">KawalDiri</h3>
                    </div>

                    <div class="welcome-text mb-2">
                        <h2 class="fw-black mb-0">Mulai <span class="text-gradient">Hidup Baru.</span></h2>
                    </div>
                    <p class="text-muted small mb-4">Bergabunglah dan atur hidup Anda secara efisien.</p>

                    @if ($errors->any())
                    <div class="alert alert-danger p-2 small w-100">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="input-group-block">
                        <label class="input-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined">person</span>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required value="{{ old('name') }}" />
                        </div>
                    </div>

                    <div class="input-group-block">
                        <label class="input-label">Email</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined">alternate_email</span>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required value="{{ old('email') }}" />
                        </div>
                    </div>

                    <div class="input-group-block">
                        <label class="input-label">Kata Sandi</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Buat kata sandi" minlength="8" required />
                        </div>
                        <!-- Password Strength Meter -->
                        <div class="mt-2" id="passwordStrengthBox" style="display: none;">
                            <div class="progress" style="height: 4px; border-radius: 2px; background-color: #e9ecef;">
                                <div class="progress-bar transition-width duration-300" role="progressbar" id="passwordStrengthBar" style="width: 0%; border-radius: 2px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mt-1 mb-0 text-muted fw-medium" style="font-size: 0.7rem;" id="passwordStrengthText"></p>
                        </div>
                    </div>

                    <div class="form-check text-start w-100 mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckTerms" required
                            oninvalid="this.setCustomValidity('Harap centang kotak ini jika Anda ingin melanjutkan.')"
                            oninput="this.setCustomValidity('')">
                        <label class="form-check-label x-small text-muted" for="flexCheckTerms" style="font-size: 0.75rem;">
                            Saya setuju dengan <a href="#" class="fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal">Ketentuan dan Kebijakan Privasi</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-auth">Buat Akun Gratis</button>

                    <div class="mobile-toggle" id="mobileSignIn">Sudah punya akun? Masuk</div>
                </form>
            </div>

            <!-- OVERLAY -->
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <a href="{{ route('home') }}" class="btn-back-home" onclick="sessionStorage.setItem('scrollToTop', 'true')">
                            <span class="material-symbols-outlined fs-6">arrow_back</span>
                        </a>
                        <div class="mb-4 text-white">
                            <span class="material-symbols-outlined" style="font-size: 54px;">waving_hand</span>
                        </div>
                        <h2 class="fw-bold display-6 mb-3 text-white">Sudah Punya Akun?</h2>
                        <p class="mb-4 text-white-50">Silakan masuk kembali untuk melanjutkan produktivitas Anda.</p>
                        <button class="btn-outline-white" id="signIn">Masuk Saja</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <a href="{{ route('home') }}" class="btn-back-home" onclick="sessionStorage.setItem('scrollToTop', 'true')">
                            <span class="material-symbols-outlined fs-6">arrow_back</span>
                        </a>
                        <!-- Updated Right Overlay to match reference -->
                        <div class="d-flex gap-3 mb-4">
                            <div class="floating-icon-card">
                                <div class="icon-circle bg-white text-primary">
                                    <span class="material-symbols-outlined fs-6 fw-bold">check</span>
                                </div>
                                <span class="text-white fw-bold" style="font-size: 9px; letter-spacing: 1px;">TUGAS</span>
                            </div>
                            <div class="floating-icon-card">
                                <div class="icon-circle bg-white text-primary">
                                    <span class="material-symbols-outlined fs-6 fw-bold">account_balance_wallet</span>
                                </div>
                                <span class="text-white fw-bold" style="font-size: 9px; letter-spacing: 1px;">KEUANGAN</span>
                            </div>
                        </div>

                        <h2 class="fw-bold display-6 mb-3 text-white">Baru di KawalDiri?</h2>
                        <p class="mb-4 text-white-50">Mulai perjalanan Anda menuju kebebasan finansial dan hidup yang lebih teratur hari ini.</p>
                        <button class="btn-outline-white" id="signUp">Daftar Gratis</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script Logic moved inside Swup container to ensure re-execution -->
        <script>
            function initAuthLogic() {
                const signUpButton = document.getElementById('signUp');
                const signInButton = document.getElementById('signIn');
                const container = document.getElementById('container');
                const mobileSignUp = document.getElementById('mobileSignUp');
                const mobileSignIn = document.getElementById('mobileSignIn');

                if (signUpButton && container) {
                    signUpButton.addEventListener('click', () => {
                        container.classList.add("right-panel-active");
                    });
                }

                if (signInButton && container) {
                    signInButton.addEventListener('click', () => {
                        container.classList.remove("right-panel-active");
                    });
                }

                // Mobile Fallback logic
                if (mobileSignUp && container) {
                    mobileSignUp.addEventListener('click', () => {
                        container.classList.add("right-panel-active");
                    });
                }
                if (mobileSignIn && container) {
                    mobileSignIn.addEventListener('click', () => {
                        container.classList.remove("right-panel-active");
                    });
                }

                // Password Strength Meter Logic
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

                        if (password.length < minLength) {
                            strengthBar.style.width = '30%';
                            strengthBar.className = 'progress-bar bg-danger';
                            strengthText.textContent = 'Minimal 8 karakter';
                            strengthText.className = 'mt-1 mb-0 text-danger fw-bold';
                            strengthBox.querySelector('.progress').className = 'progress'; // Reset glow
                            return;
                        }

                        // Check for mixed case
                        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
                        // Check for numbers
                        if (/\d/.test(password)) strength += 1;
                        // Check for special chars
                        if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

                        if (strength === 0) {
                            strengthBar.style.width = '50%';
                            strengthBar.className = 'progress-bar bg-warning';
                            strengthText.textContent = 'Lemah';
                            strengthText.className = 'mt-1 mb-0 text-warning fw-bold';
                        } else if (strength === 1 || strength === 2) {
                            strengthBar.style.width = '75%';
                            strengthBar.className = 'progress-bar bg-info';
                            strengthText.textContent = 'Sedang';
                            strengthText.className = 'mt-1 mb-0 text-info fw-bold';
                        } else if (strength >= 3) {
                            strengthBar.style.width = '100%';
                            strengthBar.className = 'progress-bar bg-success';
                            strengthText.textContent = 'Kuat';
                            strengthText.className = 'mt-1 mb-0 text-success fw-bold';
                        }

                        // Keep the font size
                        strengthText.style.fontSize = '0.7rem';
                    });
                }
            }

            // Run on load
            initAuthLogic();
        </script>
    </div> <!-- End Swup Wrapper -->

    <!-- Modal Terms -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="termsModalLabel">Ketentuan & Kebijakan Privasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Terakhir diperbarui: 30 Desember 2025</p>

                    <h6 class="fw-bold text-primary">1. Pendahuluan</h6>
                    <p class="small text-secondary">Selamat datang di KawalDiri. Dengan mengakses atau menggunakan aplikasi ini, Anda setuju untuk terikat dengan syarat dan ketentuan ini. Jika Anda tidak setuju, mohon untuk tidak menggunakan layanan ini.</p>

                    <h6 class="fw-bold text-primary">2. Data Pengguna</h6>
                    <p class="small text-secondary">Kami menghargai privasi Anda. Data yang Anda masukkan ke dalam aplikasi, termasuk data keuangan dan tugas, akan disimpan dengan aman dan tidak akan dikomersialkan kepada pihak ketiga tanpa persetujuan Anda.</p>

                    <h6 class="fw-bold text-primary">3. Penggunaan Layanan</h6>
                    <p class="small text-secondary">Anda setuju untuk menggunakan layanan ini hanya untuk tujuan yang sah dan tidak melanggar hukum. Segala bentuk penyalahgunaan sistem dapat mengakibatkan penghentian akun.</p>

                    <h6 class="fw-bold text-primary">4. Perubahan Ketentuan</h6>
                    <p class="small text-secondary">Kami berhak mengubah ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui aplikasi atau email yang terdaftar.</p>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>