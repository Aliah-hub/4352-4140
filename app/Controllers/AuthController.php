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
            return redirect()->back()->with('error', 'Veuillez entrer votre numéro de téléphone.');
        }

        $prefixeModel = new PrefixeModel();
        if (! $prefixeModel->estValide($telephone)) {
            return redirect()->back()->with('error', 'Numéro de téléphone non valide pour cet opérateur.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->trouverOuCreer($telephone);

        if ((int) $client['actif'] === 0) {
            return redirect()->back()->with('error', 'Votre compte est désactivé.');
        }

        session()->set([
            'client_id'        => $client['id'],
            'client_telephone' => $client['telephone'],
            'client_nom'       => $client['nom'],
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Bienvenue !');
    }

    public function loginOperateur()
    {
        $operateur_nom = trim((string) $this->request->getPost('operateur_nom'));

        $operateurs_valides = ['Airtel', 'Orange', 'Yas'];

        if (! in_array($operateur_nom, $operateurs_valides)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un opérateur valide.');
        }

        session()->set([
            'operateur_id'  => 1,
            'operateur_nom' => $operateur_nom,
        ]);

        return redirect()->to('/operateur/dashboard')->with('success', 'Bienvenue ' . $operateur_nom . ' !');
    }

    // Déconnexion
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Vous êtes déconnecté.');
    }
}
