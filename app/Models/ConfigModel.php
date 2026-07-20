<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cle', 'valeur', 'description'];

    public function getValeur(string $cle)
    {
        $row = $this->where('cle', $cle)->first();
        return $row ? $row['valeur'] : null;
    }
}
