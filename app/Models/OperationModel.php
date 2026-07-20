<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table      = 'operations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'client_id', 'type_operation_id', 'montant',
        'frais', 'solde_avant', 'solde_apres',
        'destinataire', 'description', 'created_at'
    ];

    public function getHistoriqueClient(int $clientId)
    {
        return $this->select('operations.*, type_operations.libelle AS type_libelle')
                    ->join('type_operations', 'type_operations.id = operations.type_operation_id')
                    ->where('operations.client_id', $clientId)
                    ->orderBy('operations.id', 'DESC')
                    ->findAll();
    }

    public function totalFraisParType()
    {
        return $this->select('type_operations.libelle, SUM(operations.frais) AS total_frais, COUNT(operations.id) AS nb')
                    ->join('type_operations', 'type_operations.id = operations.type_operation_id')
                    ->groupBy('operations.type_operation_id')
                    ->findAll();
    }
    public function totalFraisGeneral(): float
    {
        $row = $this->selectSum('frais')->first();
        return $row ? (float) $row['frais'] : 0;
    }

    public function getToutesAvecDetails()
    {
        return $this->select('operations.*, type_operations.libelle AS type_libelle, clients.telephone AS client_telephone')
                    ->join('type_operations', 'type_operations.id = operations.type_operation_id')
                    ->join('clients', 'clients.id = operations.client_id')
                    ->orderBy('operations.id', 'DESC')
                    ->findAll();
    }
}
