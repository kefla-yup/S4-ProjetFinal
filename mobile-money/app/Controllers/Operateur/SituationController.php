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
     * Situation des gains via les différents frais, en séparant
     * les opérations internes (nos clients) des transferts vers
     * les autres opérateurs.
     */
    public function gains()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $transactionModel = new TransactionModel();
        $detail            = $transactionModel->gainsDetail();

        $interne = array_values(array_filter($detail, static fn ($g) => $g['destination_type'] === 'interne'));
        $externe = array_values(array_filter($detail, static fn ($g) => $g['destination_type'] === 'externe'));

        return view('operateur/situation_gains', [
            'gainsInterne' => $interne,
            'gainsExterne' => $externe,
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

    /**
     * Situation des montants à envoyer (à régler) à chaque autre opérateur.
     */
    public function montantsAEnvoyer()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $transactionModel = new TransactionModel();

        return view('operateur/situation_montants', [
            'montants' => $transactionModel->montantsAEnvoyer(),
        ]);
    }
}
