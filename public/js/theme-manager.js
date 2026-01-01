/**
 * Theme Manager - Mengelola tema (Light/Dark/System) dan warna aksen
 */

class ThemeManager {
    constructor() {
        this.currentTheme = 'system';
        this.currentAccent = '#6366f1';
        this.init();
    }

    init() {
        // PRIORITY 1: Load dari server (database user via data attributes)
        const body = document.body;
        const serverTheme = body.getAttribute('data-user-theme');
        const serverAccent = body.getAttribute('data-user-accent');

        // Set accent color dari server (ALWAYS trust server for logged-in users)
        if (serverAccent && serverAccent !== '') {
            this.currentAccent = serverAccent;
        } else {
            // Fallback: try CSS variable
            const rootStyle = getComputedStyle(document.documentElement);
            const cssAccent = rootStyle.getPropertyValue('--accent-color').trim();
            if (cssAccent && cssAccent !== '') {
                this.currentAccent = cssAccent;
            }
        }

        // Set theme dari server (ALWAYS trust server for logged-in users)
        if (serverTheme && (serverTheme === 'light' || serverTheme === 'dark' || serverTheme === 'system')) {
            this.currentTheme = serverTheme;
            // Sync to localStorage untuk consistency
            localStorage.setItem('theme_preference', serverTheme);
        } else {
            // PRIORITY 2: Fallback ke localStorage (untuk guest atau error)
            const savedTheme = localStorage.getItem('theme_preference');
            if (savedTheme && (savedTheme === 'light' || savedTheme === 'dark' || savedTheme === 'system')) {
                this.currentTheme = savedTheme;
            }
            // else: keep default 'system'
        }

        // Apply IMMEDIATELY
        this.applyTheme();
        this.applyAccentColor();

        // Listen untuk system theme changes
        this.setupSystemThemeListener();

        console.log('✓ Theme Manager initialized from SERVER:', {
            theme: this.currentTheme,
            accent: this.currentAccent,
            source: serverTheme ? 'database' : 'localStorage/default'
        });
    }

    setupSystemThemeListener() {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', () => {
            if (this.currentTheme === 'system') {
                this.applyTheme();
            }
        });
    }

    /**
     * Save preferences ke localStorage dan server
     */
    async savePreferences(theme, accent) {
        if (theme) this.currentTheme = theme;
        if (accent) this.currentAccent = accent;

        localStorage.setItem('theme_preference', this.currentTheme);
        if (accent) localStorage.setItem('accent_color', this.currentAccent);

        // Save ke server via AJAX
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            const response = await fetch('/settings/preferences', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content
                },
                body: JSON.stringify({
                    theme_preference: this.currentTheme,
                    accent_color: this.currentAccent
                })
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error saving preferences:', error);
        }
    }

    /**
     * Apply tema ke halaman
     */
    applyTheme() {
        const html = document.documentElement;
        let effectiveTheme = this.currentTheme;

        // Jika system, gunakan light mode sebagai default (bukan detect OS)
        if (effectiveTheme === 'system') {
            effectiveTheme = 'light'; // Always default to light for system mode
        }

        // Set attribute data-theme
        html.setAttribute('data-theme', effectiveTheme);

        // Update body class
        if (effectiveTheme === 'dark') {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
        }
    }

    /**
     * Apply accent color ke CSS variables
     */
    applyAccentColor() {
        const root = document.documentElement;

        // Force set accent color (even if it's the same, to ensure it's applied)
        root.style.setProperty('--accent-color', this.currentAccent);

        // Variations untuk hover, active states
        const rgb = this.hexToRgb(this.currentAccent);
        if (rgb) {
            root.style.setProperty('--accent-color-rgb', `${rgb.r}, ${rgb.g}, ${rgb.b}`);
            root.style.setProperty('--accent-color-hover', this.adjustBrightness(this.currentAccent, -10));
            root.style.setProperty('--accent-color-light', this.adjustBrightness(this.currentAccent, 30));
        } else {
            // Fallback jika hex parsing gagal
            console.warn('Failed to parse hex color:', this.currentAccent);
            root.style.setProperty('--accent-color-rgb', '99, 102, 241'); // Default indigo
        }
    }

    /**
     * Set tema (light, dark, system)
     */
    async setTheme(theme) {
        await this.savePreferences(theme, null);
        this.applyTheme();
        return true;
    }

    /**
     * Set accent color
     */
    async setAccentColor(color) {
        await this.savePreferences(null, color);
        this.applyAccentColor();
        return true;
    }

    /**
     * Helper: Convert hex to RGB
     */
    hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    /**
     * Helper: Adjust brightness
     */
    adjustBrightness(hex, percent) {
        const rgb = this.hexToRgb(hex);
        if (!rgb) return hex;

        const adjust = (value) => {
            const adjusted = Math.max(0, Math.min(255, value + (value * percent / 100)));
            return Math.round(adjusted);
        };

        const r = adjust(rgb.r).toString(16).padStart(2, '0');
        const g = adjust(rgb.g).toString(16).padStart(2, '0');
        const b = adjust(rgb.b).toString(16).padStart(2, '0');

        return `#${r}${g}${b}`;
    }
}

// Initialize theme manager when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.themeManager = new ThemeManager();
    });
} else {
    window.themeManager = new ThemeManager();
}
