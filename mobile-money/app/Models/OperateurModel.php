<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table            = 'operateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    protected $allowedFields    = ['username', 'password', 'nom'];

    public function verifierIdentifiants(string $username, string $password): array|false
    {
        $operateur = $this->where('username', $username)->first();

        if ($operateur && password_verify($password, $operateur['password'])) {
            return $operateur;
        }

        return false;
    }
}
