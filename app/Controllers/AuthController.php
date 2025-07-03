<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DiscountModel; // Import model diskon
use CodeIgniter\I18n\Time; // Untuk mendapatkan tanggal hari ini

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;

    function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        // Jika ada POST request (form login disubmit)
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]', // Ubah: Hapus '|numeric' karena password bisa berupa string campuran
            ];

            // Set custom messages for validation
            $messages = [
                'username' => [
                    'required'   => 'Username harus diisi.',
                    'min_length' => 'Username minimal 6 karakter.',
                ],
                'password' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => 'Password minimal 7 karakter.',
                    // 'numeric'    => 'Password harus berupa angka.', // Pesan ini tidak relevan jika numeric dihapus
                ],
            ];
        
            if ($this->validate($rules, $messages)) { // Teruskan $messages ke validate
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');
        
                $dataUser = $this->user->where(['username' => $username])->first();
        
                if ($dataUser) {
                    // Pastikan password di database di-hash dengan password_hash()
                    if (password_verify($password, $dataUser['password'])) {
                        // Login Berhasil!
                        session()->set([
                            'username'   => $dataUser['username'],
                            'role'       => $dataUser['role'],
                            'isLoggedIn' => TRUE
                        ]);

                        // --- Bagian Penambahan Logika Diskon ---
                        $discountModel = new DiscountModel();
                        $today = Time::now('Asia/Jakarta')->toDateString(); // Menggunakan tanggal saat ini di Surabaya
                        
                        $discount = $discountModel->getDiscountByDate($today);

                        // Simpan nominal diskon ke session flashdata
                        if ($discount) {
                            session()->setFlashdata('discount_nominal', $discount['nominal']);
                        } else {
                            // Jika tidak ada diskon hari ini
                            session()->setFlashdata('discount_nominal', 0); // Diset 0 untuk indikasi 'tidak ada diskon'
                        }
                        // --- Akhir Bagian Penambahan Logika Diskon ---

                        return redirect()->to(base_url('/')); // Redirect ke halaman utama setelah login sukses
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }
        
        // Tampilkan halaman login form jika tidak ada POST request
        return view('v_login'); // Sesuaikan dengan nama view login Anda
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}