<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nama Aplikasi
    |--------------------------------------------------------------------------
    |
    | Nilai ini adalah nama aplikasi Anda, yang akan digunakan ketika
    | framework perlu menempatkan nama aplikasi di notifikasi atau
    | elemen UI lain di mana nama aplikasi perlu ditampilkan.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Environment Aplikasi
    |--------------------------------------------------------------------------
    |
    | Nilai ini menentukan "environment" di mana aplikasi Anda saat ini
    | berjalan. Ini dapat menentukan bagaimana Anda lebih suka mengkonfigurasi
    | berbagai layanan yang digunakan aplikasi. Atur ini di file ".env" Anda.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Mode Debug Aplikasi
    |--------------------------------------------------------------------------
    |
    | Ketika aplikasi Anda dalam mode debug, pesan error detail dengan
    | stack trace akan ditampilkan pada setiap error yang terjadi dalam
    | aplikasi Anda. Jika dinonaktifkan, halaman error generik sederhana akan ditampilkan.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL Aplikasi
    |--------------------------------------------------------------------------
    |
    | URL ini digunakan oleh console untuk menghasilkan URL dengan benar saat
    | menggunakan command line tool Artisan. Anda harus mengatur ini ke root
    | aplikasi sehingga tersedia di dalam perintah Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Timezone Aplikasi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan timezone default untuk aplikasi Anda, yang
    | akan digunakan oleh fungsi tanggal dan waktu PHP. Timezone
    | diatur ke "UTC" secara default karena cocok untuk sebagian besar kasus.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Locale Aplikasi
    |--------------------------------------------------------------------------
    |
    | Locale aplikasi menentukan locale default yang akan digunakan
    | oleh metode terjemahan / lokalisasi Laravel. Opsi ini dapat
    | diatur ke locale apa pun yang Anda rencanakan untuk memiliki string terjemahan.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Kunci Enkripsi
    |--------------------------------------------------------------------------
    |
    | Kunci ini digunakan oleh layanan enkripsi Laravel dan harus diatur
    | ke string acak 32 karakter untuk memastikan bahwa semua nilai terenkripsi
    | aman. Anda harus melakukan ini sebelum men-deploy aplikasi.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Mode Pemeliharaan
    |--------------------------------------------------------------------------
    |
    | Opsi konfigurasi ini menentukan driver yang digunakan untuk menentukan dan
    | mengelola status "mode pemeliharaan" Laravel. Driver "cache" akan
    | memungkinkan mode pemeliharaan dikontrol di beberapa mesin.
    |
    | Driver yang didukung: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
