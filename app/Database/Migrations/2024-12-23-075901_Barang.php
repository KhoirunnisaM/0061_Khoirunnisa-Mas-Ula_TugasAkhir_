<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'brand' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default'    => 0, 
            ],
            'harga' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',  
                'default'    => 0.00,
            ],
            'active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,  
            ]
        ]);
        $this->forge->addPrimaryKey('kode_barang');

       
        $this->forge->createTable('barang');
    }

    public function down()
    {
        
        $this->forge->dropTable('barang');
    }
}
