<?php

namespace App\Models;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use Loggable;
    protected $fillable = [
        'project_id',
        'project_module_id',
        'market_id',
        'user_id_prestataire',
        'date_paiement',
        'montant',
        'devise',
        'status',
        'etape_administrative',
        'references',
        'created_by'
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    /**
     * Le projet lié au règlement.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Le module lié au règlement.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    /**
     * Le marché lié au règlement.
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * L'utilisateur (Comptable) qui a enregistré la demande de paiement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}