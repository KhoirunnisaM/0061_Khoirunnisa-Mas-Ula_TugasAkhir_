<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id_penjualan' => [
                'type'       => 'CHAR',
                'constraint' => '35',
            ],
            'nama_pembeli' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',  
            ],
            'tgl_penjualan' => [
                'type'       => 'DATETIME',  
            ],
            'id_user' => [
                'type'       => 'INT',
                'unsigned'   => true, 
            ],
        ]);

       
        $this->forge->addPrimaryKey('id_penjualan');

        
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');

        
        $this->forge->createTable('penjualan');
    }

    public function down()
    {
        
        $this->forge->dropTable('penjualan');
    }
}
