<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'tanggal'    => '2025-07-02',
                'nominal'    => 100000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-03',
                'nominal'    => 200000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-04',
                'nominal'    => 300000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-05',
                'nominal'    => 100000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-06',
                'nominal'    => 300000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-07',
                'nominal'    => 100000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-08',
                'nominal'    => 200000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-09',
                'nominal'    => 200000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-10',
                'nominal'    => 300000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
            [
                'tanggal'    => '2025-07-11',
                'nominal'    => 100000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
            ],
        ];
        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('discount')->insert($item);
        }
    }
}