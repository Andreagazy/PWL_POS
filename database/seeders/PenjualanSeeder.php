<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 2,
                'pembeli' => 'Pelanggan A',
                'penjualan_kode' => 'PJ001',
                'penjualan_tanggal' => '2024-02-27'
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Pelanggan B',
                'penjualan_kode' => 'PJ002',
                'penjualan_tanggal' => '2024-02-26'
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 2,
                'pembeli' => 'Pelanggan C',
                'penjualan_kode' => 'PJ003',
                'penjualan_tanggal' => '2024-02-25'
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Pelanggan D',
                'penjualan_kode' => 'PJ004',
                'penjualan_tanggal' => '2024-02-24'
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Pelanggan E',
                'penjualan_kode' => 'PJ005',
                'penjualan_tanggal' => '2024-02-23'
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Pelanggan F',
                'penjualan_kode' => 'PJ006',
                'penjualan_tanggal' => '2024-02-22'
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 2,
                'pembeli' => 'Pelanggan G',
                'penjualan_kode' => 'PJ007',
                'penjualan_tanggal' => '2024-02-21'
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Pelanggan H',
                'penjualan_kode' => 'PJ008',
                'penjualan_tanggal' => '2024-02-20'
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 2,
                'pembeli' => 'Pelanggan I',
                'penjualan_kode' => 'PJ009',
                'penjualan_tanggal' => '2024-02-19'
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Pelanggan J',
                'penjualan_kode' => 'PJ010',
                'penjualan_tanggal' => '2024-02-18'
            ],
        ];
        DB::table('t_penjualan')->insert($data);

    }
}
