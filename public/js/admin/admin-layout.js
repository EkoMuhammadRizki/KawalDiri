/**
 * Admin Layout JavaScript
 * Script untuk fungsi-fungsi layout admin seperti logout dan navigasi
 */

/**
 * Konfirmasi logout admin
 * Menampilkan dialog konfirmasi sebelum logout dari panel admin
 */
function confirmLogout() {
    Swal.fire({
        title: 'Yakin Ingin Keluar?',
        text: 'Anda akan keluar dari panel admin.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4338CA',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}

/**
 * Konfirmasi kembali ke landing page
 * Menampilkan dialog konfirmasi sebelum redirect ke halaman utama
 */
function confirmGoToLanding() {
    Swal.fire({
        title: 'Kembali ke Landing Page?',
        text: 'Anda akan diarahkan ke halaman utama.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Ke Landing Page',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/';
        }
    });
}
