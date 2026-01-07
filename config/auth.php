<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Autentikasi
    |--------------------------------------------------------------------------
    |
    | Opsi ini mendefinisikan "guard" autentikasi default dan
    | "broker" reset password untuk aplikasi Anda. Anda dapat mengubah nilai ini
    | sesuai kebutuhan, tetapi ini adalah awal yang sempurna untuk sebagian besar aplikasi.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard Autentikasi
    |--------------------------------------------------------------------------
    |
    | Selanjutnya, Anda dapat mendefinisikan setiap guard autentikasi untuk aplikasi Anda.
    | Tentu saja, konfigurasi default yang bagus telah didefinisikan untuk Anda
    | yang menggunakan penyimpanan session ditambah provider user Eloquent.
    |
    | Semua guard autentikasi memiliki provider user, yang mendefinisikan bagaimana
    | user sebenarnya diambil dari database atau sistem penyimpanan lain
    | yang digunakan oleh aplikasi. Biasanya, Eloquent digunakan.
    |
    | Didukung: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Provider User
    |--------------------------------------------------------------------------
    |
    | Semua guard autentikasi memiliki provider user, yang mendefinisikan bagaimana
    | user sebenarnya diambil dari database atau sistem penyimpanan lain
    | yang digunakan oleh aplikasi. Biasanya, Eloquent digunakan.
    |
    | Jika Anda memiliki beberapa tabel atau model user, Anda dapat mengkonfigurasi beberapa
    | provider untuk mewakili model / tabel tersebut. Provider-provider ini kemudian dapat
    | ditetapkan ke guard autentikasi tambahan yang telah Anda definisikan.
    |
    | Didukung: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    |
    | Opsi konfigurasi ini menentukan perilaku fungsi reset password Laravel,
    | termasuk tabel yang digunakan untuk penyimpanan token
    | dan provider user yang dipanggil untuk benar-benar mengambil user.
    |
    | Waktu kedaluwarsa adalah jumlah menit di mana setiap token reset akan
    | dianggap valid. Fitur keamanan ini menjaga token tetap berumur pendek sehingga
    | mereka memiliki lebih sedikit waktu untuk ditebak. Anda dapat mengubah ini jika diperlukan.
    |
    | Pengaturan throttle adalah jumlah detik user harus menunggu sebelum
    | menghasilkan lebih banyak token reset password. Ini mencegah user dari
    | dengan cepat menghasilkan sejumlah besar token reset password.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout Konfirmasi Password
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat mendefinisikan jumlah detik sebelum jendela konfirmasi password
    | kedaluwarsa dan user diminta untuk memasukkan kembali password mereka melalui
    | layar konfirmasi. Secara default, timeout berlangsung selama tiga jam.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
