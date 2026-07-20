<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\OperationModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeModel;
use App\Models\PrefixeModel;

class OperationController extends BaseController
{
    public function formulaire()
    {
        $typeModel = new TypeOperationModel();
        $types     = $typeModel->getActifs();

        $clientId    = (int) session()->get('client_id');
        $clientModel = new ClientModel();
        $client      = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expiré.');
        }

        return view('client/operations', [
            'types'  => $types,
            'client' => $client,
        ]);
    }

    public function effectuer()
    {
        $clientId   = (int) session()->get('client_id');
        $typeCode   = (string) $this->request->getPost('type_code');
        $montant    = (float) $this->request->getPost('montant');
        $destinataire = trim((string) $this->request->getPost('destinataire'));

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $typeModel = new TypeOperationModel();
        $type = $typeModel->findByCode($typeCode);

        if ($type === null) {
            return redirect()->back()->with('error', 'Type d\'opération invalide.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expiré.');
        }

        $baremeModel = new BaremeModel();
        
        $cleanTel = str_replace('+261', '0', $client['telephone']);
        $prefix = substr($cleanTel, 0, 3);
        $operateur_nom = 'Yas';
        if (in_array($prefix, ['033', '035'])) {
            $operateur_nom = 'Airtel';
        } elseif (in_array($prefix, ['032', '037'])) {
            $operateur_nom = 'Orange';
        }

        $frais = $baremeModel->calculerFrais((int) $type['id'], $montant, $operateur_nom);

        $soldeAvant = (float) $client['solde'];
        $soldeApres = $soldeAvant;

        if ($typeCode === 'depot') {
            $soldeApres = $soldeAvant + $montant;

        } elseif ($typeCode === 'retrait') {
            if ($soldeAvant < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant (montant + frais = ' . number_format($montant + $frais, 0, ',', ' ') . ' Ar).');
            }
            $soldeApres = $soldeAvant - $montant - $frais;

        } elseif ($typeCode === 'transfert') {
            if ($destinataire === '') {
                return redirect()->back()->with('error', 'Le numéro du destinataire est obligatoire.');
            }

            $prefixeModel = new PrefixeModel();
            if (! $prefixeModel->estValide($destinataire)) {
                return redirect()->back()->with('error', 'Numéro destinataire invalide pour cet opérateur.');
            }

            if ($destinataire === $client['telephone']) {
                return redirect()->back()->with('error', 'Vous ne pouvez pas vous transférer à vous-même.');
            }

            if ($soldeAvant < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant (montant + frais = ' . number_format($montant + $frais, 0, ',', ' ') . ' Ar).');
            }

            $soldeApres = $soldeAvant - $montant - $frais;

            $clientDest = $clientModel->trouverOuCreer($destinataire);
            $soldeDestAvant = (float) $clientDest['solde'];
            $soldeDestApres = $soldeDestAvant + $montant;
            $clientModel->mettreAJourSolde((int) $clientDest['id'], $soldeDestApres);

            // Enregistrer la réception dans l'historique du destinataire
            $typeTransfert = $typeModel->findByCode('transfert');
            $operationModelDest = new OperationModel();
            $operationModelDest->insert([
                'client_id'         => (int) $clientDest['id'],
                'type_operation_id' => (int) $typeTransfert['id'],
                'montant'           => $montant,
                'frais'             => 0,
                'solde_avant'       => $soldeDestAvant,
                'solde_apres'       => $soldeDestApres,
                'destinataire'      => $client['telephone'],
                'description'       => 'Réception de ' . $client['telephone'] . ' — ' . number_format($montant, 0, ',', ' ') . ' Ar',
                'created_at'        => date('Y-m-d H:i:s'),
            ]);

        } else {
            return redirect()->back()->with('error', 'Type d\'opération non reconnu.');
        }

        $clientModel->mettreAJourSolde($clientId, $soldeApres);

        $operationModel = new OperationModel();
        $operationModel->insert([
            'client_id'         => $clientId,
            'type_operation_id' => $type['id'],
            'montant'           => $montant,
            'frais'             => $frais,
            'solde_avant'       => $soldeAvant,
            'solde_apres'       => $soldeApres,
            'destinataire'      => ($typeCode === 'transfert') ? $destinataire : null,
            'description'       => ucfirst($typeCode) . ' de ' . number_format($montant, 0, ',', ' ') . ' Ar',
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        $message = 'Opération effectuée. Nouveau solde : ' . number_format($soldeApres, 0, ',', ' ') . ' Ar.';
        if ($frais > 0) {
            $message .= ' (Frais : ' . number_format($frais, 0, ',', ' ') . ' Ar)';
        }

        return redirect()->to('/client/dashboard')->with('success', $message);
    }

    public function historique()
    {
        $clientId       = (int) session()->get('client_id');
        $operationModel = new OperationModel();
        $clientModel    = new ClientModel();

        $operations = $operationModel->getHistoriqueClient($clientId);
        $client     = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expiré.');
        }

        return view('client/historique', [
            'operations' => $operations,
            'client'     => $client,
        ]);
    }
}
