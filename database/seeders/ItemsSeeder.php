<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            // Free Fire Diamonds
            [
                'product_id' => 3,
                'name' => 'Free Fire 70 Diamonds',
                'slug' => 'free-fire-70-diamonds',
                'sku' => 'FF-DM-70',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 10000,
                'discount_percentage' => 0,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 3,
                'name' => 'Free Fire 140 Diamonds',
                'slug' => 'free-fire-140-diamonds',
                'sku' => 'FF-DM-140',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 18000,
                'discount_percentage' => 10,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 3,
                'name' => 'Free Fire 355 Diamonds',
                'slug' => 'free-fire-355-diamonds',
                'sku' => 'FF-DM-355',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 50000,
                'discount_percentage' => 15,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // PUBG UC
            [
                'product_id' => 4,
                'name' => 'PUBG 60 UC',
                'slug' => 'pubg-60-uc',
                'sku' => 'PUBG-UC-60',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 15000,
                'discount_percentage' => 0,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 4,
                'name' => 'PUBG 325 UC',
                'slug' => 'pubg-325-uc',
                'sku' => 'PUBG-UC-325',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 75000,
                'discount_percentage' => 5,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 4,
                'name' => 'PUBG 660 UC',
                'slug' => 'pubg-660-uc',
                'sku' => 'PUBG-UC-660',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 140000,
                'discount_percentage' => 20,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Mobile Legends Diamonds
            [
                'product_id' => 18,
                'name' => 'Mobile Legends 86 Diamonds',
                'slug' => 'mobile-legends-86-diamonds',
                'sku' => 'MLBB-DM-86',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 20000,
                'discount_percentage' => 0,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 18,
                'name' => 'Mobile Legends 172 Diamonds',
                'slug' => 'mobile-legends-172-diamonds',
                'sku' => 'MLBB-DM-172',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 39000,
                'discount_percentage' => 10,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 18,
                'name' => 'Mobile Legends Starlight Member',
                'slug' => 'mobile-legends-starlight-member',
                'sku' => 'MLBB-PKG-STL',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 120000,
                'discount_percentage' => 30,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Spotify Premium
            [
                'product_id' => 10,
                'name' => 'Spotify Premium 1 Bulan',
                'slug' => 'spotify-premium-1-bulan',
                'sku' => 'SPOT-PREM-1M',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 49000,
                'discount_percentage' => 0,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 10,
                'name' => 'Spotify Premium 3 Bulan',
                'slug' => 'spotify-premium-3-bulan',
                'sku' => 'SPOT-PREM-3M',
                'image_url' => 'https://placehold.co/300x300',
                'price' => 135000,
                'discount_percentage' => 20,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('items')->insert($items);
    }
}
