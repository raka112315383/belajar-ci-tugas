<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait; // Pastikan ini di-use

use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ApiController extends ResourceController
{
    use ResponseTrait; // Pastikan ini di-use

    protected $apiKey;
    protected $user;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        $this->apiKey = env('API_KEY'); // Pastikan API_KEY ada di .env
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $headers = $this->request->headers();

        // Convert header objects to string values
        array_walk($headers, function (&$value, $key) {
            $value = $value->getValue();
        });

        // Check if 'Key' header exists and matches the API key
        if(array_key_exists("Key", $headers) && $headers["Key"] == $this->apiKey){
            $penjualan = $this->transaction->findAll();
            
            $processedPenjualan = [];
            foreach ($penjualan as $pj) {
                $details = $this->transaction_detail->where('transaction_id', $pj['id'])->findAll();
                
                $totalItems = 0;
                foreach ($details as $detail) {
                    $totalItems += $detail['jumlah']; // Menjumlahkan 'jumlah' dari setiap item detail
                }

                // Tambahkan 'total_items' ke array transaksi
                $pj['total_items'] = $totalItems;
                $pj['details'] = $details; // Tetap sertakan detail jika diperlukan di frontend

                $processedPenjualan[] = $pj;
            }

            $data['status'] = ["code" => 200, "description" => "OK"];
            $data['results'] = $processedPenjualan; // Gunakan array yang sudah diproses
        } else {
            // Jika API Key tidak cocok atau tidak ada
            $data['status'] = ["code" => 401, "description" => "Unauthorized: Invalid API Key"];
        }

        return $this->respond($data);
    }

    public function show($id = null)
    {
        // ... (kode show Anda, tidak ada perubahan di sini)
    }

    public function new()
    {
        // ... (kode new Anda, tidak ada perubahan di sini)
    }

    public function create()
    {
        // ... (kode create Anda, tidak ada perubahan di sini)
    }

    public function edit($id = null)
    {
        // ... (kode edit Anda, tidak ada perubahan di sini)
    }

    public function update($id = null)
    {
        // ... (kode update Anda, tidak ada perubahan di sini)
    }

    public function delete($id = null)
    {
        // ... (kode delete Anda, tidak ada perubahan di sini)
    }
}