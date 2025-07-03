<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscountModel extends Model
{
    protected $table      = 'discount';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // Atau 'object'
    protected $useSoftDeletes = false; // Karena tidak ada kolom deleted_at

    protected $allowedFields = ['tanggal', 'nominal', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime'; // Sesuaikan dengan tipe kolom di DB (datetime atau date)
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes = true

    // Validation
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Metode untuk mencari diskon berdasarkan tanggal tertentu.
     *
     * @param string $date Tanggal dalam format YYYY-MM-DD
     * @return array|null Mengembalikan data diskon (array) atau null jika tidak ditemukan
     */
    public function getDiscountByDate(string $date)
    {
        return $this->where('tanggal', $date)->first();
    }
}