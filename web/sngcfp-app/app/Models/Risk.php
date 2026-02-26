<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

    // Autoriser le remplissage de ces champs
    protected $fillable = [
        'title',
        'level',
        'label',
        'is_archived',
        'project_id'
    ];

    // Conversion automatique du champ is_archived en booléen
    protected $casts = [
        'is_archived' => 'boolean',
    ];

    /**
     * Relation : Un risque appartient à un projet
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}