<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

// Page de Présentation (DSID & Équipe)
Route::get('/presentation', function () {
    return view('pages.presentation');
})->name('presentation');

// Page de fonctionnalités
Route::get('/fonctionnalites', [ProjectController::class, 'fonctionnalites'])->name('fonctionnalites');

//contexte d'utilisation
Route::get('/contexte', function () {
    return view('pages.contexte');
})->name('contexte');

Route::get('/dashboard', [ProjectController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTES CONNECTÉES AU CONTROLLER (Pour avoir les données de la base de données)
    Route::get('/finances-budget', [ProjectController::class, 'finances'])->name('menus.finances');
    Route::get('/suivi-budgetaire', [ProjectController::class, 'budget'])->name('menus.budget');
    Route::get('/menus/actif', [ProjectController::class, 'actifs'])->name('menus.actif');
    Route::get('/passation', [ProjectController::class, 'passation'])->name('menus.passation');
    Route::get('/marches', function () { return view('profile.menus.marches');})->name('menus.marches');
    Route::get('/comptabilite', [ProjectController::class, 'comptabilite'])->name('menus.comptabilite');
    Route::get('/audit', function () { return view('profile.menus.audit'); })->name('menus.audit');
    Route::get('/rapports', function () { return view('profile.menus.rapports'); })->name('menus.rapports');
    
    Route::get('/logs', function () { return view('profile.menus.logs'); })->name('menus.logs');
    
    Route::get('/notifications', function () {return view('profile.menus.notifications');})->name('menus.notifications');
    Route::get('/messagerie', function () {return view('profile.menus.messages');})->name('menus.messages');
    
    // Sous-menus
Route::get('/menus/sous-menus/historique', function () {return view('profile.menus.sous-menus.historique-complet'); })->name('menus.sous-menus.historique');});

require __DIR__.'/auth.php';
