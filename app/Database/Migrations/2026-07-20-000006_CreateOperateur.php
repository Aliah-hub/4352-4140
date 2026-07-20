<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperateur extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('operateur');
    }

    public function down()
    {
        $this->forge->dropTable('operateur');
    }
}
