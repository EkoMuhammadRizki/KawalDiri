<style>
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #e2e8f0;
        border-top: 5px solid #6366f1;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-top: 20px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Loading Overlay -->
<div id="loading-overlay">
    <img src="{{ asset('images/Logo.png') }}" alt="KawalDiri" style="width: 80px; margin-bottom: 15px;">
    <div class="loading-spinner"></div>
    <p style="margin-top: 15px; font-weight: 600; color: #4b5563;">Sedang Memproses...</p>
</div>

<script>
    // Listen for form submissions on the current page
    document.addEventListener('submit', function(e) {
        // Find if the event target is a form needing the loader
        if (e.target.tagName === 'FORM' && (e.target.id === 'loginForm' || e.target.id === 'registerForm')) {
            document.getElementById('loading-overlay').style.display = 'flex';
        }
    });

    // Alternatively, if specific IDs are unreliable, you can target data attributes or specific selectors.
    // Preserving previous logic:
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'flex';
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'flex';
        });
    }
</script>