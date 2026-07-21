<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\OperationModel;

class ClientsController extends BaseController
{
    public function index()
    {
        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        return view('operateur/clients', [
            'clients' => $clients,
        ]);
    }

    public function show(int $id)
    {
        $clientModel    = new ClientModel();
        $operationModel = new OperationModel();

        $client     = $clientModel->find($id);
        $operations = $operationModel->getHistoriqueClient($id);

        if ($client === null) {
            return redirect()->back()->with('error', 'Client introuvable.');
        }

        return view('operateur/client_detail', [
            'client'     => $client,
            'operations' => $operations,
        ]);
    }
    public function updateTauxEpargne(){
        
    }
}
