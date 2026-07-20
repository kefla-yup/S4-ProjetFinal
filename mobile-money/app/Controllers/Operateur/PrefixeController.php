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
     * Liste et formulaire d'ajout des préfixes : les nôtres (interne)
     * et ceux des autres opérateurs (externe).
     */
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $prefixeModel = new PrefixeModel();

        return view('operateur/prefixes', [
            'prefixesInternes' => $prefixeModel->where('type', 'interne')->orderBy('prefixe', 'ASC')->findAll(),
            'prefixesExternes' => $prefixeModel->where('type', 'externe')->orderBy('prefixe', 'ASC')->findAll(),
        ]);
    }

    public function add()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $prefixe      = trim($this->request->getPost('prefixe'));
        $type         = $this->request->getPost('type') === 'externe' ? 'externe' : 'interne';
        $operateurNom = trim($this->request->getPost('operateur_nom'));

        if (empty($prefixe)) {
            return redirect()->back()->with('error', 'Veuillez saisir un préfixe.');
        }

        if ($type === 'externe' && empty($operateurNom)) {
            return redirect()->back()->with('error', 'Veuillez indiquer le nom de l\'opérateur pour un préfixe externe.');
        }

        $prefixeModel = new PrefixeModel();

        if ($prefixeModel->where('prefixe', $prefixe)->first()) {
            return redirect()->back()->with('error', 'Ce préfixe existe déjà.');
        }

        $prefixeModel->insert([
            'prefixe'       => $prefixe,
            'type'          => $type,
            'operateur_nom' => $type === 'externe' ? $operateurNom : null,
            'actif'         => 1,
        ]);

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
