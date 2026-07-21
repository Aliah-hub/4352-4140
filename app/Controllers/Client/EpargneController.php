<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\EpargneModel;

class EpargneController extends BaseController
{
    public function index()
    {
        $clientId = (int) session()->get('client_id');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expiré.');
        }

        $epargneModel = new EpargneModel();
        $epargne = $epargneModel->getParClient($clientId);

        return view('client/epargne', [
            'client'  => $client,
            'epargne' => $epargne,
        ]);
    }

    public function action()
    {
        $clientId = (int) session()->get('client_id');
        $pourcentage = (float) $this->request->getPost('pourcentage');
        $typeAction = (string) $this->request->getPost('action_type');

        if ($pourcentage < 0 || $pourcentage > 100) {
            return redirect()->back()->with('error', 'Le pourcentage doit être entre 0 et 100.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        $epargneModel = new EpargneModel();
        $epargne = $epargneModel->getParClient($clientId);

        if (!$epargne) {
            $epargneModel->insert([
                'id_client' => $clientId,
                'pourcentage' => $pourcentage,
                'solde' => 0
            ]);
            $epargne = $epargneModel->getParClient($clientId);
        } else {
            $epargneModel->mettreAJourTaux($clientId, $pourcentage);
        }

        $soldePrincipal = (float) $client['solde'];
        $soldeEpargne = (float) $epargne['solde'];

        if ($typeAction === 'transferer') {
            $montantATransferer = $soldePrincipal * ($pourcentage / 100);

            if ($montantATransferer <= 0) {
                return redirect()->back()->with('error', 'Le montant à transférer est nul.');
            }

            if ($soldePrincipal < $montantATransferer) {
                return redirect()->back()->with('error', 'Solde insuffisant.');
            }

            $nouveauSoldePrincipal = $soldePrincipal - $montantATransferer;
            $nouveauSoldeEpargne = $soldeEpargne + $montantATransferer;

            $clientModel->mettreAJourSolde($clientId, $nouveauSoldePrincipal);
            $epargneModel->mettreAJourSolde($clientId, $nouveauSoldeEpargne);

            return redirect()->back()->with('success', 'Transfert vers l\'épargne réussi : ' . number_format($montantATransferer, 0, ',', ' ') . ' Ar.');
        }

        if ($typeAction === 'retirer') {
            $montantARetirer = $soldeEpargne * ($pourcentage / 100);

            if ($montantARetirer <= 0) {
                return redirect()->back()->with('error', 'Le montant à retirer est nul.');
            }

            if ($soldeEpargne < $montantARetirer) {
                return redirect()->back()->with('error', 'Solde d\'épargne insuffisant.');
            }

            $nouveauSoldeEpargne = $soldeEpargne - $montantARetirer;
            $nouveauSoldePrincipal = $soldePrincipal + $montantARetirer;

            $epargneModel->mettreAJourSolde($clientId, $nouveauSoldeEpargne);
            $clientModel->mettreAJourSolde($clientId, $nouveauSoldePrincipal);

            return redirect()->back()->with('success', 'Retrait de l\'épargne réussi : ' . number_format($montantARetirer, 0, ',', ' ') . ' Ar.');
        }

        return redirect()->back()->with('error', 'Action non reconnue.');
    }
}
