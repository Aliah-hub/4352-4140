<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\OperationModel;
use App\Models\TypeOperationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $clientModel    = new ClientModel();
        $operationModel = new OperationModel();

        $tousClients = $clientModel->findAll();
        $toutesOps   = $operationModel->getToutesAvecDetails();

        $total_clients = count($tousClients);
        $total_operations = count($toutesOps);
        $total_gains = array_sum(array_column($toutesOps, 'frais'));

        $dernieres = array_slice($toutesOps, 0, 10);

        return view('operateur/dashboard', [
            'stats'     => [
                'total_clients'    => $total_clients,
                'total_operations' => $total_operations,
                'total_gains'      => $total_gains,
            ],
            'dernieres' => $dernieres,
        ]);
    }
}
