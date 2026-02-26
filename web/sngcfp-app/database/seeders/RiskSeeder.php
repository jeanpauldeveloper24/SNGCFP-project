<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Risk;

class RiskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        // Modèles de risques pour varier les titres
        $templates = [
            ['level' => 'CRITIQUE', 'label' => 'ÉLEVÉ', 'titles' => ['Retard décaissement', 'Blocage chantier', 'Dépassement budget']],
            ['level' => 'MODERE', 'label' => 'MOYEN', 'titles' => ['Risque météo', 'Indisponibilité expert', 'Retard livraison']],
            ['level' => 'MINEUR', 'label' => 'FAIBLE', 'titles' => ['Mise à jour doc', 'Réunion reportée', 'Ajustement planning']],
        ];

        foreach ($projects as $project) {
            for ($i = 0; $i < 5; $i++) {
                // On pioche un type de risque au hasard
                $template = $templates[array_rand($templates)];
                $title = $template['titles'][array_rand($template['titles'])];

                Risk::create([
                    'project_id' => $project->id,
                    'title'      => "$title - " . $project->nom,
                    'level'      => $template['level'],
                    'label'      => $template['label'],
                    'is_archived' => false,
                ]);
            }
        }
    }
}