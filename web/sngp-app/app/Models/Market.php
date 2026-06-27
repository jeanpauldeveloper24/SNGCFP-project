<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Market extends Model
{
    use Loggable;

    protected $casts = [
        'besoins_materiels' => 'array',
        'exige_quitus' => 'boolean',
        'exige_cnps' => 'boolean',
        'exige_rccm' => 'boolean',
        'exige_faillite' => 'boolean',
    ];
    
    protected $fillable = [
        'project_id',          // Ajouté pour correspondre à la migration
        'project_module_id',   // Conservé pour la liaison aux composantes
        'objet',
        'besoins_materiels',   // Ajouté
        'montant',
        'devise',
        'date_lancement',
        'date_attribution',
        'candidature_start_date',
        'candidature_end_date',
        'status',
        'etape',               // Corrigé (au lieu de etape_actuelle)
        'exige_quitus',        // Ajouté
        'exige_cnps',          // Ajouté
        'exige_rccm',          // Ajouté
        'exige_faillite',      // Ajouté
        'prestataire_retenu',
        'created_by'
    ];

    /**
     * Liaison directe avec le Projet
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Liaison optionnelle avec la Composante (Module)
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function avenants(): HasMany
    {
        return $this->hasMany(Avenant::class);
    }

    public function travaux(): HasMany
    {
        return $this->hasMany(Travail::class);
    }
}