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

        $operateur_nom = session()->get('operateur_nom');

        // Préfixes par opérateur
        $prefixes_map = [
            'Airtel' => ['033', '035'],
            'Orange' => ['032', '037'],
            'Yas'    => ['034', '038'],
        ];
        $prefixes = $prefixes_map[$operateur_nom] ?? [];

        // Compter uniquement les clients de cet opérateur
        $tousClients = $clientModel->findAll();
        $clientsFiltres = array_filter($tousClients, function($c) use ($prefixes) {
            $tel = str_replace('+261', '0', $c['telephone']);
            return in_array(substr($tel, 0, 3), $prefixes);
        });
        $total_clients = count($clientsFiltres);

        $stats = [
            'total_clients'    => $total_clients,
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
