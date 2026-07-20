<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\OperationModel;

class GainController extends BaseController
{
    public function index()
    {
        $operationModel = new OperationModel();
        $toutesOps = $operationModel->getToutesAvecDetails();

        $gainsInterne = 0;
        $gainsExterne = 0;
        $gainsParTypeMap = [];
        $gainTotal = 0;

        foreach ($toutesOps as $op) {
            $frais = (float) $op['frais'];
            $libelle = $op['type_libelle'];

            // Cumul par type
            if (!isset($gainsParTypeMap[$libelle])) {
                $gainsParTypeMap[$libelle] = ['libelle' => $libelle, 'nb' => 0, 'total_frais' => 0];
            }
            $gainsParTypeMap[$libelle]['nb']++;
            $gainsParTypeMap[$libelle]['total_frais'] += $frais;
            $gainTotal += $frais;

            // Interne vs Externe
            if ($frais > 0) {
                if (strpos($op['description'], 'Inter-opérateur') !== false) {
                    $gainsExterne += $frais;
                } else {
                    $gainsInterne += $frais;
                }
            }
        }

        $gainsParType = array_values($gainsParTypeMap);

        return view('operateur/gains', [
            'gainsParType' => $gainsParType,
            'gainTotal'    => $gainTotal,
            'gainsInterne' => $gainsInterne,
            'gainsExterne' => $gainsExterne,
        ]);
    }
}
