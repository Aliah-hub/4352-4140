<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table      = 'prefixes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['valeur', 'actif', 'created_at'];

    public function getActifs()
    {
        return $this->where('actif', 1)->findAll();
    }
    public function estValide(string $telephone): bool
    {
        $prefixes = $this->getActifs();
        foreach ($prefixes as $p) {
            if (strpos($telephone, $p['valeur']) === 0) {
                return true;
            }
        }
        return false;
    }
}
