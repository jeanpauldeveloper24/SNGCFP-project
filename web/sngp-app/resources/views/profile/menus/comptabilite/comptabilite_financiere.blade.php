<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Comptabilité Financière & Engagements</h2>
                <p class="mt-2 text-sm text-gray-600">Analyse de l'exécution budgétaire, des fonds contractuellement engagés et des taux d'absorption.</p>
            </div>
            <div>
                <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                    Analyse Budgétaire
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-gray-400 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dotation Globale Projets</dt>
                <dd class="mt-2 text-xl font-bold text-gray-900">{{ number_format($dotationTotale, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-4">
                <div class="flex justify-between items-start">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Montants Engagés (Contrats)</dt>
                    <span class="text-[10px] font-bold text-cyan-700 bg-cyan-50 px-1.5 py-0.5 rounded">{{ number_format($tauxEngagementGlobal, 1) }}%</span>
                </div>
                <dd class="mt-2 text-xl font-bold text-cyan-700">{{ number_format($totalEngage, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-4">
                <div class="flex justify-between items-start">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ordonnancés & Payés</dt>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">{{ number_format($tauxDecaissementGlobal, 1) }}%</span>
                </div>
                <dd class="mt-2 text-xl font-bold text-emerald-700">{{ number_format($totalPaye, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-red-500 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reliquat Libre (Non engagé)</dt>
                <dd class="mt-2 text-xl font-bold text-red-600">{{ number_format($dotationTotale - $totalEngage, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></dd>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-cyan-700 uppercase tracking-wider">Situation Synthétique de l'Exécution par Ligne de Projet</h3>
            </div>

            @if($situationFinanciere->isEmpty())
                <div class="text-center p-12">
                    <span class="text-4xl">📉</span>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune donnée budgétaire disponible</h3>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th scope="col" class="py-3.5 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Code & Intitulé du Projet</th>
                                <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Dotation (A)</th>
                                <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Engagements (B)</th>
                                <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Décaissements (C)</th>
                                <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Taux d'Engagement (B/A)</th>
                                <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Taux d'Absorption (C/A)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                            @foreach($situationFinanciere as $row)
                                <tr class="hover:bg-gray-50/70 transition-colors text-sm">
                                    
                                    <td class="py-4 pr-3 pl-6 font-bold text-gray-900 max-w-xs truncate">
                                        <span class="text-cyan-700 font-mono text-xs block mb-0.5">[{{ $row['code'] }}]</span>
                                        {{ $row['nom'] }}
                                    </td>
                                    
                                    <td class="px-3 py-4 text-right font-semibold text-gray-800 font-mono">
                                        {{ number_format($row['dotation'], 0, ',', ' ') }}
                                    </td>
                                    
                                    <td class="px-3 py-4 text-right font-medium text-cyan-800 font-mono">
                                        {{ number_format($row['engage'], 0, ',', ' ') }}
                                    </td>
                                    
                                    <td class="px-3 py-4 text-right font-bold text-emerald-700 font-mono">
                                        {{ number_format($row['paye'], 0, ',', ' ') }}
                                    </td>
                                    
                                    <td class="px-3 py-4 text-center">
                                        <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-bold {{ $row['taux_engagement'] >= 70 ? 'bg-cyan-50 text-cyan-700 ring-1 ring-cyan-700/10' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10' }}">
                                            {{ number_format($row['taux_engagement'], 1) }} %
                                        </span>
                                    </td>
                                    
                                    <td class="px-3 py-4 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-bold {{ $row['taux_absorption'] >= 50 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10' : 'bg-red-50 text-red-700 ring-1 ring-red-600/10' }}">
                                                {{ number_format($row['taux_absorption'], 1) }} %
                                            </span>
                                            @if(($row['taux_engagement'] - $row['taux_absorption']) > 40)
                                                <span class="text-[9px] text-red-600 font-semibold uppercase tracking-tighter">⚠️ Retard Décaissement</span>
                                            @endif
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