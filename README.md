# KawalDiri - All In One Dashboard

**KawalDiri** adalah aplikasi manajemen produktivitas dan keuangan pribadi all-in-one yang dirancang untuk membantu pengguna mengelola aktivitas harian mereka dengan efisien. Dengan antarmuka yang modern, bersih, dan intuitif, KawalDiri memudahkan Anda untuk tetap terorganisir dan fokus pada tujuan Anda.

![Dashboard Preview](resources/img/dashboard-preview.png)

## 🌟 Fitur Utama

Aplikasi ini menawarkan berbagai fitur terintegrasi untuk mendukung gaya hidup produktif:

### 1. 📊 Dasbor Terpadu (Dashboard)
Pusat kontrol utama yang memberikan ringkasan visual tentang hari Anda:
*   **Ringkasan Cepat:** Lihat jumlah tugas selesai, pengeluaran hari ini, dan agenda berikutnya dalam satu pandangan.
*   **Visualisasi Data:** Grafik tren produktivitas dan pengeluaran mingguan.
*   **Aktivitas Terbaru:** Log aktivitas real-time untuk memantau apa yang baru saja terjadi.
*   **Navigasi Cepat:** Akses mudah ke semua modul utama.

### 2. ✅ Manajer Tugas (Task Manager)
Kelola to-do list dan proyek Anda dengan mudah:
*   **Manajemen Tugas:** Tambah, edit, dan hapus tugas dengan detail prioritas (Tinggi, Sedang, Rendah).
*   **Filter Cerdas:** Pisahkan tugas antara "Tertunda" dan "Selesai" untuk fokus yang lebih baik.
*   **Indikator Status:** Penanda visual yang jelas untuk tenggat waktu (Hari Ini, Besok, Kemarin).

### 3. 💰 Pelacak Keuangan (Financial Tracker)
Kendalikan arus kas pribadi Anda:
*   **Ringkasan Saldo:** Monitor total saldo, pendapatan, dan pengeluaran bulanan.
*   **Grafik Anggaran:** Visualisasi sisa anggaran dengan diagram lingkaran yang intuitif.
*   **Riwayat Transaksi:** Catat dan kategorikan setiap pemasukan dan pengeluaran (Makanan, Transportasi, Gaji, dll).

### 4. ⚙️ Pengaturan & Personalisasi
Sesuaikan aplikasi dengan preferensi Anda:
*   **Profil Pengguna:** Kelola informasi akun, foto profil, dan detail kontak.
*   **Tema UI:** Pilih antara Mode Terang (Light), Mode Gelap (Dark), atau sesuaikan dengan sistem perangkat Anda.
*   **Keamanan:** Fitur ganti kata sandi dan pengaturan notifikasi (Email/Push).

### 5. ❓ Bantuan & Dukungan
Pusat bantuan mandiri dan layanan pelanggan:
*   **Pencarian Bantuan:** Temukan jawaban dengan cepat melalui kolom pencarian.
*   **FAQ Interaktif:** Pertanyaan umum yang sering diajukan dalam format accordion.
*   **Kontak Langsung:** Opsi untuk Chat Langsung atau Kirim Email ke tim dukungan.

### 6. 👮 Dashboard Admin
Panel administrasi untuk mengelola sistem:
*   **Statistik:** Total users, new users bulan ini, active users.
*   **Manajemen User:** Lihat, cari, dan filter daftar pengguna berdasarkan role (User/Admin).
*   **Search & Filter:** Pencarian real-time dan filter role.
*   **Pagination:** Navigasi data user yang terstruktur.

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan teknologi web modern yang handal:

*   **Backend:** [Laravel](https://laravel.com/) (PHP Framework)
*   **Frontend:** [Bootstrap 5](https://getbootstrap.com/) (CSS Framework)
*   **Page Transitions:** [Swup.js](https://swup.js.org/) (SPA-like navigation - Dashboard only)
*   **Styling:** Custom CSS (Tema Indigo & Emerald)
*   **Icons:** [Google Material Symbols](https://fonts.google.com/icons)
*   **Fonts:** [Montserrat](https://fonts.google.com/specimen/Montserrat) (Google Fonts)
*   **Alerts:** [SweetAlert2](https://sweetalert2.github.io/)

## 🚀 Cara Menjalankan

1.  Pastikan PHP dan Composer sudah terinstal.
2.  Clone repositori ini.
3.  Jalankan `composer install` untuk menginstal dependensi backend.
4.  Salin file `.env.example` ke `.env` dan konfigurasi database.
5.  Jalankan `php artisan key:generate` untuk generate app key.
6.  Jalankan `php artisan migrate` untuk membuat tabel database.
7.  (Opsional) Jalankan `php artisan db:seed --class=AdminSeeder` untuk membuat akun admin.
8.  Jalankan `php artisan serve` untuk memulai server lokal.
9.  Buka `http://127.0.0.1:8000` di browser Anda.

**Catatan:** Aplikasi ini **tidak memerlukan** `npm install` atau `npm run dev`. Semua aset CSS sudah tersedia sebagai file static di folder `public/css/`.

## 📝 Catatan Pembaruan (Terbaru)

### Update: Optimisasi Teknis & Dashboard Admin (31 Des 2024)

**🔧 Perbaikan Teknis:**
*   **Removal Vite:** Menghapus dependency Vite.js untuk mempercepat development workflow. Semua CSS sekarang menggunakan file static di `public/css/`.
*   **Optimisasi Swup:** 
    - Menghapus Swup dari Landing Page dan Auth Page untuk memperbaiki masalah layout yang rusak setelah navigasi.
    - Re-implementasi Swup khusus untuk Dashboard (SPA-like navigation tanpa reload).
    - Menambahkan re-initialization script untuk Bootstrap components agar modal/tooltip tetap berfungsi setelah transisi.
*   **Fixed Auth Layout:** Memperbaiki tampilan auth page dengan inline CSS dan menghilangkan gap di bagian atas halaman.

**📊 Dashboard Admin:**
*   Menambahkan **Admin Dashboard** dengan statistik real-time (Total Users, New Users, Active Users).
*   Implementasi **User Management** dengan data real dari database (bukan dummy).
*   Fitur **Search & Filter** untuk mencari dan memfilter user berdasarkan nama, email, atau role.
*   Implementasi **Pagination** untuk navigasi data user.
*   Proteksi route admin dengan middleware `IsAdmin`.

**🧹 Data Cleanup:**
*   Menghapus semua dummy data dari User Dashboard (Tasks, Finance, Activity).
*   Menampilkan empty state yang informatif untuk data kosong.

**📖 Dokumentasi:**
*   Penambahan komentar kode (Bahasa Indonesia) lengkap pada semua Controller dan Middleware untuk memudahkan maintenance.

### Update Sebelumnya: Modernisasi UI & Perbaikan Bug
*   **Fix Bug:** Memperbaiki masalah layar yang semakin gelap (backdrop stacking) saat membuka modal berulang kali dengan menonaktifkan re-inisialisasi script Bootstrap/SweetAlert oleh Swup.js.
*   **Redesign Modal:** Mengubah tampilan modal "Tugas Baru" dan "Transaksi Baru" menjadi lebih modern, bersih, dan premium.
    *   Implementasi *Soft Inputs* dan *Segmented Controls* (Tab Pilihan).
    *   Input mata uang yang lebih besar dan jelas.
*   **Filter Tugas:** Menambahkan fitur tab "Semua", "Tertunda", dan "Selesai" pada halaman Manajer Tugas yang berfungsi penuh.
*   **Dokumentasi:** Penambahan komentar kode (Bahasa Indonesia) untuk memudahkan pengembangan selanjutnya.

---
Dikembangkan dengan ❤️ oleh Tim KawalDiri.
