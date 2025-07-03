<?php

namespace App\Controllers;

use App\Models\DiscountModel;
use CodeIgniter\I18n\Time; // Untuk tanggal
use CodeIgniter\HTTP\ResponseInterface; // Untuk tipe hinting

class DiscountController extends BaseController
{
    protected $discountModel;

    public function __construct()
    {
        $this->discountModel = new DiscountModel();
        helper(['form', 'url']); // Pastikan helper form dan url dimuat
    }

    // Menampilkan daftar diskon
    public function index()
    {
        $data = [
            'title'   => 'Manajemen Diskon',
            'discount' => $this->discountModel->orderBy('tanggal', 'ASC')->findAll(),
            'validation' => \Config\Services::validation() // Untuk menampilkan error validasi
        ];
        return view('v_discount', $data); // Buat view ini nanti
    }

    // Menampilkan form tambah diskon (biasanya lewat modal)
    // Logika penambahan akan ada di method save()
    public function new()
    {
        $data = [
            'title' => 'Tambah Diskon',
            'validation' => \Config\Services::validation()
        ];
        // Jika Anda ingin modalnya langsung ada di halaman index dan di-toggle
        // Anda bisa skip method ini dan langsung merujuk ke modal di view index
        // Namun, jika ingin form sendiri, return view('discounts/create', $data);
        return redirect()->to(base_url('diskon')); // Redirect back to index with validation errors
    }

    // Menyimpan data diskon baru
    public function save()
    {
        $rules = [
            'tanggal' => [
                'rules' => 'required|valid_date[Y-m-d]|is_unique[discount.tanggal]',
                'errors' => [
                    'required'    => 'Tanggal harus diisi.',
                    'valid_date'  => 'Format tanggal tidak valid.',
                    'is_unique'   => 'Tanggal diskon ini sudah ada.' // Validasi tanggal unik
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

        $this->discountModel->save([
            'tanggal'    => $this->request->getPost('tanggal'),
            'nominal'    => $this->request->getPost('nominal'),
            'created_at' => Time::now(), // Otomatis oleh Model jika useTimestamps true
            'updated_at' => null // Otomatis oleh Model jika useTimestamps true
        ]);

        session()->setFlashdata('success', 'Diskon berhasil ditambahkan.');
        return redirect()->to(base_url('diskon'));
    }

    // Menampilkan data diskon untuk diedit (via modal)
    public function edit($id = null)
    {
        $discount = $this->discountModel->find($id);

        if (!$discount) {
            session()->setFlashdata('failed', 'Data diskon tidak ditemukan.');
            return redirect()->to(base_url('diskon'));
        }

        // Return data dalam format JSON jika dipanggil via AJAX untuk modal
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($discount);
        }

        // Jika tidak AJAX, mungkin untuk halaman edit terpisah
        $data = [
            'title'      => 'Edit Diskon',
            'discount'   => $discount,
            'validation' => \Config\Services::validation()
        ];
        return view('v_discount', $data); // Buat view ini nanti jika diperlukan halaman terpisah
    }

    // Memperbarui data diskon
    public function update($id = null)
    {
        // Ambil data lama untuk pengecekan unique pada tanggal jika tanggal tidak readonly
        // Karena tanggal readonly, kita tidak perlu cek is_unique lagi untuk field tanggal.
        // Cukup cek apakah id-nya valid.
        $oldDiscount = $this->discountModel->find($id);

        if (!$oldDiscount) {
            session()->setFlashdata('failed', 'Data diskon tidak ditemukan.');
            return redirect()->back();
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
        ];

        // Jika Anda ingin mengizinkan edit tanggal (tapi dengan validasi unik, kecuali tanggal itu sendiri)
        // Maka rule 'tanggal' harus dimodifikasi:
        // 'tanggal' => 'required|valid_date[Y-m-d]|is_unique[discounts.tanggal,id,{id}]'
        // Tapi karena instruksi "input untuk tanggal dibuat readonly", maka tanggal tidak perlu divalidasi unik lagi saat update.

        if (!$this->validate($rules)) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->discountModel->update($id, [
            'nominal'    => $this->request->getPost('nominal'),
            'updated_at' => Time::now() // Otomatis oleh Model jika useTimestamps true
        ]);

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