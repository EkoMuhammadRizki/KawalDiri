@extends('layouts.guest')

@section('title', 'KawalDiri - Kelola Waktu & Keuangan Anda')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap');

    body {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Landing Page Specific Styles */
    .landing-page {
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Splash Screen */
    .splash-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-600), var(--primary-800));
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .splash-screen.hide {
        opacity: 0;
        visibility: hidden;
    }

    .splash-logo {
        color: white;
        font-size: 3rem;
        font-weight: 700;
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* Navbar */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        padding: var(--space-4) 0;
        background: transparent;
        z-index: 100;
        transition: all var(--transition-base);
    }

    .navbar.scrolled {
        background: var(--bg-primary);
        box-shadow: var(--shadow-md);
    }

    .navbar .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-logo {
        font-size: var(--text-xl);
        font-weight: 700;
        color: var(--primary-500);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .nav-logo i {
        width: 28px;
        height: 28px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: var(--space-4);
    }

    /* Hero Section */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding-top: var(--space-20);
        background: linear-gradient(180deg, var(--primary-50) 0%, var(--bg-primary) 100%);
    }

    [data-theme="dark"] .hero {
        background: linear-gradient(180deg, rgba(139, 92, 246, 0.1) 0%, var(--bg-primary) 100%);
    }

    .hero .container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-12);
        align-items: center;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        line-height: 1.1;
        margin-bottom: var(--space-6);
        background: linear-gradient(135deg, var(--primary-600), var(--primary-400));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-size: var(--text-lg);
        margin-bottom: var(--space-8);
        color: var(--text-secondary);
    }

    .hero-buttons {
        display: flex;
        gap: var(--space-4);
    }

    .hero-image {
        position: relative;
    }

    .hero-mockup {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-xl);
        animation: float 4s ease-in-out infinite;
    }

    .mockup-header {
        display: flex;
        gap: var(--space-2);
        margin-bottom: var(--space-4);
    }

    .mockup-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .mockup-dot.red {
        background-color: #ef4444;
    }

    .mockup-dot.yellow {
        background-color: #f59e0b;
    }

    .mockup-dot.green {
        background-color: #22c55e;
    }

    .mockup-content {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-3);
    }

    .mockup-widget {
        padding: var(--space-4);
        background: var(--bg-secondary);
        border-radius: var(--radius-md);
    }

    .mockup-widget-title {
        font-size: var(--text-xs);
        color: var(--text-muted);
        margin-bottom: var(--space-2);
    }

    .mockup-widget-value {
        font-size: var(--text-xl);
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Features Section */
    .features {
        padding: var(--space-20) 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: var(--space-12);
    }

    .section-header h2 {
        margin-bottom: var(--space-4);
    }

    .section-header p {
        max-width: 600px;
        margin: 0 auto;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-8);
    }

    .feature-card {
        text-align: center;
        padding: var(--space-8);
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        transition: all var(--transition-base);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-300);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto var(--space-6);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
        border-radius: var(--radius-lg);
        color: var(--primary-600);
    }

    [data-theme="dark"] .feature-icon {
        background: rgba(139, 92, 246, 0.2);
    }

    .feature-icon i {
        width: 32px;
        height: 32px;
    }

    .feature-card h3 {
        margin-bottom: var(--space-3);
    }

    /* How It Works Section */
    .how-it-works {
        padding: var(--space-20) 0;
        background: var(--bg-secondary);
    }

    .steps-container {
        display: flex;
        justify-content: center;
        gap: var(--space-4);
        flex-wrap: wrap;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: var(--space-6);
        max-width: 250px;
    }

    .step-number {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
        color: white;
        font-weight: 600;
        font-size: var(--text-lg);
        border-radius: 50%;
        margin-bottom: var(--space-4);
    }

    .step-arrow {
        color: var(--primary-400);
        align-self: center;
    }

    /* CTA Section */
    .cta {
        padding: var(--space-20) 0;
        text-align: center;
    }

    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .cta h2 {
        margin-bottom: var(--space-4);
    }

    .cta p {
        margin-bottom: var(--space-8);
    }

    /* Footer */
    .footer {
        padding: var(--space-8) 0;
        border-top: 1px solid var(--border-color);
        text-align: center;
    }

    .footer p {
        color: var(--text-muted);
        font-size: var(--text-sm);
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero .container {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-buttons {
            justify-content: center;
        }

        .hero-image {
            order: -1;
            max-width: 400px;
            margin: 0 auto;
        }

        .features-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }
    }

    @media (max-width: 640px) {
        .nav-links .btn-ghost {
            display: none;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .steps-container {
            flex-direction: column;
            align-items: center;
        }

        .step-arrow {
            transform: rotate(90deg);
        }
    }
</style>
@endpush

@section('content')
<!-- Splash Screen -->
<div class="splash-screen" id="splashScreen">
    <div class="splash-logo">
        <i data-lucide="shield-check"></i>
        KawalDiri
    </div>
</div>

<div class="landing-page">
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-logo">
                <i data-lucide="shield-check"></i>
                KawalDiri
            </a>
            <div class="nav-links">
                <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Daftar Gratis</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Kendalikan Waktu & Uang Anda dalam Satu Genggaman</h1>
                <p>KawalDiri membantu Anda mengatur tugas harian dan keuangan pribadi, sehingga Anda dapat melihat korelasi antara produktivitas dan pola pengeluaran.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i data-lucide="rocket"></i>
                        Mulai Sekarang
                    </a>
                    <a href="#features" class="btn btn-secondary btn-lg">
                        <i data-lucide="info"></i>
                        Pelajari Lebih
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-mockup">
                    <div class="mockup-header">
                        <span class="mockup-dot red"></span>
                        <span class="mockup-dot yellow"></span>
                        <span class="mockup-dot green"></span>
                    </div>
                    <div class="mockup-content">
                        <div class="mockup-widget">
                            <div class="mockup-widget-title">Tugas Hari Ini</div>
                            <div class="mockup-widget-value">5 Tasks</div>
                        </div>
                        <div class="mockup-widget">
                            <div class="mockup-widget-title">Pengeluaran</div>
                            <div class="mockup-widget-value">Rp 150K</div>
                        </div>
                        <div class="mockup-widget">
                            <div class="mockup-widget-title">Selesai</div>
                            <div class="mockup-widget-value text-success">3 ✓</div>
                        </div>
                        <div class="mockup-widget">
                            <div class="mockup-widget-title">Budget Sisa</div>
                            <div class="mockup-widget-value text-warning">65%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Fitur Unggulan</h2>
                <p>Semua yang Anda butuhkan untuk mengelola waktu dan keuangan dalam satu aplikasi yang terintegrasi.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="check-square"></i>
                    </div>
                    <h3>Smart Task Manager</h3>
                    <p>Atur tugas dengan kategori, prioritas, dan status. Dapatkan pengingat agar tidak ada yang terlewat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="wallet"></i>
                    </div>
                    <h3>Financial Tracker</h3>
                    <p>Catat pemasukan dan pengeluaran dengan mudah. Pantau budget Anda dan dapatkan insight keuangan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="line-chart"></i>
                    </div>
                    <h3>Correlation Analytics</h3>
                    <p>Lihat korelasi antara produktivitas dan pengeluaran Anda. Temukan pola yang berguna untuk pengambilan keputusan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2>Cara Kerja</h2>
                <p>Mulai dalam hitungan menit</p>
            </div>
            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Daftar Gratis</h4>
                    <p>Buat akun dalam 30 detik</p>
                </div>
                <div class="step-arrow">
                    <i data-lucide="arrow-right"></i>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Catat Aktivitas</h4>
                    <p>Input tugas & pengeluaran harian</p>
                </div>
                <div class="step-arrow">
                    <i data-lucide="arrow-right"></i>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Lihat Insight</h4>
                    <p>Analisis pola & tingkatkan produktivitas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Siap untuk Lebih Produktif?</h2>
                <p>Bergabung dengan ribuan pengguna yang telah mengendalikan waktu dan keuangan mereka dengan KawalDiri.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    <i data-lucide="user-plus"></i>
                    Daftar Sekarang - Gratis!
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} KawalDiri. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    // Splash Screen
    document.addEventListener('DOMContentLoaded', function() {
        const splash = document.getElementById('splashScreen');

        // Check if user has seen splash
        if (sessionStorage.getItem('splashShown')) {
            splash.classList.add('hide');
        } else {
            setTimeout(() => {
                splash.classList.add('hide');
                sessionStorage.setItem('splashShown', 'true');
            }, 1500);
        }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endpush