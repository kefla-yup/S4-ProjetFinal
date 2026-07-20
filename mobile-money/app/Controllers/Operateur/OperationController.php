<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;

class OperationController extends BaseController
{
    private function requireAuth()
    {
        if (! $this->session->get('operateur_id')) {
            return redirect()->to('/operateur/login');
        }

        return null;
    }

    /**
     * Affiche les types d'opération et leurs barèmes de frais par tranche de montant.
     */
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $typeModel   = new TypeOperationModel();
        $baremeModel = new BaremeModel();

        $types = $typeModel->findAll();

        foreach ($types as &$type) {
            $type['baremes'] = $baremeModel->getByType($type['id']);
        }

        return view('operateur/operations', ['types' => $types]);
    }

    public function addBareme()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $data = [
            'type_operation_id' => (int) $this->request->getPost('type_operation_id'),
            'montant_min'       => (float) $this->request->getPost('montant_min'),
            'montant_max'       => (float) $this->request->getPost('montant_max'),
            'frais'             => (float) $this->request->getPost('frais'),
        ];

        if ($data['montant_max'] <= $data['montant_min']) {
            return redirect()->back()->with('error', 'Le montant maximum doit être supérieur au montant minimum.');
        }

        $baremeModel = new BaremeModel();
        $baremeModel->insert($data);

        return redirect()->to('/operateur/operations')->with('success', 'Tranche de frais ajoutée.');
    }

    public function deleteBareme(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $baremeModel = new BaremeModel();
        $baremeModel->delete($id);

        return redirect()->to('/operateur/operations')->with('success', 'Tranche de frais supprimée.');
    }
}
