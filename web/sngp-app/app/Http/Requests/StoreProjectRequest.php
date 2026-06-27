<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // On autorise uniquement si l'utilisateur connecté est une UGP
        return auth()->check() && auth()->user()->role->name === 'ugp';
    }

    public function rules(): array
{
    return [
        // Validation du projet
        'code' => 'required|string|unique:projects,code',
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        
        // C'est ici qu'on valide l'enveloppe globale saisie
        'budget_initial' => 'required|numeric|min:0', 
        
        'budget_devise' => 'required|string|in:XOF,USD,EUR',
        'taux_change' => 'nullable|numeric|min:0',
        'pourcentage_bailleur' => 'required|numeric|min:0|max:100',
        'pourcentage_etat' => 'required|numeric|min:0|max:100',
        'end_date' => 'required|date',

        // Validation des composantes (modules)
        'modules' => 'required|array|min:1',
        'modules.*.number' => 'required|integer',
        'modules.*.description' => 'required|string|max:255',
        'modules.*.budget_value' => 'required|numeric|min:0', // Le sous-montant de la composante
        'modules.*.duree' => 'required|string|max:100',
    ];
}
}