<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Registre des Utilisateurs</h2>
                    <p class="mt-2 text-sm text-gray-600">Liste exhaustive des comptes institutionnels, ministériels, bailleurs (BAD) et prestataires de terrain.</p>
                </div>
                <div>
                    <a href="{{ route('profile.menus.users.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        ➕ Ajouter un Acteur
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-md bg-emerald-50 p-4 border-l-4 border-emerald-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-emerald-600 font-bold">✅</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if(count($users) === 0)
        <div class="text-center p-12">
            <span class="text-4xl">👥</span>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun utilisateur enregistré</h3>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left table-fixed sm:table-auto">
                <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th scope="col" class="w-1/3 py-3.5 pr-3 pl-6 text-sm font-semibold uppercase tracking-wider">Nom & Prénoms</th>
                        <th scope="col" class="w-1/3 px-3 py-3.5 text-sm font-semibold uppercase tracking-wider">Adresse Email</th>
                        <th scope="col" class="w-1/4 px-3 py-3.5 text-sm font-semibold uppercase tracking-wider">Rôle / Fonction</th>
                        <th scope="col" class="w-1/6 relative py-3.5 pr-6 pl-3 text-right text-sm font-semibold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 break-words">
                                {{ $user->name }}
                            </td>
                            
                            <td class="px-3 py-4 text-sm text-gray-600 break-all">
                                {{ $user->email }}
                            </td>
                            
                            <td class="px-3 py-4 text-sm">
    <span class="inline-flex items-center rounded-md bg-cyan-50 px-2 py-1 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
        @if(is_object($user->role) || (bool)json_decode($user->role ?? ''))
            {{-- Si c'est un objet Eloquent ou du JSON stocké, on extrait proprement le nom --}}
            @php 
                $roleData = is_object($user->role) ? $user->role : json_decode($user->role);
            @endphp
            {{ str_replace('_', ' ', $roleData->name ?? 'N/A') }}
        @else
            {{-- Si c'est une chaîne de caractères classique --}}
            {{ str_replace('_', ' ', $user->role) }}
        @endif
    </span>
</td>
                            
                            <td class="py-4 pr-6 pl-3 text-right text-sm font-medium whitespace-nowrap">
                                <div class="inline-flex items-center space-x-3">
                                    
                                    <a href="{{ route('profile.menus.users.edit', $user->id) }}" 
                                       class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-cyan-700 hover:text-cyan-900 bg-cyan-50 hover:bg-cyan-100 px-2.5 py-1.5 rounded transition">
                                        Modifier
                                    </a>

                                    <form action="{{ route('profile.menus.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir révoquer l\'accès de cet utilisateur ? Cette action est irréversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition">
                                            Supprimer
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
        </div>
    </div>
</x-app-layout>