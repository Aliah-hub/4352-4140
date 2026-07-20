<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table      = 'baremes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['operateur_nom', 'type_operation_id', 'montant_min', 'montant_max', 'frais'];

    public function getPourType(int $typeId, string $operateur_nom = null)
    {
        if ($operateur_nom !== null) {
            $this->where('operateur_nom', $operateur_nom);
        }
        return $this->where('type_operation_id', $typeId)
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }

    public function calculerFrais(int $typeId, float $montant, string $operateur_nom = 'Yas'): float
    {
        $bareme = $this->where('type_operation_id', $typeId)
                       ->where('operateur_nom', $operateur_nom)
                       ->where('montant_min <=', $montant)
                       ->where('montant_max >=', $montant)
                       ->first();

        if ($bareme === null) {
            return 0;
        }
        return (float) $bareme['frais'];
    }
}
