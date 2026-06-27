<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Passation de Marchés</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Planification, suivi opérationnel et gestion des Dossiers d'Appel d'Offres (DAO).
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center rounded-md bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 ring-1 ring-inset ring-slate-700/10 uppercase tracking-wider">
                    Cellule de Passation
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Notification Flash Réelle -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-xl shadow-sm text-xs text-emerald-800 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Conteneur Principal / Tableau -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Suivi des Dossiers d'Appel d'Offres (DAO)</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Liste des procédures actives et des méthodes de sélection associées.</p>
                    </div>
                    <!-- Lien vers un formulaire de création de dossier si nécessaire -->
                    <a href="{{ route('passation.creer') }}" class="inline-flex items-center rounded-lg bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 text-xs font-bold transition shadow-sm uppercase tracking-wider">
    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
    </svg>
    Initialiser un nouveau marché
</a>
                </div>
                
                <div class="overflow-x-auto">
                    @if($marches->isEmpty())
                        <div class="p-12 text-center">
                            <div class="text-4xl mb-3">📂</div>
                            <p class="text-sm font-medium text-gray-500">Aucun marché public n'est actuellement enregistré dans le système.</p>
                        </div>
                    @else
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-gray-50 text-gray-400 uppercase font-semibold tracking-wider border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4">N° Référence</th>
                                    <th class="px-6 py-4">Objet du Marché</th>
                                    <th class="px-6 py-4">Méthode</th>
                                    <th class="px-6 py-4 text-right">Montant Estimé</th>
                                    <th class="px-6 py-4">Statut / Étape Actuelle</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                                @foreach($marches as $marche)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <!-- Référence unique de la base de données -->
                                        <td class="px-6 py-4 font-mono font-bold text-slate-900 text-sm">
                                            {{ $marche->numero_reference }}
                                        </td>
                                        
                                        <!-- Objet du Marché réel -->
                                        <td class="px-6 py-4 text-gray-950 font-semibold max-w-xs truncate" title="{{ $marche->objet }}">
                                            {{ $marche->objet }}
                                        </td>
                                        
                                        <!-- Méthode de passation (AON, SFQC, etc.) -->
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 font-mono text-[10px] font-bold text-gray-800 ring-1 ring-inset ring-gray-600/10">
                                                {{ $marche->methode_passation }}
                                            </span>
                                        </td>
                                        
                                        <!-- Montant Réel formaté en FCFA -->
                                        <td class="px-6 py-4 text-right font-mono font-bold text-gray-900">
                                            {{ number_format($marche->montant, 0, ',', ' ') }} CFA
                                        </td>
                                        
                                        <!-- Étape actuelle dynamique -->
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center rounded-md bg-cyan-50 px-2.5 py-1 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-600/10">
                                                {{ $marche->etape_actuelle_libelle }}
                                            </span>
                                        </td>
                                        
                                        <!-- Lien dynamique vers le formulaire de changement d'étape -->
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('passation.edit-etape', $marche->id) }}" class="inline-flex items-center text-cyan-700 hover:text-cyan-900 font-bold transition">
                                                Mettre à jour l'étape →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>