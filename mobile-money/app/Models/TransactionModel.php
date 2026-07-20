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
        'destinataire_id', 'solde_apres', 'date_creation',
    ];

    public function historiqueClient(int $clientId): array
    {
        return $this->select('transactions.*, types_operation.libelle as type_libelle, c2.telephone as destinataire_telephone')
            ->join('types_operation', 'types_operation.id = transactions.type_operation_id')
            ->join('clients c2', 'c2.id = transactions.destinataire_id', 'left')
            ->where('transactions.client_id', $clientId)
            ->orderBy('transactions.date_creation', 'DESC')
            ->findAll();
    }

    public function totalFraisParType(): array
    {
        return $this->db->table('v_gains_par_type')->get()->getResultArray();
    }
}
