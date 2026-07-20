<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class SituationController extends BaseController
{
    private function requireAuth()
    {
        if (! $this->session->get('operateur_id')) {
            return redirect()->to('/operateur/login');
        }

        return null;
    }

    /**
     * Situation des gains via les différents frais (retrait et transfert).
     */
    public function gains()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $transactionModel = new TransactionModel();

        return view('operateur/situation_gains', [
            'gains' => $transactionModel->totalFraisParType(),
        ]);
    }

    /**
     * Situation des comptes clients.
     */
    public function clients()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel = new ClientModel();

        return view('operateur/situation_clients', [
            'clients' => $clientModel->db->table('v_situation_clients')->orderBy('telephone', 'ASC')->get()->getResultArray(),
        ]);
    }
}
