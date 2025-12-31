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
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@kawaldiri.id')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@kawaldiri.id',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('📧 Email: admin@kawaldiri.id');
            $this->command->info('🔑 Password: Admin@123');
        } else {
            $this->command->warn('⚠️  Admin user already exists!');
        }
    }
}
