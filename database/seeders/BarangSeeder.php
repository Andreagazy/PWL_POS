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
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'NGG',
                'barang_nama' => 'Nasi Goreng',
                'harga_beli' => 10000,
                'harga_jual' => 15000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'ETH',
                'barang_nama' => 'Es Teh',
                'harga_beli' => 3000,
                'harga_jual' => 5000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'KCL',
                'barang_nama' => 'Kemeja Casual',
                'harga_beli' => 80000,
                'harga_jual' => 120000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'CJS',
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => 50000,
                'harga_jual' => 80000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'SPE',
                'barang_nama' => 'Smartphone',
                'harga_beli' => 1500000,
                'harga_jual' => 2000000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'WES',
                'barang_nama' => 'Wireless Earbuds',
                'harga_beli' => 300000,
                'harga_jual' => 500000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'PSS',
                'barang_nama' => 'Panci Stainless Steel',
                'harga_beli' => 70000,
                'harga_jual' => 100000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'VCR',
                'barang_nama' => 'Vacuum Cleaner',
                'harga_beli' => 200000,
                'harga_jual' => 300000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'PWH',
                'barang_nama' => 'Perawatan Wajah',
                'harga_beli' => 30000,
                'harga_jual' => 50000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'MVN',
                'barang_nama' => 'Multivitamin',
                'harga_beli' => 20000,
                'harga_jual' => 30000
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
