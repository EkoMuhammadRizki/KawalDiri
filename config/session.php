<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver Session Default
    |--------------------------------------------------------------------------
    |
    | Opsi ini menentukan driver session default yang digunakan untuk
    | request yang masuk. Laravel mendukung berbagai opsi penyimpanan untuk
    | menyimpan data session. Penyimpanan database adalah pilihan default yang bagus.
    |
    | Didukung: "file", "cookie", "database", "memcached",
    |           "redis", "dynamodb", "array"
    |
    */

    'driver' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Lifetime Session
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan jumlah menit yang Anda inginkan agar session
    | diizinkan untuk tetap idle sebelum kedaluwarsa. Jika Anda ingin mereka
    | kedaluwarsa segera ketika browser ditutup maka Anda dapat
    | menunjukkan hal itu melalui opsi konfigurasi expire_on_close.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Enkripsi Session
    |--------------------------------------------------------------------------
    |
    | Opsi ini memungkinkan Anda untuk dengan mudah menentukan bahwa semua data session Anda
    | harus dienkripsi sebelum disimpan. Semua enkripsi dilakukan
    | secara otomatis oleh Laravel dan Anda dapat menggunakan session seperti biasa.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Lokasi File Session
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver session "file", file session ditempatkan
    | di disk. Lokasi penyimpanan default didefinisikan di sini; namun, Anda
    | bebas menyediakan lokasi lain di mana mereka harus disimpan.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Koneksi Database Session
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver session "database" atau "redis", Anda dapat menentukan
    | koneksi yang harus digunakan untuk mengelola session ini. Ini harus
    | sesuai dengan koneksi di opsi konfigurasi database Anda.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Tabel Database Session
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver session "database", Anda dapat menentukan tabel yang
    | akan digunakan untuk menyimpan session. Tentu saja, default yang masuk akal didefinisikan
    | untuk Anda; namun, Anda dipersilakan untuk mengubah ini ke tabel lain.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Cache Store Session
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan salah satu backend session berbasis cache framework, Anda dapat
    | mendefinisikan cache store yang harus digunakan untuk menyimpan data session
    | antar request. Ini harus sesuai dengan salah satu store cache yang Anda definisikan.
    |
    | Mempengaruhi: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Lotere Pembersihan Session
    |--------------------------------------------------------------------------
    |
    | Beberapa driver session harus secara manual membersihkan lokasi penyimpanan mereka untuk
    | menyingkirkan session lama dari penyimpanan. Berikut adalah peluang bahwa itu akan
    | terjadi pada request tertentu. Secara default, peluangnya adalah 2 dari 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nama Cookie Session
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat mengubah nama cookie session yang dibuat oleh
    | framework. Biasanya, Anda tidak perlu mengubah nilai ini
    | karena melakukannya tidak memberikan peningkatan keamanan yang berarti.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')) . '-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Path Cookie Session
    |--------------------------------------------------------------------------
    |
    | Path cookie session menentukan path di mana cookie akan
    | dianggap tersedia. Biasanya, ini akan menjadi root path dari
    | aplikasi Anda, tetapi Anda bebas mengubah ini bila diperlukan.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Domain Cookie Session
    |--------------------------------------------------------------------------
    |
    | Nilai ini menentukan domain dan subdomain di mana cookie session
    | tersedia. Secara default, cookie akan tersedia untuk root
    | domain tanpa subdomain. Biasanya, ini tidak perlu diubah.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Hanya HTTPS
    |--------------------------------------------------------------------------
    |
    | Dengan mengatur opsi ini ke true, cookie session hanya akan dikirim kembali
    | ke server jika browser memiliki koneksi HTTPS. Ini akan menjaga
    | cookie tidak dikirim kepada Anda ketika tidak dapat dilakukan dengan aman.
    |
    */

    'secure' => false,

    /*
    |--------------------------------------------------------------------------
    | Akses Hanya HTTP
    |--------------------------------------------------------------------------
    |
    | Mengatur nilai ini ke true akan mencegah JavaScript mengakses
    | nilai cookie dan cookie hanya akan dapat diakses melalui
    | protokol HTTP. Tidak mungkin Anda harus menonaktifkan opsi ini.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Cookie Same-Site
    |--------------------------------------------------------------------------
    |
    | Opsi ini menentukan bagaimana cookie Anda berperilaku ketika request lintas situs
    | terjadi, dan dapat digunakan untuk mengurangi serangan CSRF. Secara default, kami
    | akan mengatur nilai ini ke "lax" untuk mengizinkan request lintas situs yang aman.
    |
    | Lihat: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Didukung: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Cookie yang Dipartisi
    |--------------------------------------------------------------------------
    |
    | Mengatur nilai ini ke true akan mengikat cookie ke situs tingkat atas untuk
    | konteks lintas situs. Cookie yang dipartisi diterima oleh browser
    | ketika ditandai "secure" dan atribut Same-Site diatur ke "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
