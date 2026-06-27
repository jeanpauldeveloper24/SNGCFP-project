<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validation de base des champs du formulaire
        $request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => [
        'required', 
        'string', 
        'lowercase', 
        'max:255', 
        'regex:/^.+@.+\..+$/', 
        'unique:users,email' // <-- Ici, on cible directement la table "users"
    ],
    'phone' => ['required', 'string', 'max:20'],
    'role_id' => ['required', 'integer'],
    'password' => ['required', 'confirmed', Password::defaults()],
]);

        // 2. Récupération du rôle ciblé pour vérification
        $role = Role::findOrFail($request->role_id);

        // Security Check 1 : Sécurité au niveau du serveur (Anti-bypass par modification de l'HTML)
        if (!in_array($role->name, ['administrateur_systeme', 'ordonnateur'])) {
            throw ValidationException::withMessages([
                'role_id' => 'Action non autorisée. Seuls les Administrateurs et les Ordonnateurs peuvent s\'inscrire.',
            ]);
        }

        // Security Check 2 : Limite stricte à MAX 1 Ordonnateur dans tout le système
        if ($role->name === 'ordonnateur') {
            $ordonnateurCount = User::where('role_id', $role->id)->count();
            if ($ordonnateurCount >= 1) {
                throw ValidationException::withMessages([
                    'role_id' => 'Le quota maximal d\'Ordonnateur (1) pour cette plateforme a été atteint. Veuillez contacter la direction.',
                ]);
            }
        }

        // Security Check 3 : Limite stricte à MAX 2 Administrateurs dans tout le système
        if ($role->name === 'administrateur_systeme') {
            $adminCount = User::where('role_id', $role->id)->count();
            if ($adminCount >= 2) {
                throw ValidationException::withMessages([
                    'role_id' => 'Le quota maximal d\'Administrateurs Système (2) a été atteint. Inscription bloquée.',
                ]);
            }
        }

        // 3. Création de l'utilisateur si tous les feux sont au vert
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password), // Utilise le helper bcrypt natif
            'status' => 'Actif', // Compte actif par défaut à l'inscription
            'photo' => null, // Sera mis à jour plus tard par l'utilisateur (Base64)
            'created_by' => null, // Auto-inscription donc pas de créateur parent
            'last_connection' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}