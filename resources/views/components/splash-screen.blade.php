<style>
    /* Clean White Splash Screen (V4) */
    .modern-splash {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 0.8s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .splash-card {
        background: #ffffff;
        border-radius: 40px;
        padding: 50px;
        /* Subtle neumorphic/soft shadow for depth on white */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
        animation: card-entry 1s ease-out forwards;
        transform: translateY(20px);
        opacity: 0;
    }

    @keyframes card-entry {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .shimmer-effect {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        /* Subtle shimmer suitable for white */
        background: linear-gradient(to right, transparent, rgba(200, 200, 255, 0.1), transparent);
        transform: skewX(-25deg);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% {
            left: -100%;
        }

        100% {
            left: 200%;
        }
    }

    .logo-wrapper {
        position: relative;
        z-index: 2;
        margin-bottom: 30px;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.05));
    }

    .floating-logo {
        width: 160px;
        height: auto;
        animation: float-logo 4s ease-in-out infinite;
    }

    @keyframes float-logo {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .loading-pulse {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        /* Adjusted for white background: primary border with light gray track */
        border: 4px solid #f3f4f6;
        border-top-color: #6366f1;
        /* Brand Primary Color */
        animation: spin-loader 1s linear infinite;
    }

    @keyframes spin-loader {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Immersive Splash Screen -->
<div id="splash-screen" class="modern-splash">
    <div class="splash-card">
        <div class="shimmer-effect"></div>
        <div class="logo-wrapper">
            <img src="{{ asset('images/Logo.png') }}" alt="KawalDiri" class="floating-logo">
        </div>
        <div class="loading-pulse"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const splash = document.getElementById('splash-screen');
        setTimeout(() => {
            splash.style.opacity = '0';
            setTimeout(() => {
                splash.style.display = 'none';
            }, 800);
        }, 2200); // Display for 2.2 seconds
    });
</script>