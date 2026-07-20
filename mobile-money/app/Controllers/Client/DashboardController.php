<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\PrefixeModel;
use App\Models\TransactionModel;
use App\Models\TypeOperationModel;

class DashboardController extends BaseController
{
    private ?int $clientId = null;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->clientId = $this->session->get('client_id');
    }

    /**
     * Redirige vers le login si le client n'est pas connecté.
     */
    private function requireAuth()
    {
        if (! $this->clientId) {
            return redirect()->to('/client/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel = new ClientModel();
        $client      = $clientModel->find($this->clientId);

        $transactionModel = new TransactionModel();
        $dernieres         = array_slice($transactionModel->historiqueClient($this->clientId), 0, 5);

        return view('client/dashboard', [
            'client'     => $client,
            'dernieres'  => $dernieres,
        ]);
    }

    // -----------------------------------------------------------------
    // DEPOT
    // -----------------------------------------------------------------
    public function depotForm()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('client/depot');
    }

    public function depot()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        $typeModel = new TypeOperationModel();
        $type      = $typeModel->getByCode('depot');

        $clientModel = new ClientModel();
        $client      = $clientModel->find($this->clientId);

        // Le dépôt est supposé automatique et sans frais
        $clientModel->crediter($this->clientId, $montant);
        $client = $clientModel->find($this->clientId);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'         => $this->clientId,
            'type_operation_id' => $type['id'],
            'montant'           => $montant,
            'frais'             => 0,
            'solde_apres'       => $client['solde'],
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Dépôt de ' . formater_ariary($montant) . ' effectué avec succès.');
    }

    // -----------------------------------------------------------------
    // RETRAIT
    // -----------------------------------------------------------------
    public function retraitForm()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel = new ClientModel();
        $client["client"] = $clientModel->find($this->clientId);

        return view('client/retrait', $client);
    }

    public function retrait()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $montant = (float) $this->request->getPost('montant');

        $typeModel = new TypeOperationModel();
        $type      = $typeModel->getByCode('retrait');

        $frais = calculer_frais($type['id'], $montant);
        $total = $montant + $frais;

        $clientModel = new ClientModel();
        $client      = $clientModel->find($this->clientId);

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        if ($client['solde'] < $total) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce retrait (montant + frais = ' . formater_ariary($total) . ').');
        }

        // Retrait supposé automatique
        $clientModel->debiter($this->clientId, $total);
        $client = $clientModel->find($this->clientId);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'         => $this->clientId,
            'type_operation_id' => $type['id'],
            'montant'           => $montant,
            'frais'             => $frais,
            'solde_apres'       => $client['solde'],
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Retrait de ' . formater_ariary($montant) . ' effectué (frais : ' . formater_ariary($frais) . ').');
    }

    // -----------------------------------------------------------------
    // TRANSFERT
    // -----------------------------------------------------------------
    public function transfertForm()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel = new ClientModel();

        return view('client/transfert', ['client' => $clientModel->find($this->clientId)]);
    }

    public function transfert()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $montant           = (float) $this->request->getPost('montant');
        $telephoneDestinat = trim($this->request->getPost('telephone_destinataire'));

        $prefixeModel = new PrefixeModel();
        $clientModel  = new ClientModel();
        $typeModel    = new TypeOperationModel();

        $expediteur = $clientModel->find($this->clientId);

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        if ($telephoneDestinat === $expediteur['telephone']) {
            return redirect()->back()->with('error', 'Impossible de transférer vers votre propre numéro.');
        }

        if (! $prefixeModel->estPrefixeValide($telephoneDestinat)) {
            return redirect()->back()->with('error', 'Le numéro du destinataire n\'appartient pas à un préfixe valable chez cet opérateur.');
        }

        $type  = $typeModel->getByCode('transfert');
        $frais = calculer_frais($type['id'], $montant);
        $total = $montant + $frais;

        if ($expediteur['solde'] < $total) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce transfert (montant + frais = ' . formater_ariary($total) . ').');
        }

        $destinataire = $clientModel->findOrCreateByTelephone($telephoneDestinat);

        // Débit expéditeur / crédit destinataire
        $clientModel->debiter($this->clientId, $total);
        $clientModel->crediter($destinataire['id'], $montant);

        $expediteur = $clientModel->find($this->clientId);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'         => $this->clientId,
            'type_operation_id' => $type['id'],
            'montant'           => $montant,
            'frais'             => $frais,
            'destinataire_id'   => $destinataire['id'],
            'solde_apres'       => $expediteur['solde'],
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Transfert de ' . formater_ariary($montant) . ' vers ' . $telephoneDestinat . ' effectué (frais : ' . formater_ariary($frais) . ').');
    }

    // -----------------------------------------------------------------
    // HISTORIQUE
    // -----------------------------------------------------------------
    public function historique()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $transactionModel = new TransactionModel();

        return view('client/historique', [
            'transactions' => $transactionModel->historiqueClient($this->clientId),
        ]);
    }
}
