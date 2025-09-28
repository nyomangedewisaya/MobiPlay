<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $ads = [
            [
                'title'       => 'Promo Diamond Mobile Legends',
                'slug'        => Str::slug('Promo Diamond Mobile Legends'),
                'banner_url'  => 'https://via.placeholder.com/600x200?text=Promo+MLBB',
                'target_url'  => 'https://moplay.com/promo/mlbb',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Diskon Besar PUBG UC',
                'slug'        => Str::slug('Diskon Besar PUBG UC'),
                'banner_url'  => 'https://via.placeholder.com/600x200?text=Promo+PUBG',
                'target_url'  => 'https://moplay.com/promo/pubg',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Top Up Spotify Premium',
                'slug'        => Str::slug('Top Up Spotify Premium'),
                'banner_url'  => 'https://via.placeholder.com/600x200?text=Promo+Spotify',
                'target_url'  => 'https://moplay.com/promo/spotify',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Event Free Fire Terbaru',
                'slug'        => Str::slug('Event Free Fire Terbaru'),
                'banner_url'  => 'https://via.placeholder.com/600x200?text=Event+Free+Fire',
                'target_url'  => 'https://moplay.com/event/freefire',
                'status'      => 'inactive',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'title'       => 'Giveaway MobiPlay',
                'slug'        => Str::slug('Giveaway MobiPlay'),
                'banner_url'  => 'https://via.placeholder.com/600x200?text=Giveaway',
                'target_url'  => 'https://moplay.com/giveaway',
                'status'      => 'inactive',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        DB::table('advertisements')->insert($ads);
    }
}
