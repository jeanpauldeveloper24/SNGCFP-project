<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- RÔLES PLATEFORME WEB (Laravel - Gestion & Expertise) ---
        $webRoles = [
            ['name' => 'ADMIN', 'description' => 'Contrôle total du système SNGP-BAD'],
            ['name' => 'COMPTABLE_BAD', 'description' => 'Gestion des écritures comptables et décaissements'],
            ['name' => 'GESTIONNAIRE_BUDGET', 'description' => 'Suivi des engagements et des allocations budgétaires'],
            ['name' => 'SPECIALISTE_MARCHE', 'description' => 'Expert chargé de vérifier la conformité des dossiers'],
            ['name' => 'ORDONNATEUR', 'description' => 'Validation finale et autorisation des paiements'],
            ['name' => 'CONTROLEUR_INTERNE', 'description' => 'Audit, conformité et vérification des processus'],
        ];

        foreach ($webRoles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'platform' => 'laravel_web'
            ]);
        }

        // --- RÔLES PLATEFORME DESKTOP (Flutter - Supervision & Terrain) ---
        $flutterRoles = [
            ['name' => 'badRepresentative', 'description' => 'Représentant de la BAD - Supervision globale'],
            ['name' => 'ministryOfTutelle', 'description' => 'Ministère de tutelle - Suivi institutionnel'],
            ['name' => 'nationalDirection', 'description' => 'Direction Nationale - Pilotage opérationnel'],
            ['name' => 'externalAuditor', 'description' => 'Auditeur Externe - Vérification indépendante'],
            ['name' => 'prestataire', 'description' => 'Prestataire / Entreprise - Exécution des marchés'],
        ];

        foreach ($flutterRoles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'platform' => 'flutter_desktop'
            ]);
        }
    }
}