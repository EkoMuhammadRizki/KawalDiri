@extends('layouts.guest')

@section('title', 'Daftar - KawalDiri')

@push('styles')
<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-6);
        background: linear-gradient(135deg, var(--primary-50) 0%, var(--bg-primary) 100%);
    }

    [data-theme="dark"] .auth-page {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, var(--bg-primary) 100%);
    }

    .auth-container {
        width: 100%;
        max-width: 420px;
    }

    .auth-card {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        padding: var(--space-8);
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-color);
    }

    .auth-header {
        text-align: center;
        margin-bottom: var(--space-6);
    }

    .auth-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        font-size: var(--text-2xl);
        font-weight: 700;
        color: var(--primary-500);
        margin-bottom: var(--space-4);
    }

    .auth-logo i {
        width: 32px;
        height: 32px;
    }

    .auth-title {
        font-size: var(--text-xl);
        color: var(--text-primary);
        margin-bottom: var(--space-2);
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: var(--text-sm);
    }

    .auth-form {
        margin-bottom: var(--space-6);
    }

    .form-group {
        margin-bottom: var(--space-4);
    }

    .form-label {
        display: block;
        font-size: var(--text-sm);
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: var(--space-2);
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: var(--space-4);
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .input-icon i {
        width: 18px;
        height: 18px;
    }

    .form-input-icon {
        padding-left: calc(var(--space-4) + 18px + var(--space-3));
    }

    .password-toggle {
        position: absolute;
        right: var(--space-4);
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: var(--space-1);
    }

    .password-toggle:hover {
        color: var(--text-primary);
    }

    .password-strength {
        margin-top: var(--space-2);
    }

    .strength-bar {
        height: 4px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-full);
        overflow: hidden;
        margin-bottom: var(--space-1);
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all var(--transition-base);
    }

    .strength-fill.weak {
        width: 25%;
        background: var(--danger-500);
    }

    .strength-fill.fair {
        width: 50%;
        background: var(--warning-500);
    }

    .strength-fill.good {
        width: 75%;
        background: var(--info-500);
    }

    .strength-fill.strong {
        width: 100%;
        background: var(--success-500);
    }

    .strength-text {
        font-size: var(--text-xs);
        color: var(--text-muted);
    }

    .input-hint {
        font-size: var(--text-xs);
        color: var(--text-muted);
        margin-top: var(--space-1);
    }

    .btn-auth {
        width: 100%;
        padding: var(--space-4);
        font-size: var(--text-base);
        margin-top: var(--space-4);
    }

    .auth-footer {
        text-align: center;
        padding-top: var(--space-6);
        border-top: 1px solid var(--border-color);
    }

    .auth-footer p {
        font-size: var(--text-sm);
        color: var(--text-secondary);
        margin: 0;
    }

    .auth-footer a {
        color: var(--primary-500);
        font-weight: 500;
    }

    .back-home {
        position: absolute;
        top: var(--space-6);
        left: var(--space-6);
        display: flex;
        align-items: center;
        gap: var(--space-2);
        color: var(--text-secondary);
        font-size: var(--text-sm);
    }

    .back-home:hover {
        color: var(--primary-500);
    }

    .back-home i {
        width: 16px;
        height: 16px;
    }
</style>
@endpush

@section('content')
<a href="/" class="back-home">
    <i data-lucide="arrow-left"></i>
    Kembali ke Beranda
</a>

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i data-lucide="shield-check"></i>
                    KawalDiri
                </div>
                <h1 class="auth-title">Buat Akun Baru</h1>
                <p class="auth-subtitle">Daftar untuk mulai mengelola waktu & keuangan</p>
            </div>

            <form class="auth-form" method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i data-lucide="user"></i>
                        </span>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input form-input-icon"
                            placeholder="John Doe"
                            required
                            autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i data-lucide="at-sign"></i>
                        </span>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-input form-input-icon"
                            placeholder="johndoe"
                            pattern="[a-zA-Z0-9]+"
                            required>
                    </div>
                    <p class="input-hint">Hanya huruf dan angka, tanpa spasi</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i data-lucide="mail"></i>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input form-input-icon"
                            placeholder="contoh@email.com"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i data-lucide="lock"></i>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input form-input-icon"
                            placeholder="••••••••"
                            required
                            minlength="8"
                            oninput="checkPasswordStrength(this.value)">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i data-lucide="eye" id="passwordIcon"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText">Minimal 8 karakter</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i data-lucide="lock"></i>
                        </span>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input form-input-icon"
                            placeholder="••••••••"
                            required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i data-lucide="eye" id="password_confirmationIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-auth">
                    <i data-lucide="user-plus"></i>
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + 'Icon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Password strength checker
    function checkPasswordStrength(password) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');

        let strength = 0;

        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        fill.className = 'strength-fill';

        switch (strength) {
            case 0:
            case 1:
                fill.classList.add('weak');
                text.textContent = 'Lemah - Tambahkan karakter lagi';
                break;
            case 2:
                fill.classList.add('fair');
                text.textContent = 'Cukup - Tambahkan variasi karakter';
                break;
            case 3:
                fill.classList.add('good');
                text.textContent = 'Baik - Tambahkan simbol untuk lebih kuat';
                break;
            case 4:
                fill.classList.add('strong');
                text.textContent = 'Kuat - Password sangat aman!';
                break;
        }
    }

    // Username validation (alphanumeric only)
    document.getElementById('username').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
    });

    // Form submission with SweetAlert
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;

        if (password !== confirm) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok',
                text: 'Pastikan konfirmasi password sama dengan password',
            });
            return;
        }

        // Simulate registration (replace with actual form submission)
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: 'Akun Anda telah dibuat. Mengalihkan ke halaman login...',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/login';
        });
    });
</script>
@endpush