<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $articles = [
            [
                'title' => 'Update Fitur Baru di MobiPlay',
                'slug' => Str::slug('Update Fitur Baru di MobiPlay'),
                'content' => 'MobiPlay kini hadir dengan fitur baru yang memudahkan pengguna dalam mengelola produk dan transaksi.',
                'banner_url' => 'https://via.placeholder.com/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tips Mengelola Produk Lebih Efisien',
                'slug' => Str::slug('Tips Mengelola Produk Lebih Efisien'),
                'content' => 'Dengan dashboard baru, admin dapat memantau dan mengelola produk lebih cepat dan terstruktur.',
                'banner_url' => 'https://via.placeholder.com/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Responsive Design untuk Admin Panel',
                'slug' => Str::slug('Responsive Design untuk Admin Panel'),
                'content' => 'Tampilan admin panel kini sudah responsive dan nyaman digunakan di berbagai perangkat, baik desktop maupun mobile.',
                'banner_url' => 'https://via.placeholder.com/600x300',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Maintenance Sistem Terjadwal',
                'slug' => Str::slug('Maintenance Sistem Terjadwal'),
                'content' => 'Sistem MobiPlay akan menjalani maintenance rutin untuk peningkatan performa. Beberapa layanan mungkin tidak tersedia sementara.',
                'banner_url' => 'https://via.placeholder.com/600x300',
                'status' => 'inactive',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Peningkatan Keamanan Data Pengguna',
                'slug' => Str::slug('Peningkatan Keamanan Data Pengguna'),
                'content' => 'Kami terus meningkatkan keamanan data agar pengalaman pengguna tetap aman dan nyaman.',
                'banner_url' => 'https://via.placeholder.com/600x300',
                'status' => 'inactive',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('articles')->insert($articles);
    }
}
