<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Importe ton modèle Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming API registration request.
     */
    public function store(Request $request)
    {
        // 1. Validation stricte
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', 'string'], // Le slug envoyé par Flutter
            'password' => ['required', Rules\Password::defaults()],
            'photo'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Validation photo
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 2. Gestion de l'upload de la photo
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    // Stocke dans storage/app/public/profiles
                    $photoPath = $request->file('photo')->store('profiles', 'public');
                }

                // 3. Récupération de l'ID du rôle à partir du nom envoyé par Flutter
                $role = Role::where('name', $request->role)->first();
                
                if (!$role) {
                    return response()->json(['message' => 'Rôle invalide'], 422);
                }

                // 4. Création de l'utilisateur
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'phone'    => $request->phone,
                    'password' => Hash::make($request->password),
                    'photo'    => $photoPath, // Enregistre le chemin (ex: profiles/abc.png)
                    'role_id'  => $role->id,   // On lie l'ID du rôle
                ]);

                // 5. Réponse JSON pour Flutter (et non une redirection)
                return response()->json([
                    'message' => 'Utilisateur créé avec succès',
                    'user'    => $user->load('role'),
                    'token'   => $user->createToken('windows_app')->plainTextToken,
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'inscription',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}