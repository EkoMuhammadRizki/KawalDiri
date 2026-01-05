<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - KawalDiri</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo Favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .card-custom {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        .btn-primary-custom {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .form-control-custom {
            background-color: #F3F4F6;
            border: 1px solid transparent;
            padding: 12px;
            border-radius: 10px;
        }

        .form-control-custom:focus {
            background-color: white;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
    </style>
</head>

<body>
    <div class="card-custom text-center">
        <div class="mb-4 text-primary">
            <span class="material-symbols-rounded" style="font-size: 64px;">lock_open</span>
        </div>
        <h2 class="fw-bold mb-2">Reset Kata Sandi</h2>
        <p class="text-muted mb-4 small">Silakan buat kata sandi baru untuk akun Anda.</p>

        @if ($errors->any())
        <div class="alert alert-danger border-0 bg-danger-subtle text-danger small mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3 text-start">
                <label class="form-label fw-bold small text-muted">ALAMAT EMAIL</label>
                <input type="email" class="form-control form-control-custom" name="email" value="{{ $email ?? old('email') }}" required readonly>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold small text-muted">KATA SANDI BARU</label>
                <input type="password" class="form-control form-control-custom" name="password" required autofocus placeholder="Minimal 8 karakter">
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold small text-muted">KONFIRMASI KATA SANDI</label>
                <input type="password" class="form-control form-control-custom" name="password_confirmation" required placeholder="Ulangi kata sandi baru">
            </div>

            <button type="submit" class="btn btn-primary-custom">
                Ubah Kata Sandi
            </button>
        </form>
    </div>
</body>

</html>