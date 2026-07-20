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
            return redirect()->to('/logout')->with('error', 'Votre session a expiré ou le compte a été supprimé.');
        }

        $operations = $operationModel->getHistoriqueClient($clientId);

        $dernieres = array_slice($operations, 0, 5);

        return view('client/dashboard', [
            'client'    => $client,
            'dernieres' => $dernieres,
        ]);
    }
}
