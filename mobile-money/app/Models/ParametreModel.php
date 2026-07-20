<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table            = 'parametres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['cle', 'valeur'];

    public function getValeur(string $cle, string $defaut = '0'): string
    {
        $param = $this->where('cle', $cle)->first();

        return $param['valeur'] ?? $defaut;
    }

    public function setValeur(string $cle, string $valeur): void
    {
        $param = $this->where('cle', $cle)->first();

        if ($param) {
            $this->update($param['id'], ['valeur' => $valeur]);
        } else {
            $this->insert(['cle' => $cle, 'valeur' => $valeur]);
        }
    }

    /**
     * Pourcentage de commission additionnelle appliqué sur les transferts
     * vers les autres opérateurs (en plus du barème de frais normal).
     */
    public function commissionExternePourcentage(): float
    {
        return (float) $this->getValeur('commission_externe_pourcentage', '0');
    }
}
