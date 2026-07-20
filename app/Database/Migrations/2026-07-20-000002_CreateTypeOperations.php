<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeOperations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => ['type' => 'INTEGER', 'auto_increment' => true],
            'code'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'libelle' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'actif'   => ['type' => 'INTEGER', 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('type_operations');
    }

    public function down()
    {
        $this->forge->dropTable('type_operations');
    }
}
