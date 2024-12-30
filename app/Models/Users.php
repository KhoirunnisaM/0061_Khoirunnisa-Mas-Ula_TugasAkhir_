<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = ['username', 'password', 'fullname', 'alamat', 'hp', 'foto', 'level', 'active', 'last_login'];

    // Dates
    protected $useTimestamps = false;
}
