<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'MK001',
                'kategori_nama' => 'Makanan dan Minuman'
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'PA002',
                'kategori_nama' => 'Pakaian dan Aksesoris'
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'EL003',
                'kategori_nama' => 'Elektronik dan Gadget'
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'RT004',
                'kategori_nama' => 'Barang Rumah Tangga'
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'KK005',
                'kategori_nama' => 'Kesehatan dan Kecantikan'
            ]
        ];
        DB::table('m_kategori')->insert($data);

    }
}
