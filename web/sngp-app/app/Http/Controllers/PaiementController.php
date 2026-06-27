<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupération de tous les paiements avec leurs relations (Eager Loading)
        // Triés du plus récent au plus ancien
        $paiements = Paiement::with(['project', 'module', 'market', 'creator'])
            ->orderBy('date_paiement', 'desc')
            ->paginate(15); // Pagination automatique à 15 éléments par page

        // Calculs d'indicateurs rapides pour le tableau de bord
        $totalValide = Paiement::where('status', 'valide')->sum('montant');
        $totalEnCours = Paiement::where('status', 'en_cours')->orWhere('status', 'attente')->sum('montant');
        $totalRejete = Paiement::where('status', 'rejete')->sum('montant');

        return view('profile.menus.paiements', compact('paiements', 'totalValide', 'totalEnCours', 'totalRejete'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // À implémenter plus tard pour le formulaire d'ajout
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaiementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaiementRequest $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        //
    }
}