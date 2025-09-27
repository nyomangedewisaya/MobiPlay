<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);
        $this->call([CategoriesSeeder::class]);
        $this->call([ProductsSeeder::class]);
        $this->call([ItemsSeeder::class]);

        // php artisan db:seed --class=ProductSeeder
    }
}
