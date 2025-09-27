<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $products = [
            // 🎮 Games
            [
                'category_id' => 1,
                'name' => 'Genshin Impact',
                'slug' => Str::slug('Genshin Impact'),
                'description' => 'Top up Genshin Impact dengan mudah hanya di Codashop. Pilih jumlah Genesis Crystals sesuai kebutuhanmu dan bayar lewat berbagai metode populer.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 1,
                'name' => 'Clash of Clans',
                'slug' => Str::slug('Clash of Clans'),
                'description' => 'Beli Gems Clash of Clans secara instan. Nikmati pengalaman top up mudah dengan berbagai metode pembayaran.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🎶 Entertainment
            [
                'category_id' => 2,
                'name' => 'Netflix Voucher',
                'slug' => Str::slug('Netflix Voucher'),
                'description' => 'Nikmati film dan serial favoritmu di Netflix dengan voucher resmi. Bayar dengan GoPay, OVO, Dana, dan lainnya.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 2,
                'name' => 'YouTube Premium',
                'slug' => Str::slug('YouTube Premium'),
                'description' => 'Dapatkan akses bebas iklan dan musik premium di YouTube Premium. Top up cepat dan praktis.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 💻 Software
            [
                'category_id' => 3,
                'name' => 'Microsoft Office 365',
                'slug' => Str::slug('Microsoft Office 365'),
                'description' => 'Dapatkan lisensi resmi Microsoft Office 365 untuk mendukung produktivitas kerjamu. Aktivasi cepat dan aman.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 3,
                'name' => 'Adobe Photoshop',
                'slug' => Str::slug('Adobe Photoshop'),
                'description' => 'Voucher Adobe Photoshop untuk para kreator. Beli sekarang dan mulai berkreasi dengan fitur profesional.',
                'thumbnail_url' => 'https://placehold.co/300x300',
                'banner_url' => 'https://placehold.co/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
