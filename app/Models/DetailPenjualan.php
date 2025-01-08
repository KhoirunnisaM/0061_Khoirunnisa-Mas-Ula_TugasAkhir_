<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenjualan extends Model
{
    protected $table            = 'detail_penjualan';
    protected $allowedFields    = ['id_penjualan', 'kode_barang', 'qty', 'harga'];

    // Dates
    protected $useTimestamps = false;
}
