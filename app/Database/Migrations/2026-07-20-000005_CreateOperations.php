<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INTEGER', 'auto_increment' => true],
            'client_id'         => ['type' => 'INTEGER', 'null' => false],
            'type_operation_id' => ['type' => 'INTEGER', 'null' => false],
            'montant'           => ['type' => 'REAL', 'null' => false],
            'frais'             => ['type' => 'REAL', 'default' => 0],
            'solde_avant'       => ['type' => 'REAL', 'null' => false],
            'solde_apres'       => ['type' => 'REAL', 'null' => false],
            'destinataire'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'description'       => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('operations');
    }

    public function down()
    {
        $this->forge->dropTable('operations');
    }
}
