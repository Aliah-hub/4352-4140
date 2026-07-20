<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrefixes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'valeur'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => false],
            'actif'      => ['type' => 'INTEGER', 'default' => 1],
            'created_at' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('prefixes');
    }

    public function down()
    {
        $this->forge->dropTable('prefixes');
    }
}
