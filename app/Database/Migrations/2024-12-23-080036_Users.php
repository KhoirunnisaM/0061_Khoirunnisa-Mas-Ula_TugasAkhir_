<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
       
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,  
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', 
                'unique'     => true,  
            ],
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',   
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', 
            ],
            'alamat' => [
                'type'       => 'TEXT',  
            ],
            'hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',  
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',   
                'null'       => true,  
            ],
            'level' => [
                'type'       => 'ENUM', 
                'constraint' => ['admin', 'pegawai'], 
            ],
            'active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,  
            ],
            'last_login' => [
                'type'       => 'DATETIME', 
                'null'       => true,  
            ],
        ]);

      
        $this->forge->addPrimaryKey('id_user');

        
        $this->forge->createTable('user');
    }

    public function down()
    {
        
        $this->forge->dropTable('user');
    }
}
