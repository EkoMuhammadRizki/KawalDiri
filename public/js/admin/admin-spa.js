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
     * Show loading bar di bagian atas halaman
     */
    function showLoadingState() {
        // Create loading bar if not exists
        let loadingBar = document.getElementById('admin-loading-bar');

        if (!loadingBar) {
            loadingBar = document.createElement('div');
            loadingBar.id = 'admin-loading-bar';
            loadingBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 280px;
                width: 0;
                height: 3px;
                background: linear-gradient(90deg, #4338CA, #6366F1, #818CF8);
                z-index: 9999;
                transition: width 0.3s ease-out;
                box-shadow: 0 0 10px rgba(67, 56, 202, 0.7);
            `;

            document.body.appendChild(loadingBar);
        }

        // Animate loading bar
        loadingBar.style.width = '0';

        // First phase: quick progress to 30%
        setTimeout(() => {
            loadingBar.style.width = '30%';
        }, 10);

        // Second phase: slower progress to 70%
        setTimeout(() => {
            loadingBar.style.width = '70%';
        }, 200);

        // Third phase: slow progress to 90% (waits for response)
        setTimeout(() => {
            loadingBar.style.width = '90%';
            loadingBar.style.transition = 'width 2s ease-out';
        }, 500);
    }

    /**
     * Hide loading bar dengan animasi complete
     */
    function hideLoadingState() {
        const loadingBar = document.getElementById('admin-loading-bar');

        if (loadingBar) {
            // Complete the progress bar
            loadingBar.style.transition = 'width 0.2s ease-out';
            loadingBar.style.width = '100%';

            // Fade out and remove
            setTimeout(() => {
                loadingBar.style.transition = 'opacity 0.3s ease-out';
                loadingBar.style.opacity = '0';

                setTimeout(() => {
                    loadingBar.remove();
                }, 300);
            }, 200);
        }
    }
});
