<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ParametreModel;

class ParametreController extends BaseController
{
    private function requireAuth()
    {
        if (! $this->session->get('operateur_id')) {
            return redirect()->to('/operateur/login');
        }

        return null;
    }

    /**
     * Configuration du % de commission additionnelle prélevé sur les
     * transferts vers les autres opérateurs.
     */
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $parametreModel = new ParametreModel();

        return view('operateur/parametres', [
            'commissionExterne' => $parametreModel->commissionExternePourcentage(),
        ]);
    }

    public function update()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $pourcentage = (float) $this->request->getPost('commission_externe_pourcentage');

        if ($pourcentage < 0) {
            return redirect()->back()->with('error', 'Le pourcentage doit être positif.');
        }

        $parametreModel = new ParametreModel();
        $parametreModel->setValeur('commission_externe_pourcentage', (string) $pourcentage);

        return redirect()->to('/operateur/parametres')->with('success', 'Paramètre mis à jour.');
    }


    public function promotion()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $parametreModel = new ParametreModel();

        return view('operateur/promotion', [
            'promotion' => $parametreModel->promotionPourcentage(),
        ]);
    }

    public function updatePromotion()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $pourcentage = (float) $this->request->getPost('promotion_pourcentage');

        if ($pourcentage < 0) {
            return redirect()->back()->with('error', 'Le pourcentage doit être positif.');
        }

        $parametreModel = new ParametreModel();
        $parametreModel->setValeur('promotion_pourcentage', (string) $pourcentage);

        return redirect()->to('/operateur/parametres')->with('success', 'Paramètre mis à jour.');
    }
}
