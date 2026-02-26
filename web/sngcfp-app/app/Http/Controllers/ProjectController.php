<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Cette méthode centralise les calculs statistiques utilisés dans plusieurs vues
     */
    private function getGlobalStats()
    {
        return [
            'totalAllocated' => Project::sum('budget_alloue'),
            'totalSpent'     => Project::sum('budget_depense'),
            'avgExecution'   => Project::avg('taux_execution') ?? 0,
            'totalCount'     => Project::count(),
        ];
    }

    /**
     * Affiche la liste brute des projets (Index)
     */
    public function index()
    {
        $projects = Project::all();
        $stats = $this->getGlobalStats();

        return view('projects.index', array_merge(['projects' => $projects], $stats));
    }

    /**
     * Page de Présentation / Fonctionnalités
     */
    public function fonctionnalites()
    {
        $projets = Project::all();
        $stats = [
            'total_count' => $projets->count(),
            'total_budget' => $projets->sum('budget_alloue'),
        ];

        return view('pages.fonctionnalite', compact('stats'));
    }

    /**
     * Affiche le Dashboard principal
     */
    public function dashboard()
    {
        $projets = Project::all();
        return view('dashboard', compact('projets'));
    }

    /**
     * Affiche la page Finances (Située dans profile/menus/)
     */
    public function finances()
    {
        $projets = Project::all();
        return view('profile.menus.finances', compact('projets'));
    }

    /**
     * Affiche le suivi Budgétaire
     */
    public function budget()
    {
        $projets = Project::all();
        return view('profile.menus.budget', compact('projets'));
    }

    /**
     * Affiche la gestion des Actifs
     */
    public function actifs()
    {
        $projets = Project::all();
        return view('profile.menus.actif', compact('projets'));
    }

    /**
     * Affiche la Passation de Marchés
     */
    public function passation()
    {
        $projets = Project::all();
        return view('profile.menus.passation', compact('projets'));
    }

    /**
     * Affiche la Comptabilité
     */
    public function comptabilite()
    {
        $projets = Project::all();
        return view('profile.menus.comptabilite', compact('projets'));
    }

    /**
     * Page de présentation générale
     */
    public function presentation()
    {
        $projets = Project::all();
        $stats = [
            'total_count' => $projets->count(),
            'total_budget' => $projets->sum('budget_alloue'),
        ];
        return view('pages.presentation', compact('stats'));
    }
}