<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'telephone'  => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => false],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'solde'      => ['type' => 'REAL', 'default' => 0],
            'actif'      => ['type' => 'INTEGER', 'default' => 1],
            'created_at' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
