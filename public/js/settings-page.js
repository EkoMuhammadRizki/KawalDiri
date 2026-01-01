/**
 * Settings Page JavaScript
 * All functions for settings page (theme, accent, avatar, profile, password)
 */

// Toast notification - Initialize first (only if not already exists)
if (!window.Toast) {
    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}

// Use window.Toast in this file
const Toast = window.Toast;

// Get CSRF token
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

// ==========================================
// THEME & ACCENT COLOR FUNCTIONS
// ==========================================

/**
 * Change theme (light/dark/system)
 */
window.changeTheme = async function (theme) {
    console.log('changeTheme called:', theme);

    if (!window.themeManager) {
        console.error('Theme Manager not loaded!');
        return;
    }

    await window.themeManager.setTheme(theme);

    // Update radio button checked state
    document.querySelectorAll('.theme-radio').forEach(radio => {
        radio.checked = (radio.value === theme);
    });

    Toast.fire({
        icon: 'success',
        title: `Tema diubah ke ${theme === 'light' ? 'Terang' : theme === 'dark' ? 'Gelap' : 'Sistem'}`
    });
};

/**
 * Change accent color
 */
window.changeAccentColor = async function (color) {
    console.log('changeAccentColor called:', color);

    if (!window.themeManager) {
        console.error('Theme Manager not loaded!');
        return;
    }

    await window.themeManager.setAccentColor(color);

    // Update active state
    document.querySelectorAll('.accent-color-option').forEach(el => {
        el.classList.remove('active');
    });

    // Find and activate clicked color
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
};

// ==========================================
// AVATAR FUNCTIONS
// ==========================================

let selectedAvatarId = 1;
let selectedAvatarColor = '';

/**
 * Select avatar from modal
 */
window.selectAvatar = function (id, color) {
    console.log('selectAvatar called:', id, color);

    selectedAvatarId = id;
    selectedAvatarColor = color;

    // Remove active from all
    document.querySelectorAll('.avatar-option').forEach(el => {
        el.classList.remove('active');
    });

    // Add active to selected
    const selectedOption = document.querySelector(`.avatar-option[data-avatar-id="${id}"]`);
    if (selectedOption) {
        selectedOption.classList.add('active');
        console.log('Avatar selected successfully');
    } else {
        console.error('Avatar option not found for id:', id);
    }
};

/**
 * Save avatar choice
 */
window.saveAvatar = async function () {
    console.log('saveAvatar called, ID:', selectedAvatarId, 'Color:', selectedAvatarColor);

    if (!selectedAvatarColor) {
        Toast.fire({
            icon: 'warning',
            title: 'Silakan pilih avatar terlebih dahulu'
        });
        return;
    }

    try {
        const response = await fetch('/settings/avatar', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ avatar: selectedAvatarId })
        });

        const data = await response.json();
        console.log('Server response:', data);

        if (data.success) {
            const userName = currentAvatar.getAttribute('data-username');

            // Update settings page avatar
            const newUrl = `https://ui-avatars.com/api/?name=${userName}&background=${selectedAvatarColor}&color=fff&size=128`;
            currentAvatar.src = newUrl;

            // Update sidebar profile avatar (bottom of sidebar - PENTING!)
            const sidebarProfileAvatar = document.getElementById('sidebarProfileAvatar');
            if (sidebarProfileAvatar) {
                const sidebarUrl = `https://ui-avatars.com/api/?name=${userName}&background=${selectedAvatarColor}&color=fff`;
                sidebarProfileAvatar.src = sidebarUrl;
                console.log('✓ Sidebar profile avatar updated');
            }

            // Close modal
            const modalEl = document.getElementById('avatarModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }

            Toast.fire({
                icon: 'success',
                title: 'Avatar berhasil diperbarui!'
            });
        }
    } catch (error) {
        console.error('Error saving avatar:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal menyimpan avatar',
            text: error.message
        });
    }
};

// ==========================================
// PROFILE & PASSWORD FUNCTIONS
// ==========================================

/**
 * Save profile changes
 */
window.saveProfile = async function () {
    console.log('saveProfile called');

    const form = document.getElementById('profileForm');
    if (!form) {
        console.error('Profile form not found');
        return;
    }

    const formData = new FormData(form);

    try {
        const response = await fetch('/settings/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message
            });
            location.reload();
        }
    } catch (error) {
        console.error('Error saving profile:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menyimpan!'
        });
    }
};

/**
 * Save password
 */
window.savePassword = async function () {
    console.log('savePassword called');

    const form = document.getElementById('passwordForm');
    if (!form) {
        console.error('Password form not found');
        return;
    }

    const formData = new FormData(form);

    try {
        const response = await fetch('/settings/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message
            });
            form.reset();
        } else {
            throw new Error(data.message || 'Gagal mengubah password');
        }
    } catch (error) {
        console.error('Error saving password:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.message || 'Password lama salah atau password baru tidak valid!'
        });
    }
};

/**
 * Reset all settings to default
 */
window.resetSettings = async function () {
    console.log('resetSettings called');

    const result = await Swal.fire({
        title: 'Reset Pengaturan?',
        text: 'Semua preferensi akan dikembalikan ke default',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch('/settings/reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message
                });
                location.reload();
            }
        } catch (error) {
            console.error('Error resetting settings:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal reset!'
            });
        }
    }
};

/**
 * Save notifications
 */
window.saveNotifications = async function () {
    console.log('saveNotifications called');

    const announcementNotif = document.getElementById('announcementNotif');

    if (!announcementNotif) {
        console.error('Notification checkbox not found');
        return;
    }

    try {
        const response = await fetch('/settings/notifications', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                email_notifications: announcementNotif.checked
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
    }
};

/**
 * Confirm logout
 */
window.confirmLogout = function () {
    console.log('confirmLogout called');

    Swal.fire({
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin mengakhiri sesi ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('logout-form-settings');
            if (form) {
                form.submit();
            } else {
                // Fallback to sidebar logout form
                const sidebarForm = document.getElementById('logout-form');
                if (sidebarForm) sidebarForm.submit();
            }
        }
    });
};

/**
 * Toggle password visibility
 */
window.togglePasswordVisibility = function (inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('.material-symbols-outlined');

    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    console.log('✓ Settings page JavaScript loaded');

    // Set initial selected avatar from current user
    const currentAvatarEl = document.querySelector('.avatar-option.active');
    if (currentAvatarEl) {
        const avatarId = currentAvatarEl.getAttribute('data-avatar-id');
        const avatarColor = currentAvatarEl.querySelector('img').src.match(/background=([a-f0-9]+)/i);
        if (avatarId && avatarColor) {
            selectedAvatarId = parseInt(avatarId);
            selectedAvatarColor = avatarColor[1];
            console.log('Initial avatar:', selectedAvatarId, selectedAvatarColor);
        }
    }
});
