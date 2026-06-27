<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Arbitrage & Planification Budgétaire</h2>
                <p class="mt-2 text-sm text-gray-600">Espace de décision : Allocation des enveloppes de départ, virements de crédits et ajustements structurels.</p>
            </div>
            <div>
                <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                    Autorité de Réallocation
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-md bg-emerald-50 p-4 border-l-4 border-emerald-600">
                <div class="flex">
                    <div class="flex-shrink-0"><span class="text-emerald-600 font-bold">✅</span></div>
                    <div class="ml-3"><p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p></div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-600">
                <div class="flex">
                    <div class="flex-shrink-0"><span class="text-red-600 font-bold">⚠️</span></div>
                    <div class="ml-3"><p class="text-sm font-medium text-red-800">{{ session('error') }}</p></div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
                <div class="border-b border-gray-100 pb-3 mb-4">
                    <h3 class="text-sm font-bold text-cyan-700 uppercase tracking-wider flex items-center">
                        <span class="mr-2">🔄</span> Mouvement de Crédits
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Transférer des fonds d'une ligne excédentaire vers une ligne déficitaire.</p>
                </div>

                <form action="{{ route('profile.menus.budget') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="source_project_id" class="block text-xs font-semibold text-gray-700 uppercase">Ligne Source (Débit)</label>
                        <select name="source_project_id" id="source_project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-medium text-gray-800" required>
                            <option value="" disabled selected>-- Choisir le compte à débiter --</option>
                            @foreach($projects as $proj)
<option value="{{ $proj->id }}">[{{ $proj->code }}] Disponibilité : {{ number_format($proj->budget_value - $proj->paiements->where('status', 'valide')->sum('montant'), 0, ',', ' ') }} CFA</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="target_project_id" class="block text-xs font-semibold text-gray-700 uppercase">Ligne Cible (Crédit)</label>
                        <select name="target_project_id" id="target_project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-medium text-gray-800" required>
                            <option value="" disabled selected>-- Choisir le compte à créditer --</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}">[{{ $proj->code }}] {{ Str::limit($proj->nom, 35) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="montant" class="block text-xs font-semibold text-gray-700 uppercase">Montant à Transférer (FCFA)</label>
                        <input type="number" name="montant" id="montant" min="1" placeholder="ex: 5000000" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-mono font-bold" required>
                    </div>

                    <div>
                        <label for="justification" class="block text-xs font-semibold text-gray-700 uppercase">Motif / Réf Non-Objection BAD</label>
                        <textarea name="justification" id="justification" rows="3" placeholder="ex: Suite à l'avenant N°2 ou décision de réallocation du comité de pilotage..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs" required></textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2.5 px-4 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        ⚡ Valider le Virement de Crédit
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Enveloppes Budgétaires Actuelles par Ligne de Projet</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
                            <thead class="bg-cyan-700 text-white">
                                <tr>
                                    <th class="py-3 px-4 font-bold uppercase tracking-wider">Projet</th>
                                    <th class="px-3 py-3 font-bold uppercase tracking-wider text-right">Budget Initial</th>
                                    <th class="px-3 py-3 font-bold uppercase tracking-wider text-right">Ajustements +/-</th>
                                    <th class="px-3 py-3 font-bold uppercase tracking-wider text-right">Budget Révisé</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                                @foreach($projects as $project)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="py-3 px-4 font-bold text-gray-900">
                                            <span class="text-cyan-700 font-mono">[{{ $project->code }}]</span> {{ Str::limit($project->nom, 45) }}
                                        </td>
                                        <td class="px-3 py-3 text-right font-mono font-medium text-gray-500">
                                            {{ number_format($project->budget_initial ?? $project->budget_value, 0, ',', ' ') }}
                                        </td>
                                        @php 
                                            $statMouvements = $project->budget_value - ($project->budget_initial ?? $project->budget_value);
                                        @endphp
                                        <td class="px-3 py-3 text-right font-mono font-bold {{ $statMouvements >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{ $statMouvements >= 0 ? '+' : '' }}{{ number_format($statMouvements, 0, ',', ' ') }}
                                        </td>
                                        <td class="px-3 py-3 text-right font-mono font-bold text-cyan-800 bg-cyan-50/30">
                                            {{ number_format($project->budget_value, 0, ',', ' ') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Registre Historique des Arbitrages et Réallocations</h3>
                    </div>
                    
                    @if($revisions->isEmpty())
                        <div class="text-center p-8 text-gray-400 italic">
                            🔄 Aucun virement ou réallocation de crédit effectué à ce jour.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-2.5 px-4 font-bold uppercase">Date</th>
                                        <th class="px-3 py-2.5 font-bold uppercase">Flux Opérationnel</th>
                                        <th class="px-3 py-2.5 font-bold uppercase text-right">Montant Transféré</th>
                                        <th class="px-3 py-2.5 font-bold uppercase">Motif / Justification</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white text-gray-600">
                                    @foreach($revisions as $rev)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="py-3 px-4 font-mono text-gray-400 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($rev->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-3 py-3">
                                                <div class="flex flex-col gap-0.5">
                                                    <span class="text-red-600 font-medium">📉 Débit : {{ $rev->sourceProject->code }}</span>
                                                    <span class="text-emerald-600 font-medium">📈 Crédit : {{ $rev->targetProject->code }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 text-right font-mono font-bold text-gray-900 whitespace-nowrap">
                                                {{ number_format($rev->montant, 0, ',', ' ') }} CFA
                                            </td>
                                            <td class="px-3 py-3 max-w-xs break-words italic text-gray-500">
                                                {{ $rev->justification }}
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

    </div>
</div>
</x-app-layout>