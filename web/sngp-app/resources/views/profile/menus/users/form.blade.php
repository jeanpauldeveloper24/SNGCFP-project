<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <div class="mb-8 border-b border-gray-200 pb-5">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ $user->exists ? 'Modifier l\'Acteur' : 'Ajouter un nouvel Acteur' }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $user->exists ? 'Mise à jour des privilèges et des informations institutionnelles.' : 'Création d\'un compte sécurisé sur la plateforme.' }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
<form action="{{ $user->exists ? route('profile.menus.users.update', $user->id) : route('profile.menus.users.store') }}" method="POST">
            @csrf
                    @if($user->exists)
                        @method('PUT')
                    @endif

                    <div class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Nom & Prénoms</label>
                            <input type="text" name="name" id="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm p-2.5 border @error('name') border-red-500 @enderror" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Adresse Email</label>
                            <input type="email" name="email" id="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm p-2.5 border @error('email') border-red-500 @enderror" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
    <label for="phone" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Numéro de Téléphone <span class="text-red-500">*</span></label>
    <input type="text" name="phone" id="phone" 
           value="{{ old('phone', $user->phone) }}" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm p-2.5 border @error('phone') border-red-500 @enderror" 
           placeholder="Ex: +225 0700000000"
           required>
    @error('phone')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                        {{-- On affiche les blocs de mot de passe UNIQUEMENT si c'est un nouvel utilisateur --}}
@if(!$user->exists)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        
        <div class="space-y-1.5">
            <label for="password" class="block font-bold text-gray-700 uppercase tracking-wider text-[10px]">
                Mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-medium text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-xs @error('password') border-red-500 ring-red-500 @enderror" 
                   required 
                   autocomplete="new-password"
                   placeholder="Minimum 8 caractères">
            @error('password')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label for="password_confirmation" class="block font-bold text-gray-700 uppercase tracking-wider text-[10px]">
                Confirmer le mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-medium text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-xs" 
                   required 
                   placeholder="Répétez le mot de passe">
        </div>

    </div>
@else
    {{-- Optionnel : Petit message informatif si on est en mode Édition --}}
    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-[11px] text-gray-500">
        💡 Pour modifier le mot de passe de cet utilisateur, veuillez passer par l'espace de réinitialisation dédié.
    </div>
@endif

                        <div>
                            <div>
    <label for="role" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Rôle / Fonction</label>
    
    {{-- CORRECTION : name="role" devient name="role_id" --}}
    <select name="role_id" id="role" 
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm p-2.5 border @error('role_id') border-red-500 @enderror" 
            required>
        <option value="">-- Sélectionner un rôle --</option>
        
        @foreach($roles as $role)
            @php
                $roleValue = is_object($role) ? ($role->id ?? $role->name) : $role;
                $roleName = is_object($role) ? $role->name : $role;
                $currentUserRole = is_object($user->role) ? ($user->role->id ?? $user->role->name) : $user->role;
            @endphp
            
            {{-- CORRECTION : old('role', ...) devient old('role_id', ...) --}}
            <option value="{{ $roleValue }}" {{ old('role_id', $currentUserRole) == $roleValue ? 'selected' : '' }}>
                {{ str_replace('_', ' ', $roleName) }}
            </option>
        @endforeach
    </select>
    
    {{-- CORRECTION : @error('role') devient @error('role_id') --}}
    @error('role_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                           <a href="{{ route('profile.menus.users.list') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition uppercase tracking-wider">
    Annuler
</a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition uppercase tracking-wider">
                                {{ $user->exists ? 'Enregistrer les modifications' : 'Créer' }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>