<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    /**
     * Liste privée des marchés
     */
    public function index()
    {
        $markets = Market::with(['project', 'module'])->latest()->paginate(10);
        return view('profile.menus.passation.list', compact('markets'));
    }

    /**
     * Formulaire de CRÉATION d'un marché
     */
    public function create()
    {
        $projects = Project::with('modules')->get();
        $prestataires = User::where('role', 'PRESTATAIRE')->get();
        $marche = new Market(); 

        return view('profile.menus.marche-form', compact('projects', 'prestataires', 'marche'));
    }

    /**
     * Formulaire d'ÉDITION du CYCLE DE VIE
     */
    public function editEtape(Market $marche)
    {
        return view('profile.menus.passation.form', compact('marche'));
    }

    /**
     * Mise à jour du CYCLE DE VIE
     */
    public function updateEtape(Request $request, Market $marche)
    {
        $validated = $request->validate([
            'etape'                 => 'required|string',
            'methode_passation'     => 'nullable|string|in:AON,AOI,AOR,COTA',
            'date_changement'       => 'required|date',
            'document_justificatif' => 'nullable|file|mimes:pdf|max:5120',
            'commentaire'           => 'required|string',
        ]);

        if ($request->hasFile('document_justificatif')) {
            $request->file('document_justificatif')->store('justificatifs_marches', 'public');
        }

        $dataToUpdate = [
            'etape' => $validated['etape'],
        ];

        if (!empty($validated['methode_passation'])) {
            $dataToUpdate['methode_passation'] = $validated['methode_passation'];
        }

        $marche->update($dataToUpdate);

        return redirect()->route('passation.index')
            ->with('success', 'L\'étape du marché a été mise à jour avec succès !');
    }

    /**
     * Enregistrement d'un nouveau marché en BDD
     */
    /**
     * Enregistrement d'un nouveau marché en BDD
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'                      => 'required|exists:projects,id',
            'project_module_id'               => 'required|exists:project_modules,id',
            'objet'                           => 'required|string|max:255',
            'methode_passation'               => 'nullable|string',
            'besoin_financier'                => 'required|numeric|min:0',
            'besoins_materiels'               => 'required|array|min:1',
            'besoins_materiels.*.designation' => 'required|string',
            'besoins_materiels.*.quantite'    => 'required|integer|min:1',
            'candidature_start_date'          => 'nullable|date',
            'candidature_end_date'            => 'nullable|date|after_or_equal:candidature_start_date',
            'user_id'                         => 'nullable|exists:users,id',
            'status'                          => 'nullable|string',
            'etape'                           => 'nullable|string',
            'exige_quitus'                    => 'nullable|boolean',
            'exige_cnps'                      => 'nullable|boolean',
            'exige_rccm'                      => 'nullable|boolean',
            'exige_faillite'                  => 'nullable|boolean',
        ]);

        // Charger le projet parent pour récupérer sa devise
        $project = Project::findOrFail($validated['project_id']);

        Market::create([
            'project_id'             => $validated['project_id'],
            'project_module_id'      => $validated['project_module_id'],
            'objet'                  => $validated['objet'],
            'methode_passation'      => $validated['methode_passation'] ?? null,
            'besoin_financier'       => $validated['besoin_financier'],
            'besoins_materiels'      => $validated['besoins_materiels'],
            'devise'                 => $project->currency ?? $project->devise ?? 'FCFA', // Recupère la devise du projet
            'candidature_start_date' => $validated['candidature_start_date'] ?? null,
            'candidature_end_date'   => $validated['candidature_end_date'] ?? null,
            'user_id'                => $validated['user_id'] ?? null,
            'status'                 => $validated['status'] ?? 'Non attribué',
            'etape'                  => $validated['etape'] ?? 'EXPRESSION_BESOIN',
            'exige_quitus'           => $request->boolean('exige_quitus'),
            'exige_cnps'             => $request->boolean('exige_cnps'),
            'exige_rccm'             => $request->boolean('exige_rccm'),
            'exige_faillite'         => $request->boolean('exige_faillite'),
            'created_by'             => Auth::id(),
        ]);

        return redirect()->route('passation.index')
            ->with('success', 'Le marché et son cahier des charges ont été enregistrés avec succès !');
    }
}