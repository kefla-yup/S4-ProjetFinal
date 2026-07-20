<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table            = 'prefixes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['prefixe', 'actif'];

    /**
     * Vérifie qu'un numéro de téléphone commence par un préfixe valable et actif.
     */
    public function estPrefixeValide(string $telephone): bool
    {
        $prefixes = $this->where('actif', 1)->findAll();

        foreach ($prefixes as $p) {
            if (strpos($telephone, $p['prefixe']) === 0) {
                return true;
            }
        }

        return false;
    }
}
