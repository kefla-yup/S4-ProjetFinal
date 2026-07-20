<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\OperateurModel;

class AuthController extends BaseController
{
    public function index()
    {
        if ($this->session->get('operateur_id')) {
            return redirect()->to('/operateur/dashboard');
        }

        return view('operateur/login');
    }

    public function login()
    {
        $username = trim($this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $operateurModel = new OperateurModel();
        $operateur       = $operateurModel->verifierIdentifiants($username, $password);

        if (! $operateur) {
            return redirect()->back()->with('error', 'Identifiants incorrects.');
        }

        $this->session->set([
            'operateur_id'   => $operateur['id'],
            'operateur_nom'  => $operateur['nom'],
        ]);

        return redirect()->to('/operateur/dashboard');
    }

    public function logout()
    {
        $this->session->remove(['operateur_id', 'operateur_nom']);

        return redirect()->to('/operateur/login');
    }
}
