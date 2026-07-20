<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table            = 'baremes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['type_operation_id', 'montant_min', 'montant_max', 'frais'];

    public function getByType(int $typeOperationId): array
    {
        return $this->where('type_operation_id', $typeOperationId)
            ->orderBy('montant_min', 'ASC')
            ->findAll();
    }
}
