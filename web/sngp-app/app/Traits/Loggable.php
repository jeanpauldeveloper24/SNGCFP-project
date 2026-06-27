<?php

namespace App\Traits;

use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    /**
     * Cette méthode est appelée automatiquement par Laravel 
     * lors de l'initialisation de n'importe quel modèle qui utilise ce Trait.
     */
    public static function bootLoggable(): void
    {
        // 1. CAPTURER LES CRÉATIONS (CREATE)
        static::created(function ($model) {
            $nomModele = class_basename($model);
            
            // On essaie de récupérer un attribut lisible pour la description (titre, nom, ou l'ID par défaut)
            $identifiant = $model->title ?? $model->name ?? $model->designation ?? "ID: {$model->id}";
            
            AuditService::log('CREATE', "Création d'un enregistrement dans [{$nomModele}] -> {$identifiant}");
        });

        // 2. CAPTURER LES MODIFICATIONS (UPDATE)
        static::updated(function ($model) {
            $nomModele = class_basename($model);
            $identifiant = $model->title ?? $model->name ?? $model->designation ?? "ID: {$model->id}";
            
            // Récupérer uniquement les champs qui ont réellement changé
            $changements = array_keys($model->getChanges());
            
            // On ignore le champ 'updated_at' pour ne pas polluer l'affichage des logs
            $filtreChamps = array_filter($changements, fn($champ) => $champ !== 'updated_at');
            $champsModifies = implode(', ', $filtreChamps);

            if (!empty($filtreChamps)) {
                AuditService::log('UPDATE', "Modification dans [{$nomModele}] -> {$identifiant}. Champs modifiés : [{$champsModifies}]");
            }
        });

        // 3. CAPTURER LES SUPPRESSIONS (DELETE)
        static::deleted(function ($model) {
            $nomModele = class_basename($model);
            $identifiant = $model->title ?? $model->name ?? $model->designation ?? "ID: {$model->id}";
            
            AuditService::log('DELETE', "Suppression définitive d'un enregistrement de [{$nomModele}] -> {$identifiant}");
        });
    }
}