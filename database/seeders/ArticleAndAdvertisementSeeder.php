<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleAndAdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('advertisements')->truncate();
        DB::table('articles')->truncate();

        Advertisement::create([
            'title' => 'Promo Spotify Premium',
            'slug' => Str::slug('Promo Spotify Premium'),
            'banner_url' => 'https://placehold.co/1200x480/1DB954/FFFFFF?text=Promo+Spotify',
            'target_url' => '#',
            'status' => 'active',
        ]);
        Advertisement::create([
            'title' => 'Event Free Fire Terbaru',
            'slug' => Str::slug('Event Free Fire Terbaru'),
            'banner_url' => 'https://placehold.co/600x300/FF8C00/FFFFFF?text=Event+Free+Fire',
            'target_url' => '#',
            'status' => 'active',
        ]);
        Advertisement::create([
            'title' => 'Giveaway MobiPlay',
            'slug' => Str::slug('Giveaway MobiPlay'),
            'banner_url' => 'https://placehold.co/600x300/4F46E5/FFFFFF?text=Giveaway+MobiPlay',
            'target_url' => '#',
            'status' => 'inactive',
        ]);

        $articles = [
            [
                'title' => '5 Hero Terbaik untuk Push Rank di Mobile Legends Season Ini',
                'content' => 'Berikut adalah daftar hero META yang paling efektif untuk digunakan dalam push rank. Pelajari kelebihan dan kekurangan masing-masing untuk mendominasi Land of Dawn.',
                'status' => 'active',
            ],
            [
                'title' => 'Cara Mendapatkan Diskon Spotify Premium untuk Pelajar',
                'content' => 'Bagi kamu yang masih berstatus pelajar, ada cara mudah untuk mendapatkan harga spesial untuk langganan Spotify Premium. Simak langkah-langkahnya di sini!',
                'status' => 'active',
            ],
            [
                'title' => 'Semua yang Perlu Kamu Tahu Tentang Update Genshin Impact Terbaru',
                'content' => 'Update besar selanjutnya akan segera tiba! Dari karakter baru hingga area baru yang bisa dijelajahi, kami merangkum semua bocoran dan informasi resmi untukmu.',
                'status' => 'active',
            ],
            [
                'title' => 'Tips & Trik Menggunakan Senjata M416 di PUBG Mobile',
                'content' => 'M416 adalah senjata favorit banyak pemain. Pelajari cara memaksimalkan potensinya dengan attachment yang tepat dan teknik recoil control di artikel ini.',
                'status' => 'inactive',
            ],
            [
                'title' => 'Panduan Top Up Valorant Points Termurah di MobiPlay',
                'content' => 'Ingin membeli skin Valorant terbaru? Ikuti panduan mudah ini untuk melakukan top up Valorant Points dengan harga terbaik dan proses tercepat hanya di MobiPlay.',
                'status' => 'active',
            ],
        ];

        foreach ($articles as $article) {
            Article::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'banner_url' => 'https://placehold.co/600x300/1e293b/94a3b8?text=' . urlencode($article['title']),
                'status' => $article['status'],
            ]);
        }
    }
}
