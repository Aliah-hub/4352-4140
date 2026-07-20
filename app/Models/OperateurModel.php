<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table      = 'operateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'created_at'];

    public function findFirst()
    {
        return $this->first();
    }
}
