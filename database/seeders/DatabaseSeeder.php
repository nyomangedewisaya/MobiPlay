<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class, 
            ArticleAndAdvertisementSeeder::class,
            OrderSeeder::class, 
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
