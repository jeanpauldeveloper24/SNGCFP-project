<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // On autorise le remplissage de ces colonnes
    protected $fillable = [
        'code',
        'nom',
        'categorie',
        'budget_alloue',
        'budget_depense',
        'fonds_recus_bad',
        'taux_execution'
    ];
}