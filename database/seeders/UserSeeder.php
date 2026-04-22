<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Update atau buat User Biasa (Pelanggan)
        User::updateOrCreate(
            ['email' => 'user@pln.test'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'admin_level' => null,
                'no_telepon' => '081234567890',
                'no_ktp' => '1234567890123456',
                'email_verified_at' => now(),
            ]
        );
        
        // Update atau buat Admin Utama (Level 1)
        User::updateOrCreate(
            ['email' => 'admin@pln.test'],
            [
                'name' => 'Admin PLN',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'admin_level' => 1,
                'no_telepon' => '081234567891',
                'no_ktp' => '1234567890123457',
                'email_verified_at' => now(),
            ]
        );
        
        // Update atau buat Admin Verifikator (Level 2)
        User::updateOrCreate(
            ['email' => 'verifikator@pln.test'],
            [
                'name' => 'Verifikator PLN',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'admin_level' => 2,
                'no_telepon' => '081234567893',
                'no_ktp' => '1234567890123458',
                'email_verified_at' => now(),
            ]
        );
        
        // Update atau buat Management
        User::updateOrCreate(
            ['email' => 'management@pln.test'],
            [
                'name' => 'Manager PLN',
                'password' => Hash::make('password123'),
                'role' => 'management',
                'admin_level' => null,
                'no_telepon' => '081234567892',
                'no_ktp' => '1234567890123459',
                'email_verified_at' => now(),
            ]
        );
        
        echo "✅ UserSeeder berhasil (update/create):\n";
        echo "   - user@pln.test / password123 (User)\n";
        echo "   - admin@pln.test / password123 (Admin Utama - Level 1)\n";
        echo "   - verifikator@pln.test / password123 (Admin Verifikator - Level 2)\n";
        echo "   - management@pln.test / password123 (Management)\n";
    }
}