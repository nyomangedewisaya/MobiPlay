<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductInputSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('product_input_fields')->insert([
            // ================= FREE FIRE =================
            [
                'product_id' => 3,
                'field_name' => 'player_id',
                'field_label' => 'Masukkan Player ID',
                'field_type' => 'text',
                'field_desc' => 'Untuk menemukan ID Anda, klik pada ikon avatar. User ID tercantum di bawah nama karakter Anda. Contoh: 363266446.',
                'field_options' => null,
                'placeholder' => 'Player ID',
                'validation_rules' => 'required|numeric',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ================= PUBG =================
            [
                'product_id' => 4,
                'field_name' => 'pubg_id',
                'field_label' => 'Masukkan ID Akun',
                'field_type' => 'text',
                'field_desc' => 'Untuk menemukan ID Anda, klik pada ikon avatar. ID akun tercantum di bawah nama karakter Anda. Contoh: 363266446.',
                'field_options' => null,
                'placeholder' => 'ID Akun',
                'validation_rules' => 'required|numeric',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ================= MLBB =================
            [
                'product_id' => 18,
                'field_name' => 'mlbb_id',
                'field_label' => 'Masukkan User ID',
                'field_type' => 'text',
                'field_desc' => 'Masukkan User ID Mobile Legends Anda',
                'field_options' => null,
                'placeholder' => 'Silakan masukkan User ID Anda untuk menyelesaikan transaksi. Contoh : 12345678(1234).',
                'validation_rules' => 'required|numeric',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 18,
                'field_name' => 'mlbb_zone',
                'field_label' => 'Zone ID',
                'field_type' => 'number',
                'field_desc' => 'Masukkan Zone ID Mobile Legends Anda',
                'placeholder' => 'Masukkan Zona ID. Contoh: 1234',
                'field_options' => null,
                'validation_rules' => 'required|numeric',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ================= NETFLIX =================
            [
                'product_id' => 13,
                'field_name' => 'email_netflix',
                'field_label' => 'Masukkan Email Akun',
                'field_type' => 'email',
                'field_desc' => 'Masukkan email akun Netflix Anda. Contoh: email@gmail.com',
                'field_options' => null,
                'placeholder' => 'Email Akun',
                'validation_rules' => 'required|email',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ================= CLASH OF CLANS =================
            [
                'product_id' => 12,
                'field_name' => 'coc_id',
                'field_label' => 'Masukkan Player Tag',
                'field_type' => 'text',
                'field_desc' => 'Masukkan Player Tag COC Anda',
                'placeholder' => 'Player Tag',
                'field_options' => null,
                'validation_rules' => 'required',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ================= GENSHIN IMPACT =================
            [
                'product_id' => 11,
                'field_name' => 'genshin_uid',
                'field_label' => 'Masukkan UID',
                'field_type' => 'text',
                'field_desc' => 'Untuk menemukan UID Anda, masuk pakai akun Anda. Klik pada tombol profile di pojok kiri atas layar. Temukan UID dibawah avatar. Masukan UID Anda di sini. Selain itu, Anda juga dapat temukan UID Anda di pojok bawah kanan layar.',
                'field_options' => null,
                'placeholder' => 'UID',
                'validation_rules' => 'required|numeric',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 11,
                'field_name' => 'genshin_server',
                'field_label' => 'Server',
                'field_type' => 'select',
                'field_desc' => 'Pilih server',
                'field_options' => json_encode(["Asia", "America", "Europe", "TW/HK/MO"]),
                'placeholder' => null,
                'validation_rules' => 'required',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
