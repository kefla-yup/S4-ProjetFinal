<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController
{
    /**
     * Formulaire de connexion (numéro de téléphone).
     */
    public function index()
    {
        if ($this->session->get('client_id')) {
            return redirect()->to('/client/dashboard');
        }

        return view('client/login');
    }

    /**
     * Connexion automatique : si le numéro existe, on se connecte,
     * sinon un compte client est créé automatiquement. Pas d'inscription.
     */
    public function login()
    {
        $telephone = trim($this->request->getPost('telephone'));

        if (empty($telephone)) {
            return redirect()->back()->with('error', 'Veuillez saisir un numéro de téléphone.');
        }

        $prefixeModel = new PrefixeModel();

        if (! $prefixeModel->estPrefixeInterneValide($telephone)) {
            return redirect()->back()->with('error', 'Ce numéro n\'appartient pas à un préfixe valable chez cet opérateur.');
        }

        $clientModel = new ClientModel();
        $client      = $clientModel->findOrCreateByTelephone($telephone);

        $this->session->set([
            'client_id'        => $client['id'],
            'client_telephone' => $client['telephone'],
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        $this->session->remove(['client_id', 'client_telephone']);

        return redirect()->to('/client/login');
    }
}
