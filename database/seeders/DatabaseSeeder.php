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
        $this->call([ArticleSeeder::class]);
        $this->call([AdvertisementSeeder::class]);
        $this->call([ProductInputSeeder::class]);
        $this->call([OrderSeeder::class]);
        $this->call([OrderItemSeeder::class]);

        // php artisan db:seed --class=OrderSeeder
    }
}
