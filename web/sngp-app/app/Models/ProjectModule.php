<?php

namespace App\Models;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectModule extends Model
{
    use Loggable;
    protected $fillable = [
        'project_id',
        'number',
        'description',
        'budget_value',
        'budget_devise',
        'duree',
        'status'
    ];

    /**
     * Le module appartient à un unique projet parent.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
 * Un module fait l'objet d'un marché public.
 */
// Correct si la colonne s'appelle market_id dans ta table project_modules
public function market() {
    return $this->belongsTo(Market::class, 'market_id');
}
}