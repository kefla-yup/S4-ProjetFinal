<?php

namespace App\Controllers\Operateur;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    private function requireAuth()
    {
        if (! $this->session->get('operateur_id')) {
            return redirect()->to('/operateur/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $clientModel      = new ClientModel();
        $transactionModel = new TransactionModel();

        $data = [
            'nbClients'    => $clientModel->countAllResults(),
            'gains'        => $transactionModel->totalFraisParType(),
        ];

        return view('operateur/dashboard', $data);
    }
}
