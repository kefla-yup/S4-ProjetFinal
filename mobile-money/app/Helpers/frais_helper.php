<?php

use App\Models\BaremeModel;

if (! function_exists('calculer_frais')) {
    /**
     * Calcule le frais applicable pour un type d'opération et un montant donné,
     * en cherchant la tranche correspondante dans le barème (table `baremes`).
     * Retourne 0 si aucune tranche ne correspond (ex: le dépôt n'a pas de barème).
     */
    function calculer_frais(int $typeOperationId, float $montant): float
    {
        $baremeModel = new BaremeModel();

        $bareme = $baremeModel
            ->where('type_operation_id', $typeOperationId)
            ->where('montant_min <=', $montant)
            ->where('montant_max >=', $montant)
            ->first();

        return $bareme ? (float) $bareme['frais'] : 0.0;
    }
}

if (! function_exists('formater_ariary')) {
    /**
     * Formate un montant en Ariary pour l'affichage.
     */
    function formater_ariary(float $montant): string
    {
        return number_format($montant, 0, ',', ' ') . ' Ar';
    }
}
