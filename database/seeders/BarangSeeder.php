<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'barang_kode' => 'ma001',
                'barang_nama' => 'Mi instan',
                'harga_beli' => 2000,
                'harga_jual' => 3500,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'ma002',
                'barang_nama' => 'Roti',
                'harga_beli' => 5000,
                'harga_jual' => 7000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'mi001',
                'barang_nama' => 'Pocari sweet',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'mi002',
                'barang_nama' => 'aqua',
                'harga_beli' => 1200,
                'harga_jual' => 3000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'ke001',
                'barang_nama' => 'sabun ',
                'harga_beli' => 1000,
                'harga_jual' => 2000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'ke002',
                'barang_nama' => 'sabun2',
                'harga_beli' => 1500,
                'harga_jual' => 2000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'o001',
                'barang_nama' => 'obat 1',
                'harga_beli' => 30000,
                'harga_jual' => 40000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'o002',
                'barang_nama' => 'obat 2',
                'harga_beli' => 50000,
                'harga_jual' => 60000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'mn001',
                'barang_nama' => 'mainan 1',
                'harga_beli' => 75000,
                'harga_jual' => 90000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'mn002',
                'barang_nama' => 'mainan 2',
                'harga_beli' => 85000,
                'harga_jual' => 100000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
