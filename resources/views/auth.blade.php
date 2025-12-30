<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KawalDiri - Autentikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --secondary-color: #f43f5e;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-light);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Blobs */
        .blob {
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
        .container-auth {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.05), 0 10px 10px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
            width: 1000px;
            max-width: 100%;
            min-height: 600px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: #fff;
            display: flex;
            align-items: flex-start;
            /* Changed from center to flex-start */
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            text-align: left;
            /* Changed from center to left */
        }

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

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container-auth.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
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

        /* Form Customization */
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
            font-weight: 500;
            margin-bottom: 0.5rem;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
            background-color: #fff;
        }

        .input-group-icon {
            position: relative;
            width: 100%;
            background-color: #f8fafc;
            /* Match input bg to hide partial borders if needed */
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-wrapper .material-symbols-outlined {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 5;
            font-size: 20px;
            pointer-events: none;
            /* Let clicks pass through to input */
        }

        .input-group-block {
            width: 100%;
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-label {
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

        .btn-auth {
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

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .btn-outline-white {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.8rem 2rem;
            font-weight: 700;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .btn-outline-white:hover {
            background: #fff;
            color: var(--primary-color);
        }

        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            /* Standard property */
        }

        /* Floating Icons for Overlay */
        .floating-icon-card {
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

        .icon-circle {
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

        .welcome-text h2 {
            line-height: 1.2;
        }

        @media (max-width: 768px) {
            .container-auth {
                min-height: 800px;
                width: 100%;
                margin: 20px;
            }

            .form-container {
                width: 100%;
                height: 50%;
                transition: none;
            }

            .overlay-container {
                display: none;
            }

            .sign-in-container,
            .sign-up-container {
                width: 100%;
                position: relative;
                height: auto;
                opacity: 1;
                z-index: 1;
                animation: none;
                padding: 40px;
            }

            .container-auth {
                height: auto;
                display: block;
                overflow: visible;
            }

            .sign-up-container {
                display: none;
            }

            .container-auth.right-panel-active .sign-up-container {
                display: block;
                transform: none;
            }

            .container-auth.right-panel-active .sign-in-container {
                display: none;
                transform: none;
            }

            .mobile-toggle {
                display: block;
                margin-top: 20px;
                color: var(--primary-color);
                font-weight: bold;
                cursor: pointer;
            }
        }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="blob bg-primary" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
    <div class="blob bg-danger" style="width: 300px; height: 300px; bottom: -50px; right: -50px;"></div>

    <div class="container-auth" id="container">

        <!-- LOGIN FORM -->
        <div class="form-container sign-in-container">
            <form action="{{ route('dashboard') }}">
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

                <div class="input-group-block">
                    <label class="input-label">Email</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined">alternate_email</span>
                        <input type="email" class="form-control" placeholder="nama@email.com" />
                    </div>
                </div>

                <div class="input-group-block">
                    <div class="d-flex justify-content-between">
                        <label class="input-label">Kata Sandi</label>
                        <a href="#" class="small text-decoration-none fw-bold text-primary">Lupa Sandi?</a>
                    </div>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined">lock</span>
                        <input type="password" class="form-control" placeholder="••••••••" />
                    </div>
                </div>

                <div class="d-flex justify-content-start w-100 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label small fw-medium" for="rememberMe">Ingat Saya</label>
                    </div>
                </div>

                <button class="btn-auth">Masuk Sekarang</button>

                <div class="mobile-toggle" id="mobileSignUp">Belum punya akun? Daftar dulu</div>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div class="form-container sign-up-container">
            <form action="{{ route('dashboard') }}">
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

                <div class="input-group-block">
                    <label class="input-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined">person</span>
                        <input type="text" class="form-control" placeholder="John Doe" />
                    </div>
                </div>

                <div class="input-group-block">
                    <label class="input-label">Email</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined">alternate_email</span>
                        <input type="email" class="form-control" placeholder="nama@email.com" />
                    </div>
                </div>

                <div class="input-group-block">
                    <label class="input-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <span class="material-symbols-outlined">lock</span>
                        <input type="password" class="form-control" placeholder="Buat kata sandi" />
                    </div>
                </div>

                <div class="text-start w-100 mb-3">
                    <p class="x-small text-muted mb-0" style="font-size: 0.75rem;">
                        Dengan mendaftar, Anda menyetujui <a href="#" class="fw-bold">Ketentuan</a> dan <a href="#" class="fw-bold">Kebijakan Privasi</a>.
                    </p>
                </div>

                <button class="btn-auth">Buat Akun Gratis</button>

                <div class="mobile-toggle" id="mobileSignIn">Sudah punya akun? Masuk</div>
            </form>
        </div>

        <!-- OVERLAY -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <div class="mb-4 text-white">
                        <span class="material-symbols-outlined" style="font-size: 54px;">waving_hand</span>
                    </div>
                    <h2 class="fw-bold display-6 mb-3">Sudah Punya Akun?</h2>
                    <p class="mb-4 text-white-50">Silakan masuk kembali untuk melanjutkan produktivitas Anda.</p>
                    <button class="btn-outline-white" id="signIn">Masuk Saja</button>
                </div>
                <div class="overlay-panel overlay-right">
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

                    <h2 class="fw-bold display-6 mb-3">Baru di KawalDiri?</h2>
                    <p class="mb-4 text-white-50">Mulai perjalanan Anda menuju kebebasan finansial dan hidup yang lebih teratur hari ini.</p>
                    <button class="btn-outline-white" id="signUp">Daftar Gratis</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const mobileSignUp = document.getElementById('mobileSignUp');
        const mobileSignIn = document.getElementById('mobileSignIn');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });

        // Mobile Fallback logic
        if (mobileSignUp) {
            mobileSignUp.addEventListener('click', () => {
                container.classList.add("right-panel-active");
            });
        }
        if (mobileSignIn) {
            mobileSignIn.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
            });
        }
    </script>
</body>

</html>