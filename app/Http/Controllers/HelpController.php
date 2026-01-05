<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * HelpController
 * Controller untuk menangani halaman Bantuan & Dukungan
 * Termasuk form kontak support dan pencarian FAQ
 */
class HelpController extends Controller
{
    /**
     * Menampilkan halaman bantuan
     */
    public function index()
    {
        return view('dashboard.help');
    }

    /**
     * Menyimpan pesan dukungan dari user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'subject.required' => 'Subjek pesan wajib diisi.',
            'subject.max' => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        $user = Auth::user();

        // Log pesan support (dalam production, ini bisa dikirim ke email atau sistem tiket)
        Log::info('Support Message Received', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'timestamp' => now()->toDateTimeString(),
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah berhasil dikirim! Tim dukungan kami akan menghubungi Anda melalui email dalam 1-2 hari kerja.',
        ]);
    }

    /**
     * Mencari FAQ berdasarkan keyword
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchFaq(Request $request)
    {
        $query = strtolower($request->input('q', ''));

        // Daftar FAQ (bisa dipindah ke database jika diperlukan)
        $faqs = [
            [
                'id' => 'faq1',
                'question' => 'Bagaimana cara mereset kata sandi saya?',
                'answer' => 'Anda dapat mereset kata sandi melalui halaman Pengaturan di bagian Akun > Keamanan. Jika Anda tidak bisa masuk, gunakan opsi "Lupa Kata Sandi" pada halaman login, dan kami akan mengirimkan tautan reset ke email Anda.',
                'keywords' => ['password', 'sandi', 'reset', 'lupa', 'kata sandi', 'ganti password']
            ],
            [
                'id' => 'faq2',
                'question' => 'Apakah data pribadi saya aman?',
                'answer' => 'Keamanan data adalah prioritas utama kami. Semua data dienkripsi menggunakan standar industri AES-256. Kami tidak pernah membagikan data pribadi Anda tanpa izin.',
                'keywords' => ['data', 'aman', 'privasi', 'keamanan', 'enkripsi', 'pribadi']
            ],
            [
                'id' => 'faq3',
                'question' => 'Bagaimana cara menambahkan tugas baru?',
                'answer' => 'Klik tombol "Tambah Tugas" di halaman Manajer Tugas, isi detail tugas seperti judul, deskripsi, prioritas, dan tanggal jatuh tempo, lalu klik "Simpan".',
                'keywords' => ['tugas', 'task', 'tambah', 'baru', 'buat', 'todo']
            ],
            [
                'id' => 'faq4',
                'question' => 'Bagaimana cara mencatat transaksi keuangan?',
                'answer' => 'Buka halaman Pelacak Keuangan dan klik tombol "Tambah Transaksi". Pilih tipe (pemasukan/pengeluaran), masukkan jumlah, kategori, dan deskripsi, lalu simpan.',
                'keywords' => ['transaksi', 'keuangan', 'uang', 'tambah', 'catat', 'pengeluaran', 'pemasukan', 'finance']
            ],
            [
                'id' => 'faq5',
                'question' => 'Bagaimana cara mengubah tema aplikasi?',
                'answer' => 'Buka halaman Pengaturan dan cari bagian "Tema". Anda dapat memilih antara tema Terang, Gelap, atau mengikuti pengaturan sistem.',
                'keywords' => ['tema', 'dark', 'light', 'gelap', 'terang', 'mode', 'theme', 'tampilan']
            ],
            [
                'id' => 'faq6',
                'question' => 'Bagaimana cara menghapus akun saya?',
                'answer' => 'Untuk menghapus akun, buka Pengaturan > Reset Akun. Perhatikan bahwa tindakan ini akan menghapus semua data Anda secara permanen dan tidak dapat dibatalkan.',
                'keywords' => ['hapus', 'akun', 'delete', 'tutup', 'buang', 'remove']
            ],
            [
                'id' => 'faq7',
                'question' => 'Apakah aplikasi ini gratis?',
                'answer' => 'Ya! KawalDiri adalah aplikasi yang 100% gratis. Semua fitur tersedia tanpa biaya langganan atau pembayaran tersembunyi.',
                'keywords' => ['gratis', 'bayar', 'free', 'harga', 'biaya', 'langganan', 'berbayar']
            ],
        ];

        // Jika query kosong, return semua FAQ
        if (empty($query)) {
            return response()->json([
                'success' => true,
                'results' => $faqs,
            ]);
        }

        // Filter FAQ berdasarkan query
        $results = array_filter($faqs, function ($faq) use ($query) {
            // Cek di question
            if (str_contains(strtolower($faq['question']), $query)) {
                return true;
            }
            // Cek di answer
            if (str_contains(strtolower($faq['answer']), $query)) {
                return true;
            }
            // Cek di keywords
            foreach ($faq['keywords'] as $keyword) {
                if (str_contains($keyword, $query) || str_contains($query, $keyword)) {
                    return true;
                }
            }
            return false;
        });

        return response()->json([
            'success' => true,
            'results' => array_values($results),
        ]);
    }
}
