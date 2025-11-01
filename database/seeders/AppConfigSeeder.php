<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use Illuminate\Database\Seeder;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppConfig::create([
            'key' => 'USER_FREE_WALLET_LIMIT',
            'value' => 2,
            'description' => 'The number of free wallets a user can have',
        ]);

        AppConfig::create([
            'key' => 'GEMINI_MODEL',
            'value' => 'gemini-2.0-flash',
            'description' => 'The model to use for the Gemini API',
        ]);

        $prompt = '
Analisis teks pada gambar struk ini dan ambil hanya data yang terdapat di bagian daftar pembelian.
Pastikan hanya membaca baris yang berisi nama item, jumlah (Qty), dan harga dalam Rupiah (Rp). 
Instruksi ekstraksi: 
1. Ambil nama toko persis seperti tertulis di struk.
2. Ambil alamat cabang toko persis seperti tertulis di struk.
3. Ambil nama item persis seperti tertulis di struk.
4. Ambil harga per item dalam angka saja (tanpa simbol Rp, tanpa titik).
5. Ambil jumlah item (Qty) sebagai angka.
6. Ambil total harga keseluruhan item dari baris “Total Incl. PPN”.
7. Format output wajib JSON seperti ini:
{
    "store": string,
    "address": string,
    "items": [
        {
            "name": string,
            "price": number,
            "quantity": number
        }
    ],
    "total": number
}';

        AppConfig::create([
            'key' => 'GEMINI_OCR_PROMPT',
            'value' => $prompt,
            'description' => 'The prompt to use for the Gemini OCR API',
        ]);
    }
}
