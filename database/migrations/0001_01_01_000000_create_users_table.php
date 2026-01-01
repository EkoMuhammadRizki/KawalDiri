<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable(); // Nama pengguna (default: name)
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable(); // Nomor telepon
            $table->integer('avatar')->default(1); // Avatar number (1-8)
            $table->enum('role', ['user', 'admin'])->default('user');

            // Preferensi tampilan
            $table->enum('theme_preference', ['light', 'dark', 'system'])->default('system');
            $table->string('accent_color')->default('#6366f1'); // Warna aksen dashboard

            // Pengaturan notifikasi
            $table->boolean('email_notifications')->default(true);
            $table->boolean('weekly_reports')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
