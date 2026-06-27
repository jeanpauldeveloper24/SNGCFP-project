<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Comptabilité de Gestion & Performance</h2>
                    <p class="mt-2 text-sm text-gray-600">Analyse analytique des coûts par centres d'activités, mesure de l'efficience et contrôle des écarts.</p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                        Pilotage Opérationnel
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Part Affectée aux Infrastructures / Terrain</dt>
                    <dd class="mt-2 text-2xl font-bold text-emerald-700">
                        {{ number_format($ratioTerrain, 1) }} %
                    </dd>
                    <p class="text-[11px] text-gray-400 mt-1">Objectif BAD : > 80% de l'enveloppe globale.</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-amber-600 p-4">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Avenants Contractuels</dt>
                    <dd class="mt-2 text-xl font-bold text-amber-600 font-mono">
                        {{ number_format($totalAvenants, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span>
                    </dd>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-red-500 p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Surcoûts Engagés (Avenants Signés)</dt>
                    <dd class="mt-2 text-2xl font-bold text-red-600">
                        {{ number_format($totalAvenants, 0, ',', ' ') }} <span class="text-xs text-gray-400">FCFA</span>
                    </dd>
                    <p class="text-[11px] text-red-500 font-medium mt-1">⚠️ Impact direct sur l'enveloppe budgétaire révisée.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-cyan-700 uppercase tracking-wider">Matrice Analytique des Coûts par Nature d'Activité</h3>
                    <span class="text-xs font-mono text-gray-400">Structure : Code Éléments Comptables</span>
                </div>

                @if(empty($centresDeCouts))
                    <div class="text-center p-12">
                        <span class="text-4xl">📊</span>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune imputation analytique enregistrée</h3>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left">
                            <thead class="bg-cyan-700 text-white">
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Centre de Coût / Activité</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Budget Estimé</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Coût Réel (Imputé)</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Écart Absolu</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Niveau de Consommation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                                @foreach($centresDeCouts as $centre)
                                    <tr class="hover:bg-gray-50/70 transition-colors text-sm">
                                        
                                        <td class="py-4 pr-3 pl-6 font-bold text-gray-900">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-cyan-700 font-mono text-xs bg-cyan-50 px-2 py-0.5 rounded">{{ $centre['code_analytique'] }}</span>
                                                <span>{{ $centre['libelle'] }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="px-3 py-4 text-right font-medium text-gray-600 font-mono">
                                            {{ number_format($centre['budget_prevu'], 0, ',', ' ') }}
                                        </td>
                                        
                                        <td class="px-3 py-4 text-right font-bold text-gray-900 font-mono">
                                            {{ number_format($centre['cout_reel'], 0, ',', ' ') }}
                                        </td>
                                        
                                        @php
                                            $ecart = $centre['budget_prevu'] - $centre['cout_reel'];
                                        @endphp
                                        <td class="px-3 py-4 text-right font-bold font-mono {{ $ecart >= 0 ? 'text-emerald-700' : 'text-red-600' }}">
                                            {{ $ecart >= 0 ? '+' : '' }}{{ number_format($ecart, 0, ',', ' ') }}
                                        </td>
                                        
                                        <td class="px-3 py-4 text-center">
                                            @php
                                                $tauxConsommation = $centre['budget_prevu'] > 0 ? ($centre['cout_reel'] / $centre['budget_prevu']) * 100 : 0;
                                            @endphp
                                            <div class="flex items-center justify-center space-x-2">
                                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                                    <div class="h-2 rounded-full {{ $tauxConsommation <= 100 ? 'bg-cyan-600' : 'bg-red-500' }}" style="width: {{ min($tauxConsommation, 100) }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold {{ $tauxConsommation > 100 ? 'text-red-600' : 'text-gray-700' }}">
                                                    {{ number_format($tauxConsommation, 0) }} %
                                                </span>
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