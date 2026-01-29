<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Page de Présentation (DSID & Équipe)
Route::get('/presentation', function () {
    return view('pages.presentation');
})->name('presentation');

// Page de fonctionnalités
Route::get('/fonctionnalites', function () {
    return view('pages.fonctionnalite');
})->name('fonctionnalites');

//contexte d'utilisation
Route::get('/contexte', function () {
    return view('pages.contexte');
})->name('contexte');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //menus principaux
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/comptabilite', function () { return view('profile.menus.comptabilite');})->name('comptabilite.index');
    Route::get('/marches', function () { return view('profile.menus.marches');})->name('marches.index');
    Route::get('/suivi-budgetaire', function () { return view('profile.menus.budget');})->name('budget.index');
    Route::get('/audit', function () { return view('profile.menus.audit'); })->name('audit.index');
    Route::get('/rapports', function () { return view('profile.menus.rapports'); })->name('rapports.index');
    Route::get('/finances-budget', function () { return view('profile.menus.finances'); })->name('finances.index');
    Route::get('/passation', function () { return view('profile.menus.passation'); })->name('passation.index');
    Route::get('/audit-logs', function () { return view('profile.menus.logs'); })->name('audit.logs');
    Route::get('/audit/historique-complet', function () { return view('profile.menus.sous-menus.historique-complet');})->name('audit.historique');
    Route::get('/notifications', function () {return view('profile.menus.notifications');})->name('notifications.index');
    Route::get('/messagerie', function () {return view('profile.menus.messages');})->name('messages.index');
    //sous-menus
    Route::get('/audit-logs/historique', function () {return view('profile.menus.sous-menus.historique-complet');})->name('audit.logs.historique');
});

require __DIR__.'/auth.php';
