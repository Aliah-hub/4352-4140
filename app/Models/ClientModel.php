<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'clients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['telephone', 'solde', 'actif', 'created_at'];

    public function findByTelephone(string $telephone)
    {
        return $this->where('telephone', $telephone)->first();
    }

    public function trouverOuCreer(string $telephone): array
    {
        $client = $this->findByTelephone($telephone);
        if ($client === null) {
            $id = $this->insert([
                'telephone'  => $telephone,
                'solde'      => 0,
                'actif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ], true);
            $client = $this->find($id);
        }
        return $client;
    }

    public function mettreAJourSolde(int $clientId, float $nouveauSolde): void
    {
        $this->update($clientId, ['solde' => $nouveauSolde]);
    }
}
