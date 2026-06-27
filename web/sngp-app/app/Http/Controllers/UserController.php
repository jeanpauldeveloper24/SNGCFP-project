<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Liste complète des utilisateurs (Membres, Prestataires, Admin)
     */
    public function index()
    {
        // On récupère tous les utilisateurs avec leur relation rôle pour optimiser les requêtes
        $users = User::with('role')->orderBy('name', 'asc')->get();
        
        return view('profile.menus.users.list', compact('users')); 
    }

    /**
     * Formulaire de création d'un nouvel utilisateur
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get(); 
        $user = new User();

        return view('profile.menus.users.form', compact('roles', 'user'));
    }

    /**
     * Enregistrement de l'utilisateur en base de données
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|lowercase|max:255|unique:users,email',
            'phone'    => 'required|string|max:20',
            'role_id'  => 'required|exists:roles,id', 
            'password' => 'required|string|min:8|confirmed', 
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role_id = $validated['role_id']; 

        $user->password = Hash::make($validated['password']);
        
        // Optionnel : attribuer le créateur s'il y a un utilisateur connecté
        if (Auth::check()) {
            $user->created_by = Auth::id();
        }

        $user->save();

        // Harmonisation : redirection vers la route index de ta ressource
// Au lieu de redirect('/users'), utilise le nom exact de ta route :
return redirect()->route('profile.menus.users.list')->with('success', '✅ Utilisateur créé avec succès.');
        }

    /**
     * Formulaire d'édition d'un utilisateur existant
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        
        return view('profile.menus.users.form', compact('user', 'roles'));
    }

    /**
     * Mise à jour de l'utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            // CORRECTION CRUCIAL : On ignore l'ID de l'utilisateur actuel pour éviter le blocage du "unique"
            'email'   => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:users,email,' . $user->id],
            'phone'   => ['required', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status'  => ['required', 'string'], 
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role_id = $validated['role_id'];
        $user->status = $validated['status'];

        $roleModel = Role::find($validated['role_id']);
        $user->role = $roleModel->name;

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.menus.users.index')
            ->with('success', 'Les informations de l\'utilisateur ont été mises à jour.');
    }

    /**
     * Suppression / Révocation d'un utilisateur
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->withErrors('Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('profile.menus.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}