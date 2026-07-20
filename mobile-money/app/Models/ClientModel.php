<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['telephone', 'solde'];

    /**
     * Retourne le client correspondant au numéro, ou le crée automatiquement
     * s'il n'existe pas encore (pas d'inscription préalable).
     */
    public function findOrCreateByTelephone(string $telephone): array
    {
        $client = $this->where('telephone', $telephone)->first();

        if (! $client) {
            $id = $this->insert([
                'telephone' => $telephone,
                'solde'     => 0,
            ]);
            $client = $this->find($id);
        }

        return $client;
    }

    public function crediter(int $clientId, float $montant): void
    {
        $client = $this->find($clientId);
        $this->update($clientId, ['solde' => $client['solde'] + $montant]);
    }

    public function debiter(int $clientId, float $montant): void
    {
        $client = $this->find($clientId);
        $this->update($clientId, ['solde' => $client['solde'] - $montant]);
    }
}
