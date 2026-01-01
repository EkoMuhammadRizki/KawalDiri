/**
 * Settings Page JavaScript Handlers
 * Manages profile updates, password changes, theme switching, and notifications
 */

// Toast configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

/**
 * Profile Update Handler
 */
async function saveProfile() {
    const form = document.getElementById('profileForm');
    if (!form) return;

    const formData = new FormData(form);

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch(form.dataset.action || '/settings/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
            });
            location.reload();
        } else {
            throw new Error(data.message || 'Gagal menyimpan profil');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.message || 'Terjadi kesalahan saat menyimpan!',
            confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
        });
    }
}

/**
 * Password Update Handler
 */
async function savePassword() {
    const form = document.getElementById('passwordForm');
    if (!form) return;

    const formData = new FormData(form);

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch(form.dataset.action || '/settings/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
            });
            form.reset();
        } else {
            throw new Error(data.message || 'Gagal mengubah password');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.message || 'Password lama salah atau password baru tidak valid!',
            confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
        });
    }
}

/**
 * Theme Change Handler
 */
async function changeTheme(theme) {
    if (!window.themeManager) {
        console.error('Theme Manager not loaded');
        return;
    }

    await window.themeManager.setTheme(theme);

    const themeNames = {
        'light': 'Terang',
        'dark': 'Gelap',
        'system': 'Sistem'
    };

    Toast.fire({
        icon: 'success',
        title: `Tema diubah ke ${themeNames[theme] || theme}`
    });
}

/**
 * Accent Color Change Handler
 */
async function changeAccentColor(color) {
    if (!window.themeManager) {
        console.error('Theme Manager not loaded');
        return;
    }

    await window.themeManager.setAccentColor(color);

    // Update active state untuk semua color options
    document.querySelectorAll('.accent-color-option').forEach(el => {
        el.classList.remove('active');
    });

    // Tambah active class ke warna yang diklik
    const colorMap = {
        '#6366f1': 0,
        '#10b981': 1,
        '#7c3aed': 2,
        '#f43f5e': 3
    };

    const options = document.querySelectorAll('.accent-color-option');
    const index = colorMap[color];
    if (options[index]) {
        options[index].classList.add('active');
    }

    Toast.fire({
        icon: 'success',
        title: 'Warna aksen diubah!'
    });
}

/**
 * Notifications Update Handler
 */
async function saveNotifications() {
    const emailNotif = document.getElementById('emailNotif');
    const weeklyReport = document.getElementById('weeklyReport');

    if (!emailNotif || !weeklyReport) return;

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch('/settings/notifications', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
            },
            body: JSON.stringify({
                email_notifications: emailNotif.checked,
                weekly_reports: weeklyReport.checked
            })
        });

        const data = await response.json();

        if (data.success) {
            Toast.fire({
                icon: 'success',
                title: 'Pengaturan notifikasi diperbarui!'
            });
        }
    } catch (error) {
        console.error('Error saving notifications:', error);
        Toast.fire({
            icon: 'error',
            title: 'Gagal menyimpan pengaturan!'
        });
    }
}

/**
 * Reset Settings Handler
 */
async function resetSettings() {
    const result = await Swal.fire({
        title: 'Reset Pengaturan?',
        text: 'Semua preferensi akan dikembalikan ke default',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const response = await fetch('/settings/reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
                }
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
                });
                location.reload();
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal reset!',
                confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim() || '#6366f1'
            });
        }
    }
}

/**
 * Logout Confirmation Handler
 */
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Keluar',
        text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('logout-form');
            if (form) {
                form.submit();
            }
        }
    });
}
