<?php

namespace App\Models;
use App\Traits\Loggable; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avenant extends Model
{
    use Loggable;
    
    protected $fillable = [
        'code_avenant',
        'market_id',
        'motif',
        'description_technique',
        'montant_additionnel',
        'devise',
        'jours_supplementaires',
        'status',
        'user_id_prestataire_demandeur',
        'validated_by',
        'date_signature'
    ];

    protected $casts = [
        'date_signature' => 'date',
    ];

    /**
     * L'avenant modifie un marché existant.
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * L'ordonnateur qui approuve et signe l'avenant en fin de circuit.
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}