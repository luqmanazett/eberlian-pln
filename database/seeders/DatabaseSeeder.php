<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Utama (Level 1)
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@pln.co.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'admin_level' => 1,
            'no_telepon' => '081111111111',
            'no_ktp' => '1111111111111111',
        ]);

        // 2. Admin Verifikator (Level 2)
        User::create([
            'name' => 'Verifikator PLN',
            'email' => 'verifikator@pln.co.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'admin_level' => 2,
            'no_telepon' => '082222222222',
            'no_ktp' => '2222222222222222',
        ]);

        // 3. User / Pelanggan
        User::create([
            'name' => 'Budi Pelanggan',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'admin_level' => null,
            'no_telepon' => '083333333333',
            'no_ktp' => '3333333333333333',
        ]);
        
        // 4. Manajer PLN
        User::create([
            'name' => 'Manajer PLN',
            'email' => 'manajer@pln.co.id',
            'password' => bcrypt('password'),
            'role' => 'management',
            'admin_level' => null,
            'no_telepon' => '084444444444',
            'no_ktp' => '4444444444444444',
        ]);
    }
}
