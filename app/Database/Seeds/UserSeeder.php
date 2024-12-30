<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname'   => 'Administrator',
                'alamat'     => 'Jl. Contoh No. 1',
                'hp'         => '081234567890',
                'foto'       => 'default.png',
                'level'      => 'admin',
                'active'     => 1,
                'last_login' => null,
            ],
        ];

        // Insert batch data ke tabel user
        $this->db->table('user')->insertBatch($data);
    }
}
