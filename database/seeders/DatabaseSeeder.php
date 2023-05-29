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
        // \App\Models\User::factory(10)->create();

        \App\Models\Category::factory()->create([
            'category' => 'Women',
            'origin' => 'Italy',
            'brandName'=>'Vans',
            'section'=>'Casual',
            'description'=>'Vans shoes',
            'status'=>'0',
        ]);
    }
}
