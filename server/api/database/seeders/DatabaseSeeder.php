<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the products table with three products
        DB::table('products')->insert([
            [
                'name' => 'Red Widget',
                'code' => 'R01',
                'price' => 32.95
            ],
            [
                'name' => 'Green Widget',
                'code' => 'G01',
                'price' => 24.95
            ],
            [
                'name' => 'Blue Widget',
                'code' => 'B01',
                'price' => 7.95
            ]
        ]);
    }
}
