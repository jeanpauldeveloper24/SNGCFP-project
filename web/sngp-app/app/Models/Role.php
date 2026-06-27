<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // Ajout de 'platform' dans les champs autorisés
    protected $fillable = ['name', 'description', 'platform'];

    /**
     * Un rôle possède plusieurs utilisateurs.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}