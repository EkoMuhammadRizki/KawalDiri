<style>
    /* Clean White Splash Screen (V5 - Creative Logo) */
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

    .logo-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .creative-logo {
        width: 280px;
        /* Diperbesar signifikan */
        height: auto;
        filter: drop-shadow(0 20px 40px rgba(99, 102, 241, 0.3));
        /* Shadow halus berwarna ungu/primary */
        opacity: 0;
        animation:
            logo-pop-in 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards,
            logo-float 4s ease-in-out infinite 1.2s;
        /* Float mulai setelah pop-in selesai */
    }

    @keyframes logo-pop-in {
        0% {
            opacity: 0;
            transform: scale(0.5) translateY(50px);
            filter: blur(20px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
            filter: blur(0);
        }
    }

    @keyframes logo-float {

        0%,
        100% {
            transform: translateY(0);
            filter: drop-shadow(0 20px 40px rgba(99, 102, 241, 0.3));
        }

        50% {
            transform: translateY(-15px);
            filter: drop-shadow(0 35px 50px rgba(99, 102, 241, 0.2));
        }
    }

    /* Ripple Effect Background (Optional, subtle) */
    .ripple-bg {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.03) 0%, transparent 70%);
        border-radius: 50%;
        animation: ripple-breath 4s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes ripple-breath {

        0%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.2);
            opacity: 1;
        }
    }
</style>

<!-- Immersive Splash Screen -->
<div id="splash-screen" class="modern-splash">
    <div class="logo-container">
        <div class="ripple-bg"></div>
        <img src="{{ asset('images/Logo.png') }}" alt="KawalDiri" class="creative-logo">
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