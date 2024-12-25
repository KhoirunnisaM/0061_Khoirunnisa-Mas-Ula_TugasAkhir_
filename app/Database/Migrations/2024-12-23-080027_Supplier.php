<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id_supplier' => [
                'type'       => 'CHAR',
                'constraint' => '35',
            ],
            'nama_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',  
            ],
            'alamat' => [
                'type'       => 'TEXT',  
            ],
            'telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',   
            ],
        ]);

         
        $this->forge->addPrimaryKey('id_supplier');

        
        $this->forge->createTable('supplier');
    }

    public function down()
    {
        
        $this->forge->dropTable('supplier');
    }
}
