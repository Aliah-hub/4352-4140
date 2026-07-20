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
        $typeModel      = new TypeOperationModel();

        $stats = [
            'total_clients'    => $clientModel->countAllResults(),
            'total_operations' => $operationModel->countAllResults(),
            'total_gains'      => $operationModel->totalFraisGeneral(),
        ];

        $dernieres = $operationModel->getToutesAvecDetails();
        $dernieres = array_slice($dernieres, 0, 10);

        return view('operateur/dashboard', [
            'stats'    => $stats,
            'dernieres' => $dernieres,
        ]);
    }
}
