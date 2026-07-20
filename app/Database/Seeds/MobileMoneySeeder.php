<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MobileMoneySeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // ─── Compte opérateur ─────────────────────────────────
        $this->db->table('operateur')->insert([
            'nom'        => 'Opérateur',
            'password'   => 'admin123',
            'created_at' => $now,
        ]);

        // ─── Préfixes valides ─────────────────────────────────
        $prefixes = ['032', '033', '034', '035', '037', '038', '+261', '0202', '0205', '0206', '0207', '0208', '0209'];
        foreach ($prefixes as $p) {
            $this->db->table('prefixes')->insert([
                'valeur'     => $p,
                'actif'      => 1,
                'created_at' => $now,
            ]);
        }

        // ─── Types d'opérations ───────────────────────────────
        $this->db->table('type_operations')->insertBatch([
            ['code' => 'depot',     'libelle' => 'Dépôt',     'actif' => 1],
            ['code' => 'retrait',   'libelle' => 'Retrait',   'actif' => 1],
            ['code' => 'transfert', 'libelle' => 'Transfert', 'actif' => 1],
        ]);

        // Récupérer les IDs
        $idDepot     = $this->db->table('type_operations')->where('code', 'depot')->get()->getRow('id');
        $idRetrait   = $this->db->table('type_operations')->where('code', 'retrait')->get()->getRow('id');
        $idTransfert = $this->db->table('type_operations')->where('code', 'transfert')->get()->getRow('id');

        // ─── Barèmes Retrait (frais facturés au client) ───────
        // Exemple donné dans le sujet
        $baremes = [
            ['montant_min' => 100,       'montant_max' => 1000,     'frais' => 50],
            ['montant_min' => 1001,      'montant_max' => 5000,     'frais' => 50],
            ['montant_min' => 5001,      'montant_max' => 10000,    'frais' => 100],
            ['montant_min' => 10001,     'montant_max' => 25000,    'frais' => 200],
            ['montant_min' => 25001,     'montant_max' => 50000,    'frais' => 400],
            ['montant_min' => 50001,     'montant_max' => 100000,   'frais' => 800],
            ['montant_min' => 100001,    'montant_max' => 250000,   'frais' => 1500],
            ['montant_min' => 250001,    'montant_max' => 500000,   'frais' => 1500],
            ['montant_min' => 500001,    'montant_max' => 1000000,  'frais' => 2500],
            ['montant_min' => 1000001,   'montant_max' => 2000000,  'frais' => 3000],
        ];

        foreach ($baremes as $b) {
            // Retrait
            $this->db->table('baremes')->insert(array_merge($b, ['type_operation_id' => (int) $idRetrait]));
            // Transfert (mêmes frais que retrait dans l'exemple)
            $this->db->table('baremes')->insert(array_merge($b, ['type_operation_id' => (int) $idTransfert]));
        }

        // Dépôt : gratuit (pas de barème = frais = 0)

        // ─── Clients de test ──────────────────────────────────
        $this->db->table('clients')->insertBatch([
            ['telephone' => '0321234567', 'nom' => 'Alice',  'solde' => 150000, 'actif' => 1, 'created_at' => $now],
            ['telephone' => '0331234567', 'nom' => 'Bob',    'solde' => 80000,  'actif' => 1, 'created_at' => $now],
        ]);
    }
}
