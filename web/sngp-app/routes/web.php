<?php



use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ProjectController;

use App\Http\Controllers\MarketController; // Contrôleur de la vitrine publique des marchés

use App\Http\Controllers\UserController;   // Contrôleur pour la gestion des utilisateurs

use App\Http\Controllers\PaiementController;

use Illuminate\Support\Facades\Route;

use App\Models\Project;

use App\Models\Candidature;

use App\Models\AuditLog;

use App\Models\Market;



/*

|--------------------------------------------------------------------------

| Routes Publiques (Accessibles à tous les visiteurs & candidats)

|--------------------------------------------------------------------------

*/



Route::get('/', function () {

    return view('welcome');

});



// Page de Présentation (DSID & Équipe)

Route::get('/presentation', function () {

    return view('pages.presentation');

})->name('presentation');



// Page de fonctionnalités

Route::get('/fonctionnalites', [ProjectController::class, 'fonctionnalites'])->name('fonctionnalites');



// Contexte d'utilisation

Route::get('/contexte', function () {

    return view('pages.contexte');

})->name('contexte');



// VITRINE PUBLIQUE DES MARCHÉS : Consultations et Dépôts de candidatures

Route::get('/opportunites', [MarketController::class, 'indexPublique'])->name('pages.marches.liste');

Route::get('/opportunites/marche/{id}', [MarketController::class, 'showPublique'])->name('pages.marches.show');

Route::post('/opportunites/marche/{id}/soumettre', [MarketController::class, 'soumettreCandidature'])->name('pages.marches.soumettre');





/*

|--------------------------------------------------------------------------

| Routes Protégées (Accessibles uniquement aux utilisateurs connectés)

|--------------------------------------------------------------------------

*/



Route::get('/dashboard', function () {
    // Récupérer les projets (tu peux adapter avec un paginate() ou un where() selon tes besoins)
    $projects = Project::all(); 

    // Passer la variable $projects à la vue
    return view('dashboard', compact('projects'));
})->name('dashboard');



Route::middleware('auth')->group(function () {

   

    // 1. GESTION DU PROFIL PERSONNEL (Compte de l'utilisateur connecté)

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    // 2. GESTION ADMINISTRATIVE DES UTILISATEURS DU SYSTÈME (Par l'Admin)

    Route::get('/users', [UserController::class, 'index'])->name('profile.menus.users.list');

    Route::get('/users/create', [UserController::class, 'create'])->name('profile.menus.users.create');

    Route::post('/users/store', [UserController::class, 'store'])->name('profile.menus.users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('profile.menus.users.edit');

    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('profile.menus.users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('profile.menus.users.destroy');



    // 3. ROUTES FINANCIÈRES ET COMPTABLES

    Route::get('/finances-budget', [ProjectController::class, 'finances'])->name('menus.finances');

    Route::get('/suivi-budgetaire', [ProjectController::class, 'budget'])->name('profile.menus.budget');



    Route::get('/comptabilite/financiere', [ProjectController::class, 'comptabiliteFinanciere'])->name('profile.menus.comptabilite.comptabilite_financiere');

    Route::get('/comptabilite/caisse', [ProjectController::class, 'comptabiliteCaisse'])->name('profile.menus.comptabilite.comptabilite_caisse');

    Route::get('/comptabilite/actif', [ProjectController::class, 'comptabiliteActif'])->name('profile.menus.comptabilite.comptabilite_actif');

    Route::get('/comptabilite/gestion', [ProjectController::class, 'comptabiliteGestion'])->name('profile.menus.comptabilite.comptabilite_gestion');

    Route::get('/comptabilite/monetaire', [ProjectController::class, 'comptabiliteMonetaire'])->name('profile.menus.comptabilite.comptabilite_monetaire');



    Route::get('/rapports', function () { return view('profile.menus.rapports'); })->name('menus.rapports');

    Route::get('/paiements', [PaiementController::class, 'index'])->name('menus.paiements');



    // ========================================================================

    // GESTION DU PORTEFEUILLE DES PROJETS

    Route::get('/projets', [ProjectController::class, 'dashboard'])->name('profile.menus.projects.list');

    Route::get('/projets/creer', [ProjectController::class, 'create'])->name('menus.projects.form');

    Route::post('/projets/stocker', [ProjectController::class, 'store'])->name('menus.projects.store');

    Route::get('/projets/{id}/editer', [ProjectController::class, 'edit'])->name('menus.projects.edit');

    Route::put('/projets/{id}/mettre-a-jour', [ProjectController::class, 'update'])->name('menus.projects.update');



   // ========================================================================

// GESTION INTERNE DES MARCHÉS & PASSATION (Suivi Réel des Étapes / DAO)

// ========================================================================



// 1. La Liste des marchés en cours de passation (avec filtres par étape, statut, etc.)

Route::get('/passation', [ProjectController::class, 'passationIndex'])

    ->name('passation.index');



// 2. Le Formulaire pour modifier l'étape de la passation de marché (DAO, Analyse, Attribution, etc.)

Route::get('/passation/{id}/etape', [ProjectController::class, 'editEtape'])

    ->name('passation.edit-etape');



// 3. Le Traitement de la mise à jour de l'étape de la passation de marché

Route::put('/passation/{id}/mettre-a-jour', [ProjectController::class, 'updateEtape'])

    ->name('passation.update-etape');

    // Initialisation d'un marché depuis le formulaire unique (tri.blade.php)
Route::get('/passation/initialiser', [MarketController::class, 'create'])->name('passation.creer');
Route::post('/passation/initialiser', [MarketController::class, 'storeMarket'])->name('passation.store');
   

    // ========================================================================

    // REGISTRE DES CANDIDATURES

    // ========================================================================

    Route::get('/liste-candidatures', function () {

        $candidatures = Candidature::latest()->get();

        return view('profile.menus.candidatures.liste', compact('candidatures'));

    })->name('menus.candidatures.liste');



    // 5. SYSTEME & LOGS D'AUDIT

    Route::get('/audit', function () {

        $totalMarketsCount = class_exists(Market::class) ? Market::count() : 0;

        $certifiedCount = class_exists(Market::class) ? Market::where('status', 'Validé')->count() : 0;

        $alertCount = class_exists(Market::class) ? Market::where('status', 'En Alerte')->count() : 0;

        $logs = AuditLog::with('user')->latest()->get();



        return view('profile.menus.audit', compact('totalMarketsCount', 'certifiedCount', 'alertCount', 'logs'));

    })->name('menus.audit');



    // 6. MESSAGERIE & NOTIFICATIONS

    Route::get('/notifications', function () { return view('profile.menus.notifications'); })->name('menus.notifications');

    Route::get('/messagerie', function () { return view('profile.menus.messages'); })->name('menus.messages');

   

    // 7. SOUS-MENUS

    Route::get('/menus/sous-menus/historique', function () {

        return view('profile.menus.sous-menus.historique-complet');

    })->name('menus.sous-menus.historique');



});



require __DIR__.'/auth.php';