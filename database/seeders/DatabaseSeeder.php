<?php

// File: database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete(); // Hapus data lama

        // 1 Akun Admin
        User::factory()->create([
            'name' => 'Admin Sistem', 'email' => 'admin@karyasuci.app', 'role' => 'Admin', 'password' => Hash::make('password'),
        ]);

        // 2 Akun Manajer
        for ($i = 1; $i <= 2; $i++) {
            User::factory()->create(['name' => "Manajer $i", 'email' => "manajer$i@karyasuci.app", 'role' => 'Manajer', 'password' => Hash::make('password')]);
        }

        // 3 Akun Resepsionis
        for ($i = 1; $i <= 3; $i++) {
            User::factory()->create(['name' => "Resepsionis $i", 'email' => "resepsionis$i@karyasuci.app", 'role' => 'Resepsionis', 'password' => Hash::make('password')]);
        }
        
        // 5 Akun Fisioterapis
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create(['name' => "Fisioterapis $i", 'email' => "fisioterapis$i@karyasuci.app", 'role' => 'Fisioterapis', 'password' => Hash::make('password')]);
        }

        // 3 Akun Kasir
        for ($i = 1; $i <= 3; $i++) {
            User::factory()->create(['name' => "Kasir $i", 'email' => "kasir$i@karyasuci.app", 'role' => 'Kasir', 'password' => Hash::make('password')]);
        }
    }
}