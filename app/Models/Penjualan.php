<?php

namespace App\Models;

use CodeIgniter\Model;

class Penjualan extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'id_penjualan';
    protected $allowedFields    = ['id_penjualan','nama_pembeli','tgl_penjualan','id_user'];

    // Dates
    protected $useTimestamps = false;
}
