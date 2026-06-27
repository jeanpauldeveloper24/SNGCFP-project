<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="mb-8 border-b border-gray-200 pb-5">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Portefeuille Financier Unique</h2>
                        <p class="mt-2 text-sm text-gray-600">Console de supervision macro-financière du SNGCFP-project. Sélectionnez un sous-système analytique.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-10">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Enveloppe Globale Engagée</p>
                                <p class="mt-2 text-2xl font-bold text-gray-900 font-mono">{{ number_format($totalEngage ?? 0, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></p>
                            </div>
                            <span class="text-3xl p-3 bg-cyan-50 rounded-lg text-cyan-700">💼</span>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Décaissements Effectifs (Cash out)</p>
                                <p class="mt-2 text-2xl font-bold text-emerald-700 font-mono">{{ number_format($totalDecaisse ?? 0, 0, ',', ' ') }} <span class="text-xs text-gray-400">CFA</span></p>
                            </div>
                            <span class="text-3xl p-3 bg-emerald-50 rounded-lg text-emerald-700">📉</span>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Taux d'Absorption Moyen</p>
                                <p class="mt-2 text-2xl font-bold text-cyan-700 font-mono">{{ number_format($tauxAbsorptionGlobal ?? 0, 1) }} %</p>
                            </div>
                            <span class="text-3xl p-3 bg-cyan-50 rounded-lg text-cyan-700">📊</span>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider mb-6">Architecture des Modules Comptables & Décisionnels</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <a href="{{ route('profile.menus.comptabilite.comptabilite_financiere') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">🏛️</span>
                                    <span class="text-[10px] font-bold text-cyan-700 bg-cyan-50 px-2 py-0.5 rounded uppercase">Réglementaire</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Comptabilité Financière</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Suivi rigoureux des dotations par lignes de projets, gestion des engagements contractuels et états certifiés pour la BAD.</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Accéder au registre →
                            </div>
                        </a>

                        <a href="{{ route('profile.menus.comptabilite.comptabilite_caisse') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">💰</span>
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded uppercase">Trésorerie</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Comptabilité de Caisse</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Grand livre des flux réels de liquidités. Suivi analytique du Compte Spécial (BAD) et du Compte de Contrepartie (État).</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Consulter le cash-flow →
                            </div>
                        </a>

                        <a href="{{ route('profile.menus.comptabilite.comptabilite_actif') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">🏗️</span>
                                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded uppercase">Patrimoine</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Comptabilité de l'Actif</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Immobilisation des infrastructures en cours de formation. Liens directs avec les livrables physiques validés sur le terrain.</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Voir la valeur acquise →
                            </div>
                        </a>

                        <a href="{{ route('profile.menus.comptabilite.comptabilite_gestion') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">📊</span>
                                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded uppercase">Performance</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Comptabilité de Gestion</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Analyse des coûts par centres d'activités opérationnels, surveillance des frais de structure UGP et détection des écarts.</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Analyser l'efficience →
                            </div>
                        </a>

                        <a href="{{ route('profile.menus.comptabilite.comptabilite_monetaire') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">💱</span>
                                    <span class="text-[10px] font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded uppercase">Devises</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Comptabilité Monétaire</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Suivi des parités de l'Unité de Compte (UC/BAD). Enregistrement et isolation des pertes et gains latents de change.</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Piloter le risque change →
                            </div>
                        </a>

                        <a href="{{ route('profile.menus.budget') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-cyan-700 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl">🔄</span>
                                    <span class="text-[10px] font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded uppercase">Décisionnel</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-cyan-700 transition-colors">Arbitrages Budgétaires</h4>
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Console d'ajustement : Saisie des enveloppes initiales et exécution des virements de crédits inter-projets validés par la BAD.</p>
                            </div>
                            <div class="mt-4 text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center group-hover:translate-x-1 transition-transform">
                                Ouvrir la table d'arbitrage →
                            </div>
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>