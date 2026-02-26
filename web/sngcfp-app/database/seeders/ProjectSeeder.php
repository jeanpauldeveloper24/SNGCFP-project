<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/ProjectSeeder.php
public function run()
{
    $projets = [
        ['code' => 'PAIA-2', 'nom' => 'Agro-industrie', 'cat' => 'Travaux Civil', 'alloue' => 45000000000, 'depense' => 28000000000],
        ['code' => 'PTUA', 'nom' => 'Transport Urbain Abidjan', 'cat' => 'Travaux Civil', 'alloue' => 90000000000, 'depense' => 55000000000],
        ['code' => 'PEPT', 'nom' => 'Électricité pour tous', 'cat' => 'Infrastructure', 'alloue' => 60000000000, 'depense' => 42000000000],
        ['code' => 'PSSR', 'nom' => 'Santé Rurale', 'cat' => 'Santé', 'alloue' => 40000000000, 'depense' => 12000000000],
        ['code' => 'PAEPA', 'nom' => 'Eau et Assainissement', 'cat' => 'Infrastructure', 'alloue' => 35000000000, 'depense' => 20000000000],
        ['code' => 'PEJ', 'nom' => 'Emploi Jeunes', 'cat' => 'Social', 'alloue' => 25000000000, 'depense' => 15000000000],
        ['code' => 'PAG', 'nom' => 'Gouvernance Économique', 'cat' => 'Études', 'alloue' => 20000000000, 'depense' => 18000000000],
        ['code' => 'PASC', 'nom' => 'Appui Secteur Cacaoyer', 'cat' => 'Agro', 'alloue' => 50000000000, 'depense' => 35000000000],
        ['code' => 'RSP', 'nom' => 'Route San-Pedro', 'cat' => 'Travaux Civil', 'alloue' => 70000000000, 'depense' => 45000000000],
        ['code' => 'DSP', 'nom' => 'Digitalisation Services', 'cat' => 'Équipements', 'alloue' => 15000000000, 'depense' => 50000000000],
    ];

    foreach ($projets as $p) {
        \App\Models\Project::create([
            'code' => $p['code'],
            'nom' => $p['nom'],
            'categorie' => $p['cat'],
            'budget_alloue' => $p['alloue'],
            'budget_depense' => $p['depense'],
            'fonds_recus_bad' => $p['alloue'] * 0.8, // Simulation : 80% reçus
            'taux_execution' => ($p['depense'] / $p['alloue']) * 100,
        ]);
    }
}
}
