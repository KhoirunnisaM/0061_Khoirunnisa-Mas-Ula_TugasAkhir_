<?php

namespace App\Models;

use CodeIgniter\Model;

class Pembelian extends Model
{
    protected $table            = 'pembelian';
    protected $primaryKey       = 'id_pembelian';
    protected $allowedFields    = ['id_pembelian', 'tgl_pembelian', 'id_supplier', 'id_user'];

    // Dates
    protected $useTimestamps = false;
}
