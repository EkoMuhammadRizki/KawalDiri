/**
 * User Management JavaScript
 * Script untuk manajemen user di admin panel
 */

/**
 * Konfirmasi hapus user
 * Menampilkan dialog konfirmasi sebelum menghapus user dari sistem
 * 
 * @param {string} userId - ID user yang akan dihapus
 * @param {string} userName - Nama user yang akan dihapus
 */
function confirmDelete(userId, userName) {
    Swal.fire({
        title: 'Hapus User?',
        text: `User "${userName}" akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + userId).submit();
        }
    });
}
