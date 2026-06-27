<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Comptabilité Monétaire & Devises</h2>
                    <p class="mt-2 text-sm text-gray-600">Suivi des parités de l'Unité de Compte (UC), arbitrage des devises (USD/EUR) et consolidation des écarts de change.</p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                        Gestion du Risque de Change
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-4">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">1 Unité de Compte (UC/BAD)</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 font-mono">815,45 <span class="text-xs font-medium text-gray-500">XOF</span></dd>
                    <p class="text-[10px] text-cyan-600 mt-1">Cours officiel de la BAD</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-4">
    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">1 Dollar Américain (USD)</dt>
    <dd class="mt-2 text-xl font-bold text-gray-900 font-mono">
        {{ number_format($usdToXof, 2, ',', ' ') }} <span class="text-xs font-medium text-gray-500">XOF</span>
    </dd>
    <p class="text-[10px] text-gray-400 mt-1">
        Mise à jour : Direct API ({{ now()->format('d/m/Y') }})
    </p>
</div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-4">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gains de Change Latents</dt>
                    <dd class="mt-2 text-xl font-bold text-emerald-700 font-mono">+ {{ number_format($totalGainsChange, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-400">XOF</span></dd>
                    <p class="text-[10px] text-emerald-600 font-medium mt-1">Excédents de trésorerie monétaire</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-red-500 p-4">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pertes de Change Constatées</dt>
                    <dd class="mt-2 text-xl font-bold text-red-600 font-mono">- {{ number_format($totalPertesChange, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-400">XOF</span></dd>
                    <p class="text-[10px] text-red-500 font-medium mt-1">⚠️ Impact sur les réserves du projet</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-900">Historique des Opérations Monétaires</h3>
                    <p class="mt-1 text-xs text-gray-500">Liste complète des décaissements et mouvements de fonds validés.</p>
                </div>

                @if($decaissements->isEmpty())
                    <div class="text-center py-12 bg-white">
                        <span class="text-4xl text-gray-300">📊</span>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune opération monétaire enregistrée</h3>
                        <p class="mt-1 text-xs text-gray-500">Aucun flux financier ou décaissement n'a encore été validé dans le système.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left">
                            <thead class="bg-cyan-700 text-white">
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Date Valeur</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Référence Pièce</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Projet Imputé</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Étape Administrative / Jalon</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Montant Décaissé</th>
                                </tr>
                            </table>
                            <table class="min-w-full divide-y divide-gray-200 text-left">
                            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                                @foreach($decaissements as $operation)
                                    <tr class="hover:bg-gray-50/70 transition-colors text-sm">
                                        <td class="whitespace-nowrap py-4 pr-3 pl-6 font-medium text-gray-900 font-mono">
                                            {{ $operation->date_paiement ? \Carbon\Carbon::parse($operation->date_paiement)->format('d/m/Y') : '—' }}
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-3 py-4 font-mono text-xs text-cyan-800 font-semibold">
                                            {{ $operation->references ?? 'VIR-SANS-REF' }}
                                        </td>
                                        
                                        <td class="px-3 py-4 text-xs font-semibold text-gray-900 font-mono">
                                            @if($operation->project)
                                                <span class="inline-flex items-center rounded-md bg-cyan-50 px-2 py-1 text-cyan-700 ring-1 ring-inset ring-cyan-700/10">
                                                    {{ $operation->project->code }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">Aucun projet</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-3 py-4 text-xs text-gray-600">
                                            {{ $operation->etape_administrative ?? 'Non spécifiée' }}
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-3 py-4 text-right font-bold text-red-600 font-mono">
                                            - {{ number_format($operation->montant, 0, ',', ' ') }} {{ $operation->devise ?? 'FCFA' }}
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