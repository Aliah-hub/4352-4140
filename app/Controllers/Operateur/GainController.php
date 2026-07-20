<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\OperationModel;

class GainController extends BaseController
{
    public function index()
    {
        $operationModel = new OperationModel();

        $gainsParType  = $operationModel->totalFraisParType();
        $gainTotal     = $operationModel->totalFraisGeneral();

        return view('operateur/gains', [
            'gainsParType' => $gainsParType,
            'gainTotal'    => $gainTotal,
        ]);
    }
}
