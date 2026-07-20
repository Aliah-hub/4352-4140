<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\OperationModel;

class ClientsController extends BaseController
{
    public function index()
    {
        $operateur_nom = session()->get('operateur_nom');

        // Préfixes par opérateur
        $prefixes_map = [
            'Airtel' => ['033', '035'],
            'Orange' => ['032', '037'],
            'Yas'    => ['034', '038'],
        ];

        $prefixes = $prefixes_map[$operateur_nom] ?? [];

        $clientModel = new ClientModel();
        $tousClients = $clientModel->findAll();

        // Filtrer par préfixe téléphonique de l'opérateur connecté
        $clients = array_filter($tousClients, function($c) use ($prefixes) {
            $tel = str_replace('+261', '0', $c['telephone']);
            $pref = substr($tel, 0, 3);
            return in_array($pref, $prefixes);
        });

        return view('operateur/clients', [
            'clients'       => array_values($clients),
            'operateur_nom' => $operateur_nom,
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
}
