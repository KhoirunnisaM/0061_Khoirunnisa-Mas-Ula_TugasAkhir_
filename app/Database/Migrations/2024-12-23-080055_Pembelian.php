<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembelian extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id_pembelian' => [
                'type'       => 'CHAR',
                'constraint' => '35',
            ],
            'tgl_pembelian' => [
                'type'       => 'DATETIME',  
            ],
            'id_supplier' => [
                'type'       => 'CHAR',
                'constraint' => '35',
            ],
            'id_user' => [
                'type'       => 'INT',
                'unsigned'   => true,  
            ],
        ]);

     
        $this->forge->addPrimaryKey('id_pembelian');

        
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id_supplier', 'CASCADE', 'CASCADE');

       
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');

         
        $this->forge->createTable('pembelian');
    }

    public function down()
    {
      
        $this->forge->dropTable('pembelian');
    }
}
