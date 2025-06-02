<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class ProductCategoryController extends BaseController
{
    protected $ProductCategory; 

    function __construct()
    {
        $this->ProductCategory = new ProductCategoryModel();
    }

    public function index()
    {
        $ProductCategory = $this->ProductCategory->findAll();
        $data['ProductCategory'] = $ProductCategory;

        return view('v_ProductCategory', $data);
    }

    public function create()
{
    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'created_at' => date("Y-m-d H:i:s") 
    ];

    $this->ProductCategory->insert($dataForm);

    return redirect('ProductCategory')->with('success', 'Data Berhasil Ditambah');
} 


    public function simpan()
{
    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'created_at' => date("Y-m-d H:i:s") 
    ];

    $this->ProductCategory->insert($dataForm);

    return redirect()->to('/ProductCategory');
} 

public function edit($id)
{
    $dataProduk = $this->ProductCategory->find($id);

    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'updated_at' => date("Y-m-d H:i:s")
    ];

    $this->ProductCategory->update($id, $dataForm);

    return redirect('ProductCategory')->with('success', 'Data Berhasil Diubah');
}

public function delete($id)
{
    $dataProduk = $this->ProductCategory->find($id);

    $this->ProductCategory->delete($id);

    return redirect('ProductCategory')->with('success', 'Data Berhasil Dihapus');
}
}