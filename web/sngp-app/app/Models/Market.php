<?php

namespace App\Models;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Market extends Model
{

use Loggable;

    protected $fillable = [
        'project_id',
        'project_module_id',
        'user_id',
        'created_by',
        'objet',
        'methode_passation',
        'etape',
        'status',
        'besoin_financier',
        'besoins_materiels',
        'devise',
        'candidature_start_date',
        'candidature_end_date',
    ];

    /**
     * Transtypage des attributs.
     */
    protected $casts = [
        'besoins_materiels'      => 'array',
        'besoin_financier'       => 'decimal:2',
        'candidature_start_date' => 'date',
        'candidature_end_date'   => 'date',
    ];

    /**
     * Libellé propre de l'étape.
     */
    public function getEtapeActuelleLibelleAttribute(): string
    {
        $etapes = [
            'EXPRESSION_BESOIN'     => '01 - Expression du besoin',
            'REDACTION_DAO'         => '02 - Rédaction du DAO',
            'VALIDATION_DGMP'       => '03 - Validation DGMP',
            'PUBLICATION_AVIS'      => "04 - Publication de l'Avis",
            'RECEPTION_OFFRES'      => '05 - Réception des offres',
            'OUVERTURE_PLIS'        => '06 - Ouverture des plis',
            'EVALUATION_TECHNIQUE'  => '07 - Évaluation Technique',
            'ATTRIBUTION_PROVISOIRE'=> '08 - Attribution Provisoire',
            'SIGNATURE_CONTRAT'     => '09 - Signature du Contrat',
            'ORDRE_SERVICE'         => '10 - Ordre de Service (OS)',
            'PREMIER_VERSEMENT'     => '11 - Premier Versement',
            'EXECUTION_TRAVAUX'     => '12 - Exécution des travaux',
            'DERNIER_VERSEMENT'     => '13 - Dernier Versement',
            'RECEPTION_DEFINITIVE'  => '14 - Réception définitive',
        ];

        return $etapes[$this->etape] ?? ($this->etape ?? 'Non définie');
    }

    // Relations
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function titulaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}