<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

    \App\Models\Branch::create(['name' => 'Siantar']);
    \App\Models\Branch::create(['name' => 'Perdagangan']);
    \App\Models\Branch::create(['name' => 'Kisaran']);
        
    }
}
