<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="mb-8 border-b border-gray-200 pb-5 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Registre Global des Paiements</h2>
                            <p class="mt-2 text-sm text-gray-600">Suivi des décaissements réels, ordonnancements et étapes d'arbitrage du SNGCFP-project.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-medium text-cyan-700 ring-1 ring-inset ring-cyan-700/10">
                                📊 Banque Africaine de Développement (BAD) & État
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-10">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Flux Décaissés (Validés)</p>
                                <p class="mt-2 text-2xl font-bold text-emerald-700 font-mono">{{ number_format($totalValide ?? 0, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></p>
                            </div>
                            <span class="text-3xl p-3 bg-emerald-50 rounded-lg text-emerald-700">✅</span>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Engagements en Cours</p>
                                <p class="mt-2 text-2xl font-bold text-amber-600 font-mono">{{ number_format($totalEnCours ?? 0, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></p>
                            </div>
                            <span class="text-3xl p-3 bg-amber-50 rounded-lg text-amber-600">⏳</span>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Flux Rejetés / En Litige</p>
                                <p class="mt-2 text-2xl font-bold text-red-600 font-mono">{{ number_format($totalRejete ?? 0, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></p>
                            </div>
                            <span class="text-3xl p-3 bg-red-50 rounded-lg text-red-600">❌</span>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Historique Analytique des Règlements</h3>
                            <span class="text-xs text-gray-500">Affichage de {{ $paiements->count() }} transaction(s)</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left">
                                <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">Date & Réf</th>
                                        <th class="px-6 py-3">Projet / Module</th>
                                        <th class="px-6 py-3">Marché / Prestataire</th>
                                        <th class="px-6 py-3">Montant</th>
                                        <th class="px-6 py-3">Étape Administrative</th>
                                        <th class="px-6 py-3">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-xs text-gray-700 font-medium">
                                    @forelse($paiements as $p)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-bold text-gray-950 font-mono">{{ $p->date_paiement ? $p->date_paiement->format('d/m/Y') : 'N/A' }}</div>
                                                <div class="text-[10px] text-gray-400 font-mono mt-0.5" title="Référence transaction">{{ $p->references ?? 'Sans réf.' }}</div>
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                <div class="text-gray-900 font-semibold max-w-xs truncate" title="{{ $p->project->nom ?? 'Projet indéfini' }}">
                                                    {{ $p->project->code ?? 'N/A' }} - {{ $p->project->nom ?? 'Projet indéfini' }}
                                                </div>
                                                <div class="text-[11px] text-cyan-700 mt-0.5">
                                                    🧩 {{ $p->module->nom ?? 'Composante générale' }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="text-gray-800 truncate max-w-xs" title="{{ $p->market->objet ?? 'Marché direct' }}">
                                                    {{ $p->market->num_marche ?? 'N/A' }} : {{ Str::limit($p->market->objet ?? 'N/A', 40) }}
                                                </div>
                                                @if($p->user_id_prestataire)
                                                    <div class="text-[10px] text-gray-400 mt-0.5 font-mono">ID Prestataire: #{{ $p->user_id_prestataire }}</div>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right font-bold font-mono text-gray-950 bg-gray-50/50">
                                                <span>{{ number_format($p->montant, 0, ',', ' ') }}</span>
                                                <span class="text-[10px] text-gray-400 font-sans ml-1">{{ $p->devise ?? 'CFA' }}</span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-[11px] font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                                    🏛️ {{ ucfirst(str_replace('_', ' ', $p->etape_administrative ?? 'Saisie initialisée')) }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($p->status === 'valide' || $p->status === 'paye')
                                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">● Validé</span>
                                                @elseif($p->status === 'rejete' || $p->status === 'annule')
                                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-[11px] font-bold text-red-700 ring-1 ring-inset ring-red-600/20">● Rejeté</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20">● En traitement</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                                <div class="text-3xl mb-2">📥</div>
                                                Aucun paiement n'est actuellement enregistré dans la base de données.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($paiements->hasPages())
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                {{ $paiements->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>