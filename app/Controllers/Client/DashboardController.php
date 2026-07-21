<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\OperationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $clientId = (int) session()->get('client_id');

        $clientModel    = new ClientModel();
        $operationModel = new OperationModel();

        $client = $clientModel->find($clientId);

        if ($client === null) {
            return redirect()->to('/logout')->with('error', 'Votre session a expire ou le compte a ete supprime.');
        }

        $operations = $operationModel->getHistoriqueClient($clientId);

        $dernieres = array_slice($operations, 0, 5);

        $epargneModel = new \App\Models\EpargneModel();
        $epargne = $epargneModel->getParClient($clientId);

        return view('client/dashboard', [
            'client'    => $client,
            'dernieres' => $dernieres,
            'epargne'   => $epargne,
        ]);
    }
}
