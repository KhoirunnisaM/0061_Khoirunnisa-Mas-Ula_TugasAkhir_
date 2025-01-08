<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model
{
    protected $table            = 'supplier';
    protected $primaryKey       = 'id_supplier';
    protected $allowedFields    = ['id_supplier', 'nama_supplier', 'alamat', 'telp'];

    protected $useTimestamps = false;
}
