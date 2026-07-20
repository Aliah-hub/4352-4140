<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\TypeOperationModel;
use App\Models\BaremeModel;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $typeModel  = new TypeOperationModel();
        $baremeModel = new BaremeModel();

        $types = $typeModel->findAll();

        foreach ($types as $i => $t) {
            $types[$i]['baremes'] = $baremeModel->getPourType((int) $t['id'], 'Yas');
        }

        return view('operateur/type_operations', [
            'types'  => $types,
        ]);
    }

    public function store()
    {
        $code    = trim((string) $this->request->getPost('code'));
        $libelle = trim((string) $this->request->getPost('libelle'));

        if ($code === '' || $libelle === '') {
            return redirect()->back()->with('error', 'Code et libellé sont obligatoires.');
        }

        $typeModel = new TypeOperationModel();

        $existant = $typeModel->where('code', $code)->first();
        if ($existant !== null) {
            return redirect()->back()->with('error', 'Ce code existe déjà.');
        }

        $typeModel->insert(['code' => $code, 'libelle' => $libelle, 'actif' => 1]);

        return redirect()->to('/operateur/type-operations')->with('success', 'Type d\'opération créé.');
    }

    public function delete(int $id)
    {
        $typeModel = new TypeOperationModel();
        $typeModel->delete($id);

        return redirect()->to('/operateur/type-operations')->with('success', 'Type supprimé.');
    }

    public function baremes(int $typeId)
    {
        $typeModel   = new TypeOperationModel();
        $baremeModel = new BaremeModel();

        $type    = $typeModel->find($typeId);
        $baremes = $baremeModel->getPourType($typeId, 'Yas');

        if ($type === null) {
            return redirect()->back()->with('error', 'Type introuvable.');
        }

        return view('operateur/baremes', [
            'type'    => $type,
            'baremes' => $baremes,
        ]);
    }

    public function storeBareme(int $typeId)
    {
        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');
        $frais      = (float) $this->request->getPost('frais');

        if ($montantMin < 0 || $montantMax <= $montantMin || $frais < 0) {
            return redirect()->back()->with('error', 'Valeurs invalides.');
        }

        $baremeModel = new BaremeModel();
        $baremeModel->insert([
            'operateur_nom'     => 'Yas',
            'type_operation_id' => $typeId,
            'montant_min'       => $montantMin,
            'montant_max'       => $montantMax,
            'frais'             => $frais,
        ]);

        return redirect()->to('/operateur/type-operations/' . $typeId . '/baremes')
                         ->with('success', 'Tranche ajoutée.');
    }

    public function updateBareme(int $typeId, int $baremeId)
    {
        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');
        $frais      = (float) $this->request->getPost('frais');

        $baremeModel = new BaremeModel();
        $baremeModel->update($baremeId, [
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais'       => $frais,
        ]);

        return redirect()->to('/operateur/type-operations/' . $typeId . '/baremes')
                         ->with('success', 'Tranche modifiée.');
    }

    public function deleteBareme(int $typeId, int $baremeId)
    {
        $baremeModel = new BaremeModel();
        $baremeModel->delete($baremeId);

        return redirect()->to('/operateur/type-operations/' . $typeId . '/baremes')
                         ->with('success', 'Tranche supprimée.');
    }
}
