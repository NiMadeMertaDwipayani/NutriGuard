<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Akun Admin NutriGuard
        \App\Models\User::create([
            'name' => 'Admin NutriGuard',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('password'), // Passwordnya: password
        ]);

        // Buat 1 User Biasa untuk tes nanti
        \App\Models\User::create([
            'name' => 'Pasien Contoh',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);
    }
}
