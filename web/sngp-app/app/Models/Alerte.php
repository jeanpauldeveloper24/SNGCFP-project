<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerte extends Model
{
    protected $fillable = [
        'user_id_prestataire',
        'type',
        'niveau',
        'title',
        'texte',
        'media',
        'project_id',
        'market_id',
        'status'
    ];

    /**
     * Le projet concerné par l'alerte/signalement.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Le marché sur lequel le prestataire rencontre un blocage.
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}