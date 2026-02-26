<?php

use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\Message;
use App\Models\Marche;
use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes - SNGP-BAD Dashboard
|--------------------------------------------------------------------------
*/

// --- 1. ROUTES PUBLIQUES (Auth) ---

//creation d'un utilisateur
Route::post('/register', function (Request $request) {
    $role = Role::where('name', $request->role)->first();
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role_id' => $role ? $role->id : 1, 
        'status' => 'actif',
    ]);
    return response()->json(['message' => 'Utilisateur créé avec succès'], 201);
});

//connexion d'un utilisateur
Route::post('/login', function (Request $request) {
    $user = App\Models\User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Identifiants incorrects'], 401);
    }

    $user->load('role'); // INDISPENSABLE

    if (!$user->role || $user->role->platform !== 'flutter_desktop') {
        return response()->json(['message' => 'Accès refusé'], 403);
    }

    return response()->json([
        'token' => $user->createToken('windows_app')->plainTextToken,
        'user' => $user
    ]);
});
// --- 2. ROUTES PROTÉGÉES (Sanctum) ---

Route::middleware('auth:sanctum')->group(function () {
    
    // --- GESTION DE L'UTILISATEUR ---
    Route::get('/user', function (Request $request) {
        return $request->user()->load('role');
    });

    Route::put('/users/{id}', function (Request $request, $id) {
        if (Auth::id() != $id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Utilisateur introuvable'], 404);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return response()->json(['status' => 'success', 'user' => $user]);
    });

    // --- GESTION DES PROJETS ---
    Route::get('/projets', function () {
        return Project::orderBy('nom', 'asc')->get();
    });

    Route::get('/projets/{id}', function ($id) {
        $project = Project::find($id);
        return $project ? response()->json($project) : response()->json(['message' => 'Inexistant'], 404);
    });

    // --- STATISTIQUES (KPI) ---
    Route::get('/stats/kpi', function () {
        return [
            'total_projets' => Project::count(),
            'budget_global' => Project::sum('budget_alloue'),
            'taux_moyen' => Project::avg('taux_execution') ?? 0,
        ];
    });

    // --- MESSAGERIE ---
    Route::get('/contacts', function () {
        return User::where('id', '!=', Auth::id())->get();
    });

    Route::get('/messages/{receiverId}', function ($receiverId) {
        $myId = Auth::id();
        return Message::where(function($q) use ($receiverId, $myId) {
            $q->where('sender_id', $myId)->where('receiver_id', $receiverId);
        })->orWhere(function($q) use ($receiverId, $myId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $myId);
        })->orderBy('created_at', 'asc')->get();
    });

    Route::post('/messages', function (Request $request) {
        $fileUrl = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('chat_files', 'public');
            $fileUrl = asset('storage/' . $path);
        }

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content'     => $request->content,
            'file_url'    => $fileUrl,
        ]);
        return response()->json($message);
    });

    // --- GESTION DES MARCHÉS ---
    Route::get('/marches', function () {
        return Marche::orderBy('created_at', 'desc')->get();
    });

    Route::post('/marches', function (Request $request) {
        $lastId = Marche::count() + 1;
        $marche = Marche::create([
            'ref' => "DAO-2026-" . (40 + $lastId),
            'objet' => $request->objet,
            'procedure' => $request->procedure,
            'user_id' => Auth::id(),
        ]);
        return response()->json($marche, 201);
    });

    // --- GESTION DES RISQUES (Filtrage & Archivage) ---
    Route::get('/risks', function () {
        // On ne récupère que ceux qui ne sont pas archivés (non résolus)
        return Risk::with('project')
            ->where('is_archived', false)
            ->orderBy('level', 'asc')
            ->get();
    });

    Route::put('/risks/{id}/archive', function ($id) {
        $risk = Risk::find($id);
        if (!$risk) return response()->json(['message' => 'Risque introuvable'], 404);

        $risk->update(['is_archived' => true]);
        return response()->json(['message' => 'Risque marqué comme résolu et archivé']);
    });

    // --- DÉCONNEXION ---
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté avec succès']);
    });
});