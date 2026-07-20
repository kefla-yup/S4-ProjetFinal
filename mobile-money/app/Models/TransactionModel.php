<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'client_id', 'type_operation_id', 'montant', 'frais',
        'commission_externe', 'frais_retrait_inclus',
        'destination_type', 'destinataire_id', 'destinataire_telephone',
        'lot_id', 'solde_apres', 'date_creation',
    ];

    public function historiqueClient(int $clientId): array
    {
        return $this->select('transactions.*, types_operation.libelle as type_libelle')
            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
            ->where('transactions.client_id', $clientId)
            ->orderBy('transactions.date_creation', 'DESC')
            ->findAll();
    }

    /**
     * Gains globaux (frais + commissions) par type d'opération.
     */
    public function totalFraisParType(): array
    {
        return $this->db->table('v_gains_par_type')->get()->getResultArray();
    }

    /**
     * Gains détaillés par type d'opération ET par destination
     * (interne = nos clients / externe = autres opérateurs).
     */
    public function gainsDetail(): array
    {
        return $this->db->table('v_gains_detail')->get()->getResultArray();
    }

    /**
     * Situation des montants à envoyer (à régler) à chaque autre opérateur.
     */
    public function montantsAEnvoyer(): array
    {
        return $this->db->table('v_montants_a_envoyer')->get()->getResultArray();
    }
}
