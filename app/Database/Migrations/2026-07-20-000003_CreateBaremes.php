<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaremes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INTEGER', 'auto_increment' => true],
            'type_operation_id' => ['type' => 'INTEGER', 'null' => false],
            'montant_min'       => ['type' => 'REAL', 'null' => false],
            'montant_max'       => ['type' => 'REAL', 'null' => false],
            'frais'             => ['type' => 'REAL', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('baremes');
    }

    public function down()
    {
        $this->forge->dropTable('baremes');
    }
}
