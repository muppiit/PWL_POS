<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 21,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 10,
            ],
            [
                'barang_id' => 22,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 20,
            ],
            [
                'barang_id' => 23,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 30,
            ],
            [
                'barang_id' => 24,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 40,
            ],
            [
                'barang_id' => 25,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 50,
            ],
            [
                'barang_id' => 26,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 60,
            ],
            [
                'barang_id' => 27,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 70,
            ],
            [
                'barang_id' => 28,
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
            ],
            [
                'barang_id' => 29,
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 90,
            ],
            [
                'barang_id' => 30,
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
            ],
        ];

        DB::table('t_stok')->insert($data);
    }
}
