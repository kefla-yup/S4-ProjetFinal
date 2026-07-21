<?php

use App\Models\BaremeModel;
use App\Models\ParametreModel;

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

if (! function_exists('calculer_commission_externe')) {
    /**
     * Calcule la commission additionnelle (%) appliquée sur un transfert
     * vers un numéro d'un autre opérateur, en plus du barème de frais normal.
     */
    function calculer_commission_externe(float $montant): float
    {
        $parametreModel = new ParametreModel();
        $pourcentage    = $parametreModel->commissionExternePourcentage();

        return round($montant * $pourcentage / 100, 2);
    }

    
}
if (! function_exists('calculer_promotion')) {
function calculer_promotion(float $montant): float
    {
        $parametreModel = new ParametreModel();
        $pourcentage    = $parametreModel->promotionPourcentage();

        return round($montant - $pourcentage / 100, 2);
    }

}
if (! function_exists('epargnE')) {
function epargnE(float $montant): float
    {
        $parametreModel = new ParametreModel();
        $pourcentage    = $parametreModel->epargne();

        return round($montant * $pourcentage / 100, 2);
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
