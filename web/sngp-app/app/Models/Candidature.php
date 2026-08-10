<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidature extends Model
{
    use Loggable;
    
    protected $fillable = [
        'marche_id', // Ta clé étrangère en base de données
        'nom_candidat',
        'numero_registre_commerce',
        'file_rccm',
        'file_acte_constitution',
        'file_dfe',
        'file_arf',
        'file_cnps',
        'file_attestation_bancaire',
        'proposition_technique',
        'proposition_financiere',
        'status',
        'motif_statut'
    ];

    // Cast pour manipuler le JSON de la proposition comme un tableau PHP
    protected $casts = [
        'proposition_technique' => 'array', // Indispensable pour stocker le tableau $offreMaterielle directement
    ];

    /**
     * Relation avec le modèle Market (lié à la table markets)
     */
    public function market()
    {
        // On spécifie 'marche_id' pour écraser le 'market_id' que Laravel cherche par défaut
        return $this->belongsTo(Market::class, 'marche_id');
    }

    /**
 * Workflow de tri et de rejet automatique à la création
 */
protected static function booted()
{
    static::creating(function ($candidature) {
        // On appelle la relation 'market' configurée
        $market = $candidature->market;

        if ($market) {
            // RÈGLE 1 : Filtrage Financier
            if ($candidature->proposition_financiere > $market->montant) {
                // Utilise 'Rejeté' (conforme au enum/CHECK SQLite)
                $candidature->status = 'Rejeté'; 
                $candidature->motif_statut = "[Rejet automatique] Offre financière (" . number_format($candidature->proposition_financiere, 0, ',', ' ') . " CFA) supérieure à l'enveloppe budgétaire allouée du marché.";
                return;
            }

            // RÈGLE 2 : Filtrage Technique & Quantitatif
            $offresCandidat = $candidature->proposition_technique; 

            if (is_array($offresCandidat)) {
                foreach ($offresCandidat as $item) {
                    if (isset($item['quantite_proposee'], $item['quantite_exigee']) && $item['quantite_proposee'] < $item['quantite_exigee']) {
                        // Utilise 'Rejeté' (conforme au enum/CHECK SQLite)
                        $candidature->status = 'Rejeté'; 
                        $candidature->motif_statut = "[Rejet automatique] Insuffisance technique détectée sur l'élément [ " . $item['designation_reference'] . " ]. Quantité proposée : " . $item['quantite_proposee'] . " au lieu de " . $item['quantite_exigee'] . " minimum requis.";
                        return;
                    }
                }
            }
        }
    });
}

}