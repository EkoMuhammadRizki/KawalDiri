<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari admin berdasarkan email
        $admin = User::where('email', 'admin@kawaldiri.id')->first();

        if (!$admin) {
            // Buat admin baru jika belum ada
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@kawaldiri.id',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user created successfully!');
        } else {
            // Update password dan username admin jika sudah ada
            $admin->username = 'admin';
            $admin->password = Hash::make('admin123');
            $admin->is_active = true;
            $admin->save();

            $this->command->info('✅ Admin credentials updated successfully!');
        }

        $this->command->info('📧 Email: admin@kawaldiri.id');
        $this->command->info('👤 Username: admin');
        $this->command->info('🔑 Password: admin123');
    }
}
