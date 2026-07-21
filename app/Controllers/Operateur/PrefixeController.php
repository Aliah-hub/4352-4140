<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixeController extends BaseController
{
    public function index()
    {
        $prefixeModel = new PrefixeModel();
        $prefixes = $prefixeModel->findAll();

        return view('operateur/prefixes', [
            'prefixes' => $prefixes,
        ]);
    }

    public function store()
    {
        $valeur = trim((string) $this->request->getPost('valeur'));

        if ($valeur === '') {
            return redirect()->back()->with('error', 'La valeur du prefixe est obligatoire.');
        }

        $prefixeModel = new PrefixeModel();

        $existant = $prefixeModel->where('valeur', $valeur)->first();
        if ($existant !== null) {
            return redirect()->back()->with('error', 'Ce prefixe existe deja.');
        }

        $prefixeModel->insert([
            'valeur'     => $valeur,
            'actif'      => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/operateur/prefixes')->with('success', 'Prefixe ajoute.');
    }

    public function toggleActif(int $id)
    {
        $prefixeModel = new PrefixeModel();
        $prefixe = $prefixeModel->find($id);

        if ($prefixe === null) {
            return redirect()->back()->with('error', 'Prefixe introuvable.');
        }

        $nouvelEtat = ($prefixe['actif'] == 1) ? 0 : 1;
        $prefixeModel->update($id, ['actif' => $nouvelEtat]);

        return redirect()->to('/operateur/prefixes')->with('success', 'Statut mis a jour.');
    }

    public function delete(int $id)
    {
        $prefixeModel = new PrefixeModel();
        $prefixeModel->delete($id);

        return redirect()->to('/operateur/prefixes')->with('success', 'Prefixe supprime.');
    }
}
