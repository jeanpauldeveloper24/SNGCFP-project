<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectModule extends Model
{
    use Loggable;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'project_id',
        'market_id',
        'number',
        'description',
        'besoin_financier',
        'devise',
        'duree',
        'status',
    ];

    /**
     * Transtypage des attributs.
     */
    protected $casts = [
        'number'           => 'integer',
        'besoin_financier' => 'decimal:2',
    ];

    /**
     * Projet auquel appartient ce module/composante.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Marché individuel directement rattaché (si clé étrangère market_id).
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    /**
     * Liste des marchés publics engagés sur ce module spécifique.
     */
    public function markets(): HasMany
    {
        return $this->hasMany(Market::class, 'project_module_id');
    }
}