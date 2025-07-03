# Toko Online CodeIgniter 4 (Wahyu Store)

Proyek ini adalah platform toko online yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan beberapa fungsionalitas untuk toko online, termasuk manajemen produk, keranjang belanja, dan sistem transaksi.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Proyek](#struktur-proyek)

## Fitur

- Katalog Produk
  - Tampilan produk dengan gambar
  - Pencarian produk
- Keranjang Belanja
  - Tambah/hapus produk
  - Update jumlah produk
- Sistem Transaksi
  - Proses checkout
  - Riwayat transaksi
- Panel Admin
  - Manajemen produk (CRUD)
  - Manajemen kategori
  - Laporan transaksi
  - Export data ke PDF
  - Manajemen Data Diskon
  - Menyimpan Data Detail Transaksi
- Sistem Autentikasi
  - Login/Register pengguna
  - Manajemen akun
- UI Responsif dengan NiceAdmin template

## Persyaratan Sistem

- PHP >= 7.4
- Composer
- Web server (XAMPP)

## Instalasi

1. **Clone repository ini**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
   ```bash
   php spark db:seed ProductcategorySeeder
   ```
   ```bash
   php spark db:seed DiscountSeeder
   ```
6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek

Proyek menggunakan struktur MVC CodeIgniter 4:

- app/Controllers - Logika aplikasi dan penanganan request
  - AuthController.php            : Autentikasi pengguna (login dan logout)
  - ProdukController.php          : Manajemen produk (Menampilkan daftar produk, menambah, edit, hapus)
  - TransaksiController.php       : Proses transaksi(Menampilkan detail transaksi dan checkout)
  - ApiController.php             : Menangani request API (misalnya, untuk mengambil data penjualan dan data diskon).
  - BaseController.php            : Kelas dasar untuk kontroler lain, berisi fungsionalitas
  - ContactController.php         : Menampilkan informasi kontak
  - DiscountController.php        : Manajemen diskon (menampilkan daftar diskon, menambah, mengedit, menghapus diskon).
  - FaqController.php             : Menampilkan halaman FAQ
  - Home.php                      : Kontroler utama untuk halaman beranda atau landing page aplikasi.
  - KategoriProdukController.php  : Manajemen kategori produk (menampilkan daftar kategori, menambah, mengedit, menghapus kategori).
  - ProfileController.php         : Menampilkan detail transaksi

- app/Database/Migrations - Kontrol versi untuk Database
  - User.php              : memodifikasi tabel user (pengguna) di database, termasuk kolom seperti username, password, role.
  - Product.php           : memodifikasi tabel product (produk) di database, termasuk kolom seperti nama, harga, jumlah, foto.
  - Transaction.php       : memodifikasi tabel transactions di database, termasuk kolom seperti nama pembeli, total_harga, alamat, ongkir, status.
  - TransactionDetail.php : memodifikasi tabel transaction_details di database, yang menyimpan informasi setiap item dalam suatu transaksi, termasuk transaction_id, product_id, jumlah, diskon, subtotal_harga.
  - Productcategory.php   : memodifikasi tabel product_categories di database, termasuk kolom seperti nama_kategori.
  - Discount.php          : memodifikasi tabel discounts (diskon) di database, termasuk kolom tanggal dan nominal.

- app/Database/Seeds - Menambah data ke tabel
  - ProductSeeder.php         : untuk mengisi tabel products dengan data produk awal atau data dummy (misalnya, beberapa item produk untuk ditampilkan di toko).
  - UserSeeder.php            : untuk mengisi tabel users dengan data pengguna awal atau dummy (misalnya, akun admin default atau beberapa akun pengguna uji).
  - ProductcategorySeeder.php : untuk mengisi tabel product_categories dengan data kategori produk awal atau dummy (misalnya, "Elektronik", "Pakaian", "Makanan").
  - DiscountSeeder.php        : untuk mengisi tabel discounts dengan data diskon awal atau dummy, seperti 10 data diskon untuk 9 hari ke depan.

- app/Models - Model untuk interaksi database
  - ProductModel.php            : Model untuk berinteraksi dengan tabel products di database (untuk operasi CRUD pada data produk).
  - UserModel.php               : Model untuk berinteraksi dengan tabel users di database
  - TransactionModel.php        : Model untuk berinteraksi dengan tabel transactions di database (untuk mengelola data transaksi pembelian).
  - TransactionDetailModel.php  : Model untuk berinteraksi dengan tabel transaction_details di database (untuk mengelola detail item dalam setiap transaksi).
  - KategoriProdukModel.php     : Model untuk berinteraksi dengan tabel product_categories di database (untuk mengelola kategori-kategori produk).
  - DiscountModel.php           : Model untuk berinteraksi dengan tabel discounts di database (untuk mengelola data diskon harian).

- app/Views - Template dan komponen UI
  - v_produk.php          : Tampilan produk
  - v_keranjang.php       : Halaman keranjang
  - v_checkout.php        : Halaman checkout
  - v_contact.php         : Halaman Kontak
  - v_discount.php        : Halaman Diskon
  - v_faq.php             : Halaman faq
  - v_home.php            : Tampilan Home
  - v_kategoriproduk.php  : Tampilan Kategori Produk
  - v_login.php           : Halaman Login
  - v_produkPDF.php       : Tampilan Download Data
  - v_profile.php         : Halaman Detail Transaksi
  
  
- public/img - Gambar produk dan aset
- public/NiceAdmin - Template admin
- public/dashboard-toko : Tampilan dashboard transaksi pembeli
