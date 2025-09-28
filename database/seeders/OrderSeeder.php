<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 2,
                'user_email' => 'userbaru@example.com',
                'order_code' => 'ORD-2025001',
                'total_amount' => 150000,
                'midtrans_snap_token' => 'snap_tok_abc123',
                'midtrans_transaction_id' => 'trans_id_abc123',
                'status' => 'success',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => null,
                'user_email' => 'guest1@example.com',
                'order_code' => 'ORD-2025002',
                'total_amount' => 75000,
                'midtrans_snap_token' => 'snap_tok_def456',
                'midtrans_transaction_id' => 'trans_id_def456',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => null,
                'user_email' => 'guest2@example.com',
                'order_code' => 'ORD-2025003',
                'total_amount' => 200000,
                'midtrans_snap_token' => 'snap_tok_ghi789',
                'midtrans_transaction_id' => 'trans_id_ghi789',
                'status' => 'failed',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => null,
                'user_email' => 'guest3@example.com',
                'order_code' => 'ORD-2025004',
                'total_amount' => 120000,
                'midtrans_snap_token' => 'snap_tok_jkl012',
                'midtrans_transaction_id' => 'trans_id_jkl012',
                'status' => 'cancelled',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'user_id' => null,
                'user_email' => 'guest4@example.com',
                'order_code' => 'ORD-2025005',
                'total_amount' => 50000,
                'midtrans_snap_token' => 'snap_tok_mno345',
                'midtrans_transaction_id' => 'trans_id_mno345',
                'status' => 'success',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
