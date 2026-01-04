/**
 * Admin SPA Navigation
 * Implementasi Single Page Application style navigation untuk admin panel
 * Menghindari page reload saat berpindah antar tab di sidebar
 */

document.addEventListener('DOMContentLoaded', function () {
    const adminContent = document.querySelector('.admin-main');
    const navLinks = document.querySelectorAll('.nav-link:not([data-no-swup])');

    // Intercept klik pada navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const url = this.getAttribute('href');

            // Update active state di sidebar
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            // Load content via AJAX
            loadPage(url);

            // Update browser URL tanpa reload
            history.pushState({ url: url }, '', url);
        });
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function (e) {
        if (e.state && e.state.url) {
            loadPage(e.state.url);
        }
    });

    /**
     * Load halaman via AJAX
     * @param {string} url - URL halaman yang akan di-load
     */
    function loadPage(url) {
        // Show loading state
        showLoadingState();

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
            .then(response => response.text())
            .then(html => {
                // Parse HTML response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract new content
                const newContent = doc.querySelector('.admin-main');
                const newTitle = doc.querySelector('title');

                if (newContent) {
                    // Replace content
                    adminContent.innerHTML = newContent.innerHTML;

                    // Update page title
                    if (newTitle) {
                        document.title = newTitle.textContent;
                    }

                    // Re-execute scripts in new content
                    executeScripts(newContent);

                    // Scroll to top
                    window.scrollTo(0, 0);
                }

                hideLoadingState();
            })
            .catch(error => {
                console.error('Error loading page:', error);
                hideLoadingState();

                // Fallback to normal navigation on error
                window.location.href = url;
            });
    }

    /**
     * Execute scripts yang ada dalam content baru
     * @param {Element} container - Container yang berisi scripts
     */
    function executeScripts(container) {
        const scripts = container.querySelectorAll('script');
        scripts.forEach(script => {
            const newScript = document.createElement('script');

            if (script.src) {
                newScript.src = script.src;
            } else {
                newScript.textContent = script.textContent;
            }

            document.head.appendChild(newScript);
            document.head.removeChild(newScript);
        });
    }

    /**
     * Show loading overlay
     */
    function showLoadingState() {
        // Create loading overlay if not exists
        let overlay = document.getElementById('admin-loading-overlay');

        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'admin-loading-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.3s;
            `;

            overlay.innerHTML = `
                <div style="text-align: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading...</p>
                </div>
            `;

            document.body.appendChild(overlay);
        }

        // Show overlay with fade in
        setTimeout(() => {
            overlay.style.opacity = '1';
        }, 10);
    }

    /**
     * Hide loading overlay
     */
    function hideLoadingState() {
        const overlay = document.getElementById('admin-loading-overlay');

        if (overlay) {
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.remove();
            }, 300);
        }
    }
});
