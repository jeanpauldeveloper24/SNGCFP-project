<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;

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
            'created_by'             => Auth::id(),
        ]);

        return redirect()->route('passation.index')
            ->with('success', 'Le marché et son cahier des charges ont été enregistrés avec succès !');
    }

    /**
     * Affiche la liste publique des marchés / opportunités.
     */
    public function indexPublique()
    {
        // Récupère les marchés (avec possibilité de filtrer par statut publié)
        $markets = Market::with(['project', 'module'])->latest()->get();

        return view('pages.marche.liste', compact('markets'));
    }

    /**
 * Affiche les détails d'un marché spécifique en accès public.
 */
public function showPublique($id)
{
    // Charge le marché avec ses vraies relations (project et module)
    $marche = Market::with(['project', 'module'])->findOrFail($id);

    // Retourne la vue 'candidature-form.blade.php'
    return view('pages.candidature-form', compact('marche'));
}

// postuler pour un marché spécifique
public function postuler(Request $request, $id)
{
    // 1. Récupération directe du marché
    $marche = Market::findOrFail($id);

    // 2. Validation des champs
    $validated = $request->validate([
        'nom_candidat'              => 'required|string|max:255',
        'numero_registre_commerce'  => 'required|string|max:100',
        
        // Documents administratifs
        'file_rccm'                 => 'required|file|mimes:pdf|max:10240',
        'file_acte_constitution'    => 'nullable|file|mimes:pdf|max:10240',
        'file_dfe'                  => 'required|file|mimes:pdf|max:10240',
        'file_arf'                  => 'required|file|mimes:pdf|max:10240',
        'file_cnps'                 => 'required|file|mimes:pdf|max:10240',
        'file_attestation_bancaire' => 'required|file|mimes:pdf|max:10240',
        
        // Offres financière & technique
        'proposition_financiere'     => 'required|numeric|min:0',
        'propositions_techniques'    => 'nullable|array', // Avec "s" pour matcher la Blade !
        'propositions_techniques.*.designation' => 'nullable|string',
        'propositions_techniques.*.quantite'    => 'nullable|numeric|min:0',
    ]);

    // 3. Stockage des Fichiers PDF dans le storage public
    $pathRccm     = $request->file('file_rccm')->store('candidatures/rccm', 'public');
    $pathDfe      = $request->file('file_dfe')->store('candidatures/dfe', 'public');
    $pathArf      = $request->file('file_arf')->store('candidatures/arf', 'public');
    $pathCnps     = $request->file('file_cnps')->store('candidatures/cnps', 'public');
    $pathBancaire = $request->file('file_attestation_bancaire')->store('candidatures/attestations_bancaires', 'public');

    $pathActeConstitution = $request->hasFile('file_acte_constitution') 
        ? $request->file('file_acte_constitution')->store('candidatures/actes_constitution', 'public') 
        : null;

    // 4. --- ALGORITHME D'ÉVALUATION AUTOMATIQUE ---
    $estAccepte = true;
    $motifsRefus = [];

    // A. Évaluation Financière
    $budgetMax = $marche->besoin_financier ?? $marche->montant_max ?? null;

    if ($budgetMax !== null && $validated['proposition_financiere'] > $budgetMax) {
        $estAccepte = false;
        $motifsRefus[] = "La proposition financière (" . number_format($validated['proposition_financiere'], 0, ',', ' ') . " FCFA) dépasse le budget maximal autorisé de " . number_format($budgetMax, 0, ',', ' ') . " FCFA.";
    }

    // B. Évaluation Technique
    $besoinsRequis = is_string($marche->besoins_materiels) 
        ? json_decode($marche->besoins_materiels, true) 
        : $marche->besoins_materiels;

    $propositionsSaisies = $validated['propositions_techniques'] ?? [];

    if (is_array($besoinsRequis)) {
        foreach ($besoinsRequis as $index => $item) {
            $designation = $item['designation'] ?? $item['nom'] ?? "Article #".($index + 1);
            $qteRequise  = (int) ($item['quantite'] ?? 1);

            // On cherche la quantité que le candidat a saisie pour cette désignation précise
            $qteProposee = 0;
            foreach ($propositionsSaisies as $prop) {
                if (isset($prop['designation']) && $prop['designation'] === $designation) {
                    $qteProposee = (int) ($prop['quantite'] ?? 0);
                    break;
                }
            }

            // Vérification si la quantité proposée est suffisante
            if ($qteProposee < $qteRequise) {
                $estAccepte = false;
                $motifsRefus[] = "Quantité insuffisante pour '{$designation}' : {$qteProposee} proposée(s) vs {$qteRequise} requise(s).";
            }
        }
    }

    // Détermination du statut final
    $status = $estAccepte ? 'Accepté' : 'Rejeté';
    $motifStatut = $estAccepte 
        ? 'Candidature conforme aux exigences financières et techniques du cahier des charges.' 
        : implode(' | ', $motifsRefus);

    // 5. Enregistrement en Base de Données
    $candidature = Candidature::create([
        'marche_id'                 => $marche->id,
        'nom_candidat'              => $validated['nom_candidat'],
        'numero_registre_commerce'  => $validated['numero_registre_commerce'],
        
        // Fichiers PDF
        'file_rccm'                 => $pathRccm,
        'file_acte_constitution'    => $pathActeConstitution,
        'file_dfe'                  => $pathDfe,
        'file_arf'                  => $pathArf,
        'file_cnps'                 => $pathCnps,
        'file_attestation_bancaire' => $pathBancaire,

        // Propositions
        'proposition_financiere'    => $validated['proposition_financiere'],
        'proposition_technique'     => json_encode($propositionsSaisies), // Sauvegarde du tableau [designation, quantite]
        
        // Résultats de l'évaluation
        'status'                    => $status,
        'motif_statut'              => $motifStatut,
    ]);

    // 6. Message de retour
    if ($estAccepte) {
        return back()->with('success', 'Votre candidature et vos documents ont été validés et retenus avec succès !');
    } else {
        return back()->with('warning', 'Votre candidature a été enregistrée mais non retenue : ' . $motifStatut);
    }
}

}