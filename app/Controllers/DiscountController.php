<?php

namespace App\Controllers;

use App\Models\DiscountModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\ResponseInterface; // Tetap sertakan jika ada tipe hinting di tempat lain, tapi tidak kritis di sini

class DiscountController extends BaseController
{
    protected $discountModel;
    // Pindahkan helper ke __construct atau gunakan autoload di app/Config/Autoload.php
    // protected $helpers = ['form', 'url']; // Tidak perlu didefinisikan di sini jika sudah di __construct

    public function __construct()
    {
        $this->discountModel = new DiscountModel();
        helper(['form', 'url']); // Pastikan helper form dan url dimuat di constructor
    }

    // Menampilkan daftar diskon
    public function index()
    {
        $data = [
            'title'      => 'Manajemen Diskon',
            'discount'  => $this->discountModel->orderBy('tanggal', 'ASC')->findAll(), // Ubah 'discount' menjadi 'discounts' agar konsisten dengan view
            'validation' => \Config\Services::validation() // Untuk menampilkan error validasi
        ];
        return view('v_discount', $data); // Ubah 'v_discount' menjadi 'discounts/index'
    }

    // Metode 'new' tidak diperlukan jika Anda menggunakan modal di halaman index
    // public function new()
    // {
    //     // ...
    // }

    // Menyimpan data diskon baru
    public function save()
    {
        $rules = [
            'tanggal' => [
                // PERBAIKI: is_unique[discounts.tanggal] harus menggunakan NAMA TABEL SEBENARNYA
                'rules' => 'required|valid_date|is_unique[discount.tanggal]',
                'errors' => [
                    'required'   => 'Tanggal harus diisi.',
                    'valid_date' => 'Format tanggal tidak valid.',
                    'is_unique'  => 'Tanggal diskon ini sudah ada.'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required'     => 'Nominal diskon harus diisi.',
                    'numeric'      => 'Nominal diskon harus berupa angka.',
                    'greater_than' => 'Nominal diskon harus lebih besar dari 0.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        // Hapus created_at dan updated_at manual jika useTimestamps = true di model
        $this->discountModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            // 'created_at' dan 'updated_at' otomatis jika useTimestamps di model aktif
        ]);

        session()->setFlashdata('success', 'Diskon berhasil ditambahkan.');
        return redirect()->to(base_url('diskon'));
    }

    // Menampilkan data diskon untuk diedit (via modal AJAX)
    public function edit($id = null)
    {
        $discount = $this->discountModel->find($id);

        if (!$discount) {
            // Mengembalikan JSON error jika request AJAX
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Data diskon tidak ditemukan.']);
            }
            // Mengembalikan redirect jika bukan AJAX (misal: diakses langsung)
            session()->setFlashdata('failed', 'Data diskon tidak ditemukan.');
            return redirect()->to(base_url('diskon'));
        }

        // Return data dalam format JSON jika dipanggil via AJAX untuk modal
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($discount);
        }

        // Bagian ini umumnya tidak terpanggil jika edit via modal
        // $data = [
        //     'title'      => 'Edit Diskon',
        //     'discount'   => $discount,
        //     'validation' => \Config\Services::validation()
        // ];
        // return view('v_discount', $data);
    }

    // Memperbarui data diskon
    public function update($id = null)
    {
        // Ambil data diskon yang lama
        $oldDiscount = $this->discountModel->find($id);

        if (!$oldDiscount) {
            session()->setFlashdata('failed', 'Data diskon tidak ditemukan.');
            return redirect()->back(); // Gunakan redirect()->back() untuk kembali ke halaman sebelumnya
        }

        $rules = [
            'nominal' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required'     => 'Nominal diskon harus diisi.',
                    'numeric'      => 'Nominal diskon harus berupa angka.',
                    'greater_than' => 'Nominal diskon harus lebih besar dari 0.'
                ]
            ],
            // Tanggal readonly di frontend, jadi tidak perlu validasi tanggal di sini
            // Jika tanggal bisa diubah, tambahkan validasi 'tanggal' di sini
            // dan gunakan 'is_unique[discounts.tanggal,id,{id}]' untuk pengecualian
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            // Anda bisa tambahkan flashdata lain untuk menandai modal edit yang mana yang harus terbuka
            // session()->setFlashdata('edit_modal_id', $id);
            return redirect()->back()->withInput();
        }

        // Data yang akan diupdate
        $dataToUpdate = [
            'nominal' => $this->request->getPost('nominal'),
            // 'updated_at' otomatis jika useTimestamps = true di model
        ];

        // Lakukan update data
        $this->discountModel->update($id, $dataToUpdate);

        session()->setFlashdata('success', 'Diskon berhasil diperbarui.');
        return redirect()->to(base_url('diskon'));
    }

    // Menghapus data diskon
    public function delete($id = null)
    {
        $discount = $this->discountModel->find($id);

        if (!$discount) {
            session()->setFlashdata('failed', 'Data diskon tidak ditemukan.');
            return redirect()->to(base_url('diskon'));
        }

        $this->discountModel->delete($id);

        session()->setFlashdata('success', 'Diskon berhasil dihapus.');
        return redirect()->to(base_url('diskon'));
    }
}