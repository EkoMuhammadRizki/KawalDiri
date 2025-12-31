<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - KawalDiri</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

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
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .admin-login-card {
            background: #ffffff;
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .card-top-border {
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--emerald-acc));
            width: 100%;
        }

        .info-panel h1 {
            font-weight: 800;
            letter-spacing: -1px;
        }

        /* Custom Input Styling */
        .input-group-custom {
            position: relative;
        }

        .input-group-custom .material-icons-round {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 10;
            font-size: 20px;
        }

        .form-control {
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border-radius: 0.75rem;
            border: 1px solid #E5E7EB;
            background-color: #F9FAFB;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 56, 202, 0.1);
            background-color: #fff;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-admin {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(67, 56, 202, 0.3);
            color: white;
        }

        /* Dashboard Mockup Visualization */
        .mockup-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #E5E7EB;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .progress-mini {
            height: 8px;
            border-radius: 10px;
            background-color: #F3F4F6;
        }

        .bg-indigo-light {
            background-color: rgba(67, 56, 202, 0.1);
            color: var(--primary-color);
        }

        .bg-emerald-light {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--emerald-acc);
        }

        @media (max-width: 768px) {
            .info-panel {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row align-items-center justify-content-center g-5">

            <!-- Info Panel (Hidden on Mobile) -->
            <div class="col-lg-6 info-panel">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-primary rounded-3 p-2 d-flex align-items-center justify-content-center text-white shadow-lg">
                        <span class="material-icons-round fs-2">security</span>
                    </div>
                    <h1 class="h2 mb-0 text-dark">KawalDiri</h1>
                </div>

                <h2 class="display-6 fw-bold mb-3">Portal Administrasi <br><span class="text-primary">Manajemen Terpusat</span></h2>
                <p class="text-muted fs-5 mb-5">Akses dashboard admin untuk mengelola pengguna, memantau aktivitas, dan menjaga keamanan platform KawalDiri.</p>

                <div class="mockup-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div style="width: 100px; height: 10px; background: #E5E7EB; border-radius: 5px; margin-bottom: 8px;"></div>
                            <div style="width: 60px; height: 10px; background: #F3F4F6; border-radius: 5px;"></div>
                        </div>
                        <div class="bg-emerald-light p-2 rounded-circle">
                            <span class="material-icons-round fs-6">trending_up</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle bg-light" style="width: 32px; height: 32px;"></div>
                            <div class="flex-grow-1">
                                <div class="progress progress-mini">
                                    <div class="progress-bar" style="width: 75%; background-color: var(--primary-color);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light" style="width: 32px; height: 32px;"></div>
                            <div class="flex-grow-1">
                                <div class="progress progress-mini">
                                    <div class="progress-bar" style="width: 50%; background-color: var(--emerald-acc);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login Card -->
            <div class="col-md-8 col-lg-5">
                <div class="admin-login-card">
                    <div class="card-top-border"></div>
                    <div class="p-4 p-md-5">

                        <!-- Mobile Logo -->
                        <div class="d-md-none text-center mb-4">
                            <div class="d-inline-flex align-items-center gap-2">
                                <div class="bg-primary text-white p-2 rounded-3">
                                    <span class="material-icons-round">security</span>
                                </div>
                                <span class="h4 fw-bold mb-0">KawalDiri</span>
                            </div>
                        </div>

                        <!-- Header -->
                        <div class="text-center mb-5">
                            <div class="bg-indigo-light d-inline-flex p-3 rounded-circle mb-3">
                                <span class="material-icons-round fs-2">admin_panel_settings</span>
                            </div>
                            <h3 class="fw-bold">Login Admin</h3>
                            <p class="text-muted small">Silakan masuk untuk mengelola aplikasi.</p>
                        </div>

                        <!-- Alert untuk error umum -->
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <!-- Form Login -->
                        <form method="POST" action="{{ route('admin.login.post') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Nama Pengguna atau Email</label>
                                <div class="input-group-custom">
                                    <span class="material-icons-round">person_outline</span>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="admin@kawaldiri.id"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Kata Sandi</label>
                                <div class="input-group-custom">
                                    <span class="material-icons-round">lock_outline</span>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="••••••••"
                                        required>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="small fw-bold text-primary text-decoration-none">Lupa kata sandi?</a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-admin w-100 d-flex align-items-center justify-content-center gap-2 mb-4">
                                <span class="material-icons-round fs-5">login</span>
                                Masuk sebagai Admin
                            </button>
                        </form>

                        <!-- Footer -->
                        <div class="text-center border-top pt-4">
                            <p class="x-small text-muted mb-0" style="font-size: 11px;">
                                Sistem Informasi Keamanan Terpadu © {{ date('Y') }} KawalDiri.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Link ke User Login -->
                <div class="text-center mt-4">
                    <p class="small text-muted">
                        Bukan Admin? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login Pengguna di sini</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>