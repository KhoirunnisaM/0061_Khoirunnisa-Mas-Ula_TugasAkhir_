<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'kode_barang';
    protected $allowedFields    = ['kode_barang', 'nama_barang', 'brand', 'stok', 'harga', 'active'];

    // Dates
    protected $useTimestamps = false;
}
 