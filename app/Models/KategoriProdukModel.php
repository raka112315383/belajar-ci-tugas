<?php 
namespace App\Models;

use CodeIgniter\Model;

class KategoriProdukModel extends Model
{
	protected $table = 'productcategory'; 
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'id','nama_kategori','nama_product','deskripsi'
	];  
}