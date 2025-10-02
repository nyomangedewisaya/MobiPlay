<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Order::truncate();
        DB::table('order_items')->truncate();

        $customerUsers = User::where('role', 'user')->get();
        $items = Item::where('status', 'active')->get();

        if ($items->isEmpty()) {
            $this->command->info('Tidak ada item aktif untuk membuat pesanan. Lewati OrderSeeder.');
            return;
        }

        $taxRate = 0.11; 
        $orderCount = 200; 

        $startDate = Carbon::create(2025, 4, 1);
        $endDate = Carbon::now();

        for ($i = 0; $i < $orderCount; $i++) {
            $item = $items->random();
            $product = $item->product;

            $user = rand(1, 4) > 1 && $customerUsers->isNotEmpty() ? $customerUsers->random() : null;

            $price = $item->price;
            if ($item->discount_percentage > 0) {
                $price -= $price * ($item->discount_percentage / 100);
            }
            $totalAmount = round($price * (1 + $taxRate));

            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));

            $order = Order::create([
                'user_id' => $user->id ?? null,
                'user_email' => $user->email ?? "guest{$i}@example.com",
                'order_code' => 'MPL-' . $randomDate->timestamp . '-' . Str::upper(Str::random(5)),
                'midtrans_transaction_id' => 'TRF-' . Str::upper(Str::random(12)) . Str::upper(Str::random(8)),
                'total_amount' => $totalAmount,
                'status' => ['success', 'success', 'success', 'pending', 'failed'][rand(0, 4)], // Lebih banyak 'success'
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $userData = [];
            if ($product && $product->productInputFields) {
                foreach ($product->productInputFields as $field) {
                    $value = '';
                    switch ($field->field_type) {
                        case 'number':
                            $value = rand(10000000, 999999999);
                            break;
                        case 'email':
                            $value = "player{$i}@email.com";
                            break;
                        case 'select':
                            $options = $field->field_options; 
                            if (is_array($options) && !empty($options)) {
                                $value = $options[array_rand($options)];
                            }
                            break;
                        default:
                            $value = 'USER' . rand(100, 999) . '#' . rand(1000, 9999);
                            break;
                    }
                    $userData[$field->field_label] = (string) $value;
                }
            }

            $order->orderItems()->create([
                'item_id' => $item->id,
                'price_purchase' => $item->price,
                'discount_purchase' => $item->discount_percentage,
                'user_data' => json_encode($userData),
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
