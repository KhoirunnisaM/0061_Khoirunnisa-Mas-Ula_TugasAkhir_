<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPembelian extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id_pembelian' => [
                'type'       => 'CHAR',
                'constraint' => '35',
            ],
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',   
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => '11',  
            ],
            'harga' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',  
            ],
        ]);

      
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id_pembelian', 'CASCADE', 'CASCADE');

        
        $this->forge->addForeignKey('kode_barang', 'barang', 'kode_barang', 'CASCADE', 'CASCADE');

        
        $this->forge->createTable('detail_pembelian');
    }

    public function down()
    {
        
        $this->forge->dropTable('detail_pembelian');
    }
}
