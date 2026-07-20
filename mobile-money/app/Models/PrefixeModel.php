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
    protected $allowedFields    = ['prefixe', 'type', 'operateur_nom', 'actif'];

    /**
     * Vérifie qu'un numéro de téléphone commence par un préfixe INTERNE
     * (notre opérateur) actif. Utilisé pour la connexion client.
     */
    public function estPrefixeInterneValide(string $telephone): bool
    {
        return $this->trouverPrefixe($telephone, 'interne') !== null;
    }

    /**
     * Retourne le type de destination ('interne' | 'externe') pour un
     * numéro de téléphone donné, ou null si aucun préfixe ne correspond.
     */
    public function typeDestination(string $telephone): ?string
    {
        $prefixe = $this->trouverPrefixe($telephone);

        return $prefixe['type'] ?? null;
    }

    /**
     * Retourne le nom de l'opérateur externe correspondant au numéro,
     * ou null si le numéro n'est pas externe / ne correspond à rien.
     */
    public function operateurExterne(string $telephone): ?string
    {
        $prefixe = $this->trouverPrefixe($telephone, 'externe');

        return $prefixe['operateur_nom'] ?? null;
    }

    /**
     * Cherche le préfixe actif correspondant au début du numéro,
     * en filtrant éventuellement par type ('interne' ou 'externe').
     */
    public function trouverPrefixe(string $telephone, ?string $type = null): ?array
    {
        $builder = $this->where('actif', 1);

        if ($type !== null) {
            $builder = $builder->where('type', $type);
        }

        foreach ($builder->findAll() as $p) {
            if (strpos($telephone, $p['prefixe']) === 0) {
                return $p;
            }
        }

        return null;
    }
}
