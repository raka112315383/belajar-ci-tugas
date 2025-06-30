<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductcategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Elektronik',
                'nama_product' => 'Smartphone',
                'deskripsi' => 'Smartphone dengan fitur canggih dan desain modern.'
            ],
            [
                'nama_kategori' => 'Elektronik',
                'nama_product' => 'Laptop',
                'deskripsi' => 'Laptop dengan performa tinggi untuk kebutuhan kerja dan gaming.'
            ],
            [
                'nama_kategori' => 'Fashion',
                'nama_product' => 'Kaos',
                'deskripsi' => 'Kaos dengan bahan nyaman dan desain trendy.'
            ],
            [
                'nama_kategori' => 'Fashion',
                'nama_product' => 'Sepatu',
                'deskripsi' => 'Sepatu olahraga dengan kualitas terbaik.'
            ],
            [
                'nama_kategori' => 'Makanan',
                'nama_product' => 'Cokelat',
                'deskripsi' => 'Cokelat lezat dengan berbagai varian rasa.'
            ],
            [
                'nama_kategori' => 'Makanan',
                'nama_product' => 'Keripik',
                'deskripsi' => 'Keripik renyah dengan rasa gurih.'
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'nama_product' => 'Vitamin C',
                'deskripsi' => 'Suplemen vitamin C untuk menjaga daya tahan tubuh.'
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'nama_product' => 'Masker',
                'deskripsi' => 'Masker pelindung untuk kesehatan.'
            ],
            [
                'nama_kategori' => 'Peralatan Rumah',
                'nama_product' => 'Blender',
                'deskripsi' => 'Blender multifungsi untuk kebutuhan dapur.'
            ],
            [
                'nama_kategori' => 'Peralatan Rumah',
                'nama_product' => 'Setrika',
                'deskripsi' => 'Setrika listrik dengan pengaturan suhu.'
            ]
        ];

        $this->db->table('productcategory')->insertBatch($data);
    }
}
