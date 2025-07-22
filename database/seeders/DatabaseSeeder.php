<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UserSeeder
        $this->call([
            BranchSeeder::class,
            UserSeeder::class,
            // Anda bisa menambahkan seeder lain di sini nanti, misal PatientSeeder
        ]);
    }
}