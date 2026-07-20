<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixeController extends BaseController
{
    private function requireAuth()
    {
        if (! $this->session->get('operateur_id')) {
            return redirect()->to('/operateur/login');
        }

        return null;
    }

    /**
     * Liste et formulaire d'ajout des préfixes valables de l'opérateur.
     */
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $prefixeModel = new PrefixeModel();

        return view('operateur/prefixes', [
            'prefixes' => $prefixeModel->orderBy('prefixe', 'ASC')->findAll(),
        ]);
    }

    public function add()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $prefixe = trim($this->request->getPost('prefixe'));

        if (empty($prefixe)) {
            return redirect()->back()->with('error', 'Veuillez saisir un préfixe.');
        }

        $prefixeModel = new PrefixeModel();

        if ($prefixeModel->where('prefixe', $prefixe)->first()) {
            return redirect()->back()->with('error', 'Ce préfixe existe déjà.');
        }

        $prefixeModel->insert(['prefixe' => $prefixe, 'actif' => 1]);

        return redirect()->to('/operateur/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $prefixeModel = new PrefixeModel();
        $prefixeModel->delete($id);

        return redirect()->to('/operateur/prefixes')->with('success', 'Préfixe supprimé.');
    }
}
