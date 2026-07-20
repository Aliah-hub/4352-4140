<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperationModel extends Model
{
    protected $table      = 'type_operations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['code', 'libelle', 'actif'];

    public function getActifs()
    {
        return $this->where('actif', 1)->findAll();
    }

    public function findByCode(string $code)
    {
        return $this->where('code', $code)->first();
    }
}
