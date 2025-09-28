<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'item_id' => 3,
                'price_purchase' => 50000,
                'discount_purchase' => 5000,
                'user_data' => json_encode([
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'phone' => '081234567890',
                ]),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'order_id' => 1,
                'item_id' => 4,
                'price_purchase' => 100000,
                'discount_purchase' => 0,
                'user_data' => json_encode([
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'phone' => '081234567890',
                ]),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'order_id' => 2,
                'item_id' => 10,
                'price_purchase' => 75000,
                'discount_purchase' => 5000,
                'user_data' => json_encode([
                    'name' => 'Guest User',
                    'email' => 'guest1@example.com',
                ]),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_id' => 3,
                'item_id' => 12,
                'price_purchase' => 200000,
                'discount_purchase' => 20000,
                'user_data' => json_encode([
                    'name' => 'Guest User 2',
                    'email' => 'guest2@example.com',
                ]),
                'status' => 'inactive',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'order_id' => 4,
                'item_id' => 10,
                'price_purchase' => 120000,
                'discount_purchase' => 0,
                'user_data' => json_encode([
                    'name' => 'Guest User 3',
                    'email' => 'guest3@example.com',
                ]),
                'status' => 'active',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}
