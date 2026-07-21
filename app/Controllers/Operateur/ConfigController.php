<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ConfigModel;

class ConfigController extends BaseController
{
    public function index()
    {
        $configModel = new ConfigModel();
        $configs = $configModel->findAll();

        return view('operateur/config', ['configs' => $configs]);
    }

    public function update()
    {
        $configModel = new ConfigModel();
        $id = $this->request->getPost('id');
        $valeur = $this->request->getPost('valeur');

        $configModel->update($id, ['valeur' => $valeur]);

        return redirect()->to('/operateur/config')->with('success', 'Configuration mise a jour avec succes.');
    }
}
