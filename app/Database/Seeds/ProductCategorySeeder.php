<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Produk elektronik seperti TV, laptop, dan smartphone.',
            ],
            [
                'nama_kategori' => 'Pakaian',
                'deskripsi' => 'Berbagai jenis pakaian untuk pria, wanita, dan anak-anak.',
            ],
            [
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi' => 'Produk makanan dan minuman kemasan.',
            ],
            [
                'nama_kategori' => 'Peralatan Rumah Tangga',
                'deskripsi' => 'Peralatan untuk kebutuhan rumah tangga.',
            ],
            [
                'nama_kategori' => 'Kesehatan & Kecantikan',
                'deskripsi' => 'Produk kesehatan dan kecantikan.',
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Peralatan dan perlengkapan olahraga.',
            ],
            [
                'nama_kategori' => 'Buku',
                'deskripsi' => 'Berbagai jenis buku dan literatur.',
            ],
            [
                'nama_kategori' => 'Mainan Anak',
                'deskripsi' => 'Mainan untuk anak-anak dari berbagai usia.',
            ],
            [
                'nama_kategori' => 'Otomotif',
                'deskripsi' => 'Produk otomotif seperti aksesoris kendaraan.',
            ],
            [
                'nama_kategori' => 'Peralatan Kantor',
                'deskripsi' => 'Peralatan dan perlengkapan untuk kebutuhan kantor.',
            ],
        ];

        // Insert data ke tabel product_category
        $this->db->table('ProductCategory')->insertBatch($data);
    }
}