<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use Loggable;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'budget_initial',       // Montant brut saisi dans la devise d'origine (ex: 24500000)
        'budget_devise',        // Devise d'origine (ex: USD, EUR)
        'budget_value',         // Contre-valeur convertie et pivot en XOF (ex: 15006250000)
        'taux_change',          // Taux appliqué à la création pour l'historique (ex: 612.50)
        'financement_bailleur', // Part prise en charge par le bailleur (BAD...) en XOF
        'financement_etat',     // Part prise en charge par l'État (Contrepartie) en XOF
        'start_date',
        'end_date',
        'taux_execution',
        'status',               // Statut du workflow : 'brouillon', 'soumis', 'valide', 'rejete'
        'user_id',              // ID de l'UGP qui a créé le projet
        'validated_by'          // ID du cadre Direction Nationale qui a validé
    ];

    // Ajoute cette propriété sous ton tableau $fillable
protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
];

    /**
     * L'utilisateur (UGP) qui a créé le projet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Le cadre (Direction Nationale) qui a validé le projet.
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Un projet possède plusieurs modules ou composantes.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(ProjectModule::class);
    }

    /**
     * Un projet possède plusieurs paiements/règlements.
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}