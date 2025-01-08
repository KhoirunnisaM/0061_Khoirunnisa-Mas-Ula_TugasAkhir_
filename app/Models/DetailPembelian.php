<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembelian extends Model
{
    protected $table            = 'detail_pembelian';
    protected $allowedFields    = ['id_pembelian', 'kode_barang', 'qty', 'harga'];

    // Dates
    protected $useTimestamps = false;
}
