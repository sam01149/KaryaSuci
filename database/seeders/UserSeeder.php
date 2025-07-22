<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data user lama untuk menghindari duplikat (opsional)
        User::query()->delete();

        // 1. Membuat Akun Admin Utama
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@karyasuci.app',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'phone_number' => '081200000001',
        ]);

        // 2. Membuat Akun Manajer (2)
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => 'Manajer ' . $i,
                'email' => 'manajer' . $i . '@karyasuci.app',
                'password' => Hash::make('password'),
                'role' => 'Manajer',
                'phone_number' => '08120000100' . $i,
            ]);
        }
        
        // 3. Membuat Akun Resepsionis (3)
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Resepsionis ' . $i,
                'email' => 'resepsionis' . $i . '@karyasuci.app',
                'password' => Hash::make('password'),
                'role' => 'Resepsionis',
                'phone_number' => '08120000200' . $i,
            ]);
        }

        // 4. Membuat Akun Kasir (3)
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Kasir ' . $i,
                'email' => 'kasir' . $i . '@karyasuci.app',
                'password' => Hash::make('password'),
                'role' => 'Kasir',
                'phone_number' => '08120000300' . $i,
            ]);
        }
        
        // 5. Membuat Akun Fisioterapis (5)
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Fisioterapis ' . $i,
                'email' => 'fisioterapis' . $i . '@karyasuci.app',
                'password' => Hash::make('password'),
                'role' => 'Fisioterapis',
                'phone_number' => '08120000400' . $i,
            ]);
        }
    }
}