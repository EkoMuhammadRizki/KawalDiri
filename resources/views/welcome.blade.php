<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KawalDiri</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo Favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
</head>

<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: var(--bg-primary); color: var(--text-primary); font-family: var(--font-sans);">
    <div style="text-align: center;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">KawalDiri</h1>
        <p style="margin-bottom: 2rem;">Aplikasi manajemen produktivitas dan keuangan.</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px; background: var(--primary-500); color: white;">Ke Halaman Utama</a>
    </div>
</body>

</html>