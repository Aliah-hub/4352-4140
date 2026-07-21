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
            return redirect()->to('/logout')->with('error', 'Votre session a expire.');
        }

        $typeParam = (string) $this->request->getGet('type');

        return view('client/operations', [
            'types'     => $types,
            'client'    => $client,
            'typeParam' => $typeParam,
        ]);
    }

    public function effectuer()
    {
        $clientId   = (int) session()->get('client_id');
        $typeCode   = (string) $this->request->getPost('type_code');
        $montant_initial = (float) $this->request->getPost('montant');
        $destinataire_str = trim((string) $this->request->getPost('destinataire'));
        $inclure_frais_retrait = (bool) $this->request->getPost('inclure_frais_retrait');

        if ($montant_initial <= 0) {
            return redirect()->back()->with('error', 'Le montant doit etre superieur a 0.');
        }

        $typeModel = new TypeOperationModel();
        $type = $typeModel->findByCode($typeCode);

        if ($type === null) {
            return redirect()->back()->with('error', 'Type d\'operation invalide.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expire.');
        }

        $baremeModel = new BaremeModel();
        
        $operateur_nom = 'Yas';

        $soldeAvant = (float) $client['solde'];

        if ($typeCode === 'depot' || $typeCode === 'retrait') {
            $frais = $baremeModel->calculerFrais((int) $type['id'], $montant_initial, $operateur_nom);
            $soldeApres = $soldeAvant;

            if ($typeCode === 'depot') {
                $soldeApres = $soldeAvant + $montant_initial;
            } elseif ($typeCode === 'retrait') {
                if ($soldeAvant < $montant_initial + $frais) {
                    return redirect()->back()->with('error', 'Solde insuffisant (montant + frais = ' . number_format($montant_initial + $frais, 0, ',', ' ') . ' Ar).');
                }
                $soldeApres = $soldeAvant - $montant_initial - $frais;
            }

            $clientModel->mettreAJourSolde($clientId, $soldeApres);

            $operationModel = new OperationModel();
            $operationModel->insert([
                'client_id'         => $clientId,
                'type_operation_id' => $type['id'],
                'montant'           => $montant_initial,
                'frais'             => $frais,
                'solde_avant'       => $soldeAvant,
                'solde_apres'       => $soldeApres,
                'destinataire'      => null,
                'description'       => ucfirst($typeCode) . ' de ' . number_format($montant_initial, 0, ',', ' ') . ' Ar',
                'created_at'        => date('Y-m-d H:i:s'),
            ]);

            $message = 'Operation effectuee. Nouveau solde : ' . number_format($soldeApres, 0, ',', ' ') . ' Ar.';
            if ($frais > 0) $message .= ' (Frais : ' . number_format($frais, 0, ',', ' ') . ' Ar)';
            return redirect()->to('/client/dashboard')->with('success', $message);
        }

        if ($typeCode === 'transfert') {
            $destinataires_raw = explode(',', $destinataire_str);
            $destinataires = [];
            foreach ($destinataires_raw as $d) {
                $d = trim($d);
                if ($d !== '') $destinataires[] = $d;
            }

            if (count($destinataires) === 0) {
                return redirect()->back()->with('error', 'Le numero du destinataire est obligatoire.');
            }

            $montant_par_destinataire = floor($montant_initial / count($destinataires));
            $promo_meme_operateur_pct = (float) ($configModel-> getValeur('promotion_transfert_meme_operateur') ?? 0);

            $prefixeModel = new PrefixeModel();
            $configModel = new \App\Models\ConfigModel();
            $comm_externe_pct = (float) ($configModel->getValeur('commission_transfert_externe') ?? 0);

            $frais_total = 0;
            $montant_total_a_debiter = 0;
            $operations_a_faire = [];

            $cleanTelExp = str_replace('+261', '0', $client['telephone']);
            $prefixExp = substr($cleanTelExp, 0, 3);
            $opExp = 'Yas';
            if (in_array($prefixExp, ['032', '037'])) $opExp = 'Orange';
            if (in_array($prefixExp, ['033', '035'])) $opExp = 'Airtel';

            foreach ($destinataires as $dest) {
                if (! $prefixeModel->estValide($dest)) {
                    return redirect()->back()->with('error', "Numero destinataire invalide : $dest");
                }
                if ($dest === $client['telephone']) {
                    return redirect()->back()->with('error', 'Vous ne pouvez pas vous transferer a vous-même.');
                }
                
                if ($is_inter){
                    $frais_transfert += $montant_recu * ($comm_externe_pct / 100);
                }elseif ($promo_meme_operateur_pct > 0){
                    $frais_transfert -= $frais_transfert * ($promo_meme_operateur_pct /100);
                }
                
                $cleanTelDest = str_replace('+261', '0', $dest);
                $prefixDest = substr($cleanTelDest, 0, 3);
                $opDest = 'Yas';
                if (in_array($prefixDest, ['032', '037'])) $opDest = 'Orange';
                if (in_array($prefixDest, ['033', '035'])) $opDest = 'Airtel';

                $is_inter = ($opExp !== $opDest);

                $montant_recu = $montant_par_destinataire;
                
                if ($inclure_frais_retrait) {
                    $typeRetrait = $typeModel->findByCode('retrait');
                    $frais_retrait = $baremeModel->calculerFrais((int) $typeRetrait['id'], $montant_recu, 'Yas');
                    $montant_recu += $frais_retrait;
                }

                $frais_transfert = $baremeModel->calculerFrais((int) $type['id'], $montant_recu, 'Yas');

                if ($is_inter) {
                    $frais_transfert += $montant_recu * ($comm_externe_pct / 100);
                }
                
                $frais_total += $frais_transfert;
                $montant_total_a_debiter += $montant_recu;
                
                $operations_a_faire[] = [
                    'dest' => $dest,
                    'montant_recu' => $montant_recu,
                    'frais_transfert' => $frais_transfert,
                    'is_inter' => $is_inter,
                ];
            }
            
            if ($soldeAvant < $montant_total_a_debiter + $frais_total) {
                 return redirect()->back()->with('error', 'Solde insuffisant pour ce(s) transfert(s).');
            }
            
            $soldeActuel = $soldeAvant;
            foreach ($operations_a_faire as $op_data) {
                $soldeApres = $soldeActuel - $op_data['montant_recu'] - $op_data['frais_transfert'];
                
                $clientDest = $clientModel->trouverOuCreer($op_data['dest']);
                $soldeDestAvant = (float) $clientDest['solde'];
                $soldeDestApres = $soldeDestAvant + $op_data['montant_recu'];
                $clientModel->mettreAJourSolde((int) $clientDest['id'], $soldeDestApres);
                
                $typeTransfert = $typeModel->findByCode('transfert');
                $operationModelDest = new OperationModel();
                $operationModelDest->insert([
                    'client_id'         => (int) $clientDest['id'],
                    'type_operation_id' => (int) $typeTransfert['id'],
                    'montant'           => $op_data['montant_recu'],
                    'frais'             => 0,
                    'solde_avant'       => $soldeDestAvant,
                    'solde_apres'       => $soldeDestApres,
                    'destinataire'      => $client['telephone'],
                    'description'       => 'Reception de ' . $client['telephone'] . ' — ' . number_format($op_data['montant_recu'], 0, ',', ' ') . ' Ar',
                    'created_at'        => date('Y-m-d H:i:s'),
                ]);
                
                $operationModel = new OperationModel();
                $operationModel->insert([
                    'client_id'         => $clientId,
                    'type_operation_id' => $type['id'],
                    'montant'           => $op_data['montant_recu'],
                    'frais'             => $op_data['frais_transfert'],
                    'solde_avant'       => $soldeActuel,
                    'solde_apres'       => $soldeApres,
                    'destinataire'      => $op_data['dest'],
                    'description'       => 'Transfert vers ' . $op_data['dest'] . ($op_data['is_inter'] ? ' (Inter-operateur)' : ''),
                    'created_at'        => date('Y-m-d H:i:s'),
                ]);
                
                $soldeActuel = $soldeApres;
            }
            
            $clientModel->mettreAJourSolde($clientId, $soldeActuel);
            
            return redirect()->to('/client/dashboard')->with('success', 'Transfert(s) effectue(s) avec succès. Nouveau solde : ' . number_format($soldeActuel, 0, ',', ' ') . ' Ar.');
        }

        return redirect()->back()->with('error', 'Type d\'operation non reconnu.');
    }

    public function historique()
    {
        $clientId       = (int) session()->get('client_id');
        $operationModel = new OperationModel();
        $clientModel    = new ClientModel();

        $operations = $operationModel->getHistoriqueClient($clientId);
        $client     = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expire.');
        }

        return view('client/historique', [
            'operations' => $operations,
            'client'     => $client,
        ]);
    }
}
