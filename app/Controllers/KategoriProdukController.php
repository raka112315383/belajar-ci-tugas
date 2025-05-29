<?php

namespace App\Controllers;

use App\Models\KategoriProdukModel;

class KategoriProdukController extends BaseController
{
    protected $Productcategory; 

    function __construct()
    {
        $this->Productcategory = new KategoriProdukModel();
    }

    public function index()
    {
        $Productcategory = $this->Productcategory->findAll();
        $data['productcategory'] = $Productcategory;

        return view('v_kategoriproduk', $data);
    }

    public function create()
    {

    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'nama_product' => $this->request->getPost('nama_product'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'created_at' => date("Y-m-d H:i:s")
    ];


    $this->Productcategory->insert($dataForm);

    return redirect('kategoriproduk')->with('success', 'Data Berhasil Ditambah');
    }
    
    public function edit($id)
{
    $dataproductcategory = $this->Productcategory->find($id);
    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'nama_product' => $this->request->getPost('nama_product'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'updated_at' => date("Y-m-d H:i:s")
    ];

    

    $this->Productcategory->update($id, $dataForm);

    return redirect('kategoriproduk')->with('success', 'Data Berhasil Diubah');
}

public function delete($id)
{
    $dataproductcategory = $this->Productcategory->find($id);

    $this->Productcategory->delete($id);

    return redirect('kategoriproduk')->with('success', 'Data Berhasil Dihapus');
}
}