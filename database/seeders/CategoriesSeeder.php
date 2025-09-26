<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'New',
                'slug' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Populer',
                'slug' => 'populer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Game',
                'slug' => 'game',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Voucher',
                'slug' => 'voucher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
