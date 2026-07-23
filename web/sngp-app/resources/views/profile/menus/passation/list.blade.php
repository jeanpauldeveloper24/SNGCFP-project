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
        <!-- Passage en w-full avec padding horizontal pour occuper tout l'écran -->
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Notification Flash -->
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
                    
                    <!-- Bouton : Initialiser un nouveau marché -->
                    <a href="{{ route('menus.marches.create') }}" class="inline-flex items-center rounded-lg bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 text-xs font-bold transition shadow-sm uppercase tracking-wider whitespace-nowrap">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Initialiser un nouveau marché
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    @if($markets->isEmpty())
                        <div class="p-12 text-center">
                            <div class="text-4xl mb-3">📂</div>
                            <p class="text-sm font-medium text-gray-500">Aucun marché public n'est actuellement enregistré dans le système.</p>
                        </div>
                    @else
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-gray-50 text-gray-400 uppercase font-semibold tracking-wider border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3.5 whitespace-nowrap">N° Référence</th>
                                    <th class="px-4 py-3.5">Objet du Marché</th>
                                    <th class="px-4 py-3.5 whitespace-nowrap">Méthode</th>
                                    <th class="px-4 py-3.5 text-right whitespace-nowrap">Montant Estimé</th>
                                    <th class="px-4 py-3.5 whitespace-nowrap">Étape Actuelle</th>
                                    <th class="px-4 py-3.5 whitespace-nowrap">Statut</th>
                                    <th class="px-4 py-3.5 text-right whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                                @forelse ($markets as $market)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <!-- Référence unique -->
                                        <td class="px-4 py-3.5 font-mono font-bold text-slate-900 text-xs whitespace-nowrap">
                                            {{ $market->numero_reference ?? 'N/A' }}
                                        </td>
                                        
                                        <!-- Objet du Marché -->
                                        <td class="px-4 py-3.5 text-gray-950 font-semibold max-w-md" title="{{ $market->objet }}">
                                            <div class="line-clamp-2">
                                                {{ $market->objet }}
                                            </div>
                                        </td>
                                        
                                        <!-- Méthode de passation -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            <span class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 font-mono text-[10px] font-bold text-gray-800 ring-1 ring-inset ring-gray-600/10">
                                                {{ $market->methode_passation ?? '—' }}
                                            </span>
                                        </td>
                                        
                                        <!-- Montant enregistré -->
                                        <td class="px-4 py-3.5 text-right font-mono font-bold text-gray-900 whitespace-nowrap">
                                            {{ number_format($market->besoin_financier ?? $market->module->besoin_financier ?? 0, 0, ',', ' ') }}
                                            <span class="text-[10px] text-gray-500 font-sans font-normal ml-0.5">
                                                {{ $market->project->budget_devise ?? $market->devise }}
                                            </span>
                                        </td>
                                        
                                        <!-- Étape Actuelle -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            @php
                                                $etapeLibelle = match($market->etape) {
                                                    'EXPRESSION_BESOIN' => 'Expression du besoin',
                                                    'DAO' => 'Rédaction du DAO',
                                                    'LANCEMENT' => 'Appel d\'offres lancé',
                                                    'ATTRIBUTION' => 'En cours d\'attribution',
                                                    default => $market->etape ?? 'Expression du besoin',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-md bg-cyan-50 px-2.5 py-1 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-600/10">
                                                {{ $etapeLibelle }}
                                            </span>
                                        </td>

                                        <!-- Statut -->
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            @php
                                                $statusClass = match($market->status) {
                                                    'Attribué' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/10',
                                                    'Attribution en cour' => 'bg-amber-50 text-amber-700 ring-amber-600/10',
                                                    default => 'bg-slate-100 text-slate-600 ring-slate-500/10',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $statusClass }}">
                                                {{ $market->status ?? 'Non attribué' }}
                                            </span>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                            <a href="{{ route('passation.edit-etape', $market->id) }}" class="inline-flex items-center text-cyan-700 hover:text-cyan-900 font-bold transition bg-cyan-50 hover:bg-cyan-100 px-3 py-1.5 rounded-lg border border-cyan-200/60">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Changer l'étape
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 font-medium">
                                            Aucun marché trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>