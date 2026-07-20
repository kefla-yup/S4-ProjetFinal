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

        return view('client/retrait', ['client' => $clientModel->find($this->clientId)]);
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

        $montant             = (float) $this->request->getPost('montant');
        $telephoneDestinat   = trim($this->request->getPost('telephone_destinataire'));
        $inclureFraisRetrait = (bool) $this->request->getPost('inclure_frais_retrait');

        $clientModel = new ClientModel();
        $expediteur  = $clientModel->find($this->clientId);

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        if ($telephoneDestinat === $expediteur['telephone']) {
            return redirect()->back()->with('error', 'Impossible de transférer vers votre propre numéro.');
        }

        try {
            $resultat = $this->executerTransfert($this->clientId, $telephoneDestinat, $montant, $inclureFraisRetrait);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $message = 'Transfert de ' . formater_ariary($montant) . ' vers ' . $telephoneDestinat
            . ' effectué (frais : ' . formater_ariary($resultat['frais_total']) . ').';

        return redirect()->to('/client/dashboard')->with('success', $message);
    }

    // -----------------------------------------------------------------
    // TRANSFERT MULTIPLE (envoi vers plusieurs numéros, montant divisé)
    // -----------------------------------------------------------------
    public function transfertMultipleForm()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel = new ClientModel();

        return view('client/transfert_multiple', ['client' => $clientModel->find($this->clientId)]);
    }

    public function transfertMultiple()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $montantTotal        = (float) $this->request->getPost('montant_total');
        $numerosBruts         = (string) $this->request->getPost('numeros');
        $inclureFraisRetrait = (bool) $this->request->getPost('inclure_frais_retrait');

        // Un numéro par ligne (ou séparés par une virgule)
        $numeros = preg_split('/[\r\n,]+/', $numerosBruts);
        $numeros = array_values(array_filter(array_map('trim', $numeros)));
        $nb      = count($numeros);

        if ($montantTotal <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        if ($nb < 2) {
            return redirect()->back()->with('error', 'Veuillez saisir au moins deux numéros pour un envoi multiple.');
        }

        // Le montant total est divisé équitablement entre chaque destinataire
        $montantBase = intdiv((int) $montantTotal, $nb);
        $reste       = ((int) $montantTotal) % $nb;

        $clientModel = new ClientModel();
        $db          = \Config\Database::connect();
        $db->transStart();

        $lotId       = uniqid('lot_', true);
        $totalDebite = 0;

        try {
            foreach ($numeros as $i => $numero) {
                $montantDestinataire = $montantBase + ($i < $reste ? 1 : 0);

                $resultat = $this->executerTransfert(
                    $this->clientId,
                    $numero,
                    $montantDestinataire,
                    $inclureFraisRetrait,
                    $lotId
                );

                $totalDebite += $resultat['total_debite'];
            }
        } catch (\RuntimeException $e) {
            $db->transRollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        $db->transComplete();

        $message = 'Envoi multiple de ' . formater_ariary($montantTotal) . ' réparti entre ' . $nb
            . ' numéros effectué (total débité : ' . formater_ariary($totalDebite) . ').';

        return redirect()->to('/client/dashboard')->with('success', $message);
    }

    /**
     * Logique commune d'exécution d'un transfert (utilisée par le transfert
     * simple et le transfert multiple). Gère les préfixes internes/externes,
     * la commission externe (v2) et l'option "inclure frais de retrait" (v2).
     *
     * @throws \RuntimeException si le transfert ne peut pas être effectué
     */
    private function executerTransfert(int $expediteurId, string $telephoneDestinat, float $montant, bool $inclureFraisRetrait, ?string $lotId = null): array
    {
        $prefixeModel = new PrefixeModel();
        $clientModel  = new ClientModel();
        $typeModel    = new TypeOperationModel();

        $typeDestination = $prefixeModel->typeDestination($telephoneDestinat);

        if ($typeDestination === null) {
            throw new \RuntimeException('Le numéro ' . $telephoneDestinat . ' n\'appartient à aucun préfixe connu.');
        }

        $typeTransfert = $typeModel->getByCode('transfert');
        $typeRetrait   = $typeModel->getByCode('retrait');

        $frais              = calculer_frais($typeTransfert['id'], $montant);
        $commissionExterne  = $typeDestination === 'externe' ? calculer_commission_externe($montant) : 0.0;

        // Option "inclure frais de retrait" : l'expéditeur paie en plus le
        // frais que le destinataire aurait à payer pour retirer ce montant.
        $fraisRetraitInclus = $inclureFraisRetrait ? calculer_frais($typeRetrait['id'], $montant) : 0.0;

        $totalDebite = $montant + $frais + $commissionExterne + $fraisRetraitInclus;

        $expediteur = $clientModel->find($expediteurId);

        if ($expediteur['solde'] < $totalDebite) {
            throw new \RuntimeException('Solde insuffisant pour transférer vers ' . $telephoneDestinat . ' (total requis : ' . formater_ariary($totalDebite) . ').');
        }

        $destinataireId = null;

        if ($typeDestination === 'interne') {
            // Le destinataire est un client de notre opérateur : on le crédite.
            $destinataire = $clientModel->findOrCreateByTelephone($telephoneDestinat);
            $destinataireId = $destinataire['id'];

            $montantCredite = $montant + $fraisRetraitInclus;
            $clientModel->crediter($destinataireId, $montantCredite);
        }
        // Si externe : l'argent sort vers un autre opérateur, aucun compte
        // client local n'est crédité (voir "Situation des montants à envoyer").

        $clientModel->debiter($expediteurId, $totalDebite);
        $expediteur = $clientModel->find($expediteurId);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'              => $expediteurId,
            'type_operation_id'      => $typeTransfert['id'],
            'montant'                => $montant,
            'frais'                  => $frais,
            'commission_externe'     => $commissionExterne,
            'frais_retrait_inclus'   => $fraisRetraitInclus,
            'destination_type'       => $typeDestination,
            'destinataire_id'        => $destinataireId,
            'destinataire_telephone' => $telephoneDestinat,
            'lot_id'                 => $lotId,
            'solde_apres'            => $expediteur['solde'],
        ]);

        return [
            'frais_total'  => $frais + $commissionExterne,
            'total_debite' => $totalDebite,
        ];
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
