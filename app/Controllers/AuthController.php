<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\OperateurModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        if (session()->get('client_id')) {
            return redirect()->to('/client/dashboard');
        }
        if (session()->get('operateur_id')) {
            return redirect()->to('/operateur/dashboard');
        }
        return view('auth/login');
    }

    public function loginClient()
    {
        $telephone = trim((string) $this->request->getPost('telephone'));

        if ($telephone === '') {
            return redirect()->back()->with('error', 'Veuillez entrer votre numero de telephone.');
        }

        $prefixeModel = new PrefixeModel();
        if (! $prefixeModel->estValide($telephone)) {
            return redirect()->back()->with('error', 'Numero de telephone non valide pour cet operateur.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->trouverOuCreer($telephone);

        if ((int) $client['actif'] === 0) {
            return redirect()->back()->with('error', 'Votre compte est desactive.');
        }

        session()->set([
            'client_id'        => $client['id'],
            'client_telephone' => $client['telephone'],
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Bienvenue !');
    }

    public function loginOperateur()
    {
        session()->set([
            'operateur_id'  => 1,
            'operateur_nom' => 'Yas',
        ]);

        return redirect()->to('/operateur/dashboard')->with('success', 'Bienvenue sur le tableau de bord Administrateur !');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Vous êtes deconnecte.');
    }
}
