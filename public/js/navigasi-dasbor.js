/**
 * =================================================================
 * NAVIGASI-DASBOR.JS - Script Navigasi SPA Dashboard KawalDiri
 * =================================================================
 * 
 * File ini mengimplementasikan navigasi SPA (Single Page Application)
 * menggunakan library Swup.js untuk transisi halaman yang mulus.
 * 
 * Fitur utama:
 * - Navigasi tanpa refresh halaman penuh
 * - Transisi halaman yang smooth
 * - Re-inisialisasi script saat pindah halaman
 * - Update status aktif di sidebar
 * - Update ikon sidebar sesuai halaman aktif
 * 
 * Dependencies:
 * - Swup.js untuk navigasi SPA
 * - SwupScriptsPlugin untuk re-execute inline scripts
 * - SwupHeadPlugin untuk update head elements
 */

/**
 * Inisialisasi Swup untuk navigasi SPA
 * 
 * Konfigurasi:
 * - containers: elemen yang akan di-replace saat navigasi (#swup)
 * - plugins: plugin tambahan untuk scripts dan head management
 * - linkSelector: selector untuk link yang akan di-handle oleh Swup
 */
const swup = new Swup({
    containers: ["#swup"],
    plugins: [new SwupScriptsPlugin(), new SwupHeadPlugin()],
    linkSelector: 'a[href^="' + window.location.origin + '"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), .nav-link'
});

/**
 * Update sidebar icon based on current route
 */
function updateSidebarIcon() {
    const currentPath = window.location.pathname;
    const iconElement = document.querySelector('.sidebar .material-symbols-outlined');

    if (!iconElement) return;

    const iconMap = {
        '/dashboard': 'dashboard',
        '/tasks': 'check_circle',
        '/finance': 'payments',
        '/settings': 'settings',
        '/help': 'help'
    };

    let newIcon = 'spa'; // default
    for (const [path, icon] of Object.entries(iconMap)) {
        if (currentPath === path || currentPath.startsWith(path + '/')) {
            newIcon = icon;
            break;
        }
    }
    iconElement.textContent = newIcon;
}

/**
 * Re-initialize scripts after Swup page transition
 * Handles Bootstrap components and page-specific scripts
 */
function reinitScripts() {
    // Re-initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Update Sidebar Active State
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        const linkPath = new URL(href, window.location.origin).pathname;
        if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Update Sidebar Icon
    updateSidebarIcon();

    // Initialize Dashboard if on Dashboard page
    if (document.getElementById('productivityChart')) {
        if (window.initDashboard) window.initDashboard();
    }

    // Initialize Finance Tracker if on Finance page
    if (document.querySelector('.finance-table-card')) {
        if (window.initFinanceTracker) window.initFinanceTracker();
    }

    // Initialize Task Manager if on Tasks page
    if (document.getElementById('taskTableBody')) {
        if (window.initTaskManager) window.initTaskManager();
    }
}

// Hook into Swup content replace event
swup.hooks.on('content:replace', reinitScripts);

// Run on initial page load
document.addEventListener('DOMContentLoaded', () => {
    updateSidebarIcon();
});
