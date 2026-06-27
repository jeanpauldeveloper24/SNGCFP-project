<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Comptabilité de l'Actif</h2>
                    <p class="mt-2 text-sm text-gray-600">Valorisation comptable des infrastructures, biens et livrables en cours de formation (Financements BAD).</p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                        Fonds : Bailleurs & Contrepartie
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Enveloppe Initiale des Actifs</dt>
                    <dd class="mt-2 text-2xl font-bold text-gray-900">
                        {{ number_format($totalAllocated, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500">FCFA</span>
                    </dd>
                </div>

                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Actif Consolidé (Décaissé)</dt>
                    <dd class="mt-2 text-2xl font-bold text-emerald-700">
                        {{ number_format($totalDisbursed, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500">FCFA</span>
                    </dd>
                </div>

                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-gray-400 p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reste à Engager / Valoriser</dt>
                    <dd class="mt-2 text-2xl font-bold text-gray-700">
                        {{ number_format($totalAllocated - $totalDisbursed, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500">FCFA</span>
                    </dd>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-cyan-700 uppercase tracking-wider">Registre de Suivi des Actifs Immobilisés par Projet</h3>
                    <span class="text-xs text-gray-500 font-mono">Mise à jour : Mai 2026</span>
                </div>

                @if($projects->isEmpty())
                    <div class="text-center p-12">
                        <span class="text-4xl">📊</span>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun projet à comptabiliser</h3>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left">
                            <thead class="bg-cyan-700 text-white">
                                <tr>
                                    <th scope="col" class="py-3.5 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Projet / Composante</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Marché lié</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Prestataire</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Budget Alloué</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Actif Réalisé (Payé)</th>
                                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Taux d'Actifs</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($projects as $project)
                                    <tr class="bg-gray-50/50 font-semibold border-t-2 border-gray-200">
                                        <td colspan="3" class="py-3 pr-3 pl-6 text-sm text-cyan-800 uppercase tracking-wide">
                                            📁 {{ $project->code }} — {{ $project->nom }}
                                        </td>
                                        <td class="px-3 py-3 text-sm text-right font-bold text-gray-900">
                                            {{ number_format($project->budget_value, 0, ',', ' ') }}
                                        </td>
                                        <td class="px-3 py-3 text-sm text-right font-bold text-emerald-700">
                                            @php
                                                $projectPaid = $project->paiements()->where('status', 'Effectué')->sum('montant');
                                                $projectProgress = $project->budget_value > 0 ? ($projectPaid / $project->budget_value) * 100 : 0;
                                            @endphp
                                            {{ number_format($projectPaid, 0, ',', ' ') }}
                                        </td>
                                        <td class="px-3 py-3 text-sm text-center">
                                            <span class="inline-flex items-center rounded-full bg-cyan-100 px-2.5 py-0.5 text-xs font-bold text-cyan-800">
                                                {{ number_format($projectProgress, 1) }} %
                                            </span>
                                        </td>
                                    </tr>

                                    @foreach($project->modules as $module)
                                        <tr class="hover:bg-gray-50/40 transition-colors text-xs text-gray-600">
                                            <td class="py-3 pr-3 pl-12 whitespace-nowrap">
                                                <span class="text-gray-400 mr-1">└─</span> Mod {{ $module->number }} : {{ Str::limit($module->description, 40) }}
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                @if($module->market)
                                                    <span class="font-medium text-gray-800">{{ Str::limit($module->market->objet, 30) }}</span>
                                                @else
                                                    <span class="text-red-500 font-medium italic">Aucun marché initié</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap font-mono text-gray-500">
                                                @if($module->market && $module->market->user_id_prestataire)
                                                    {{ Str::limit($module->market->user_id_prestataire, 10) }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 text-right font-medium text-gray-800">
                                                {{ number_format($module->budget_value, 0, ',', ' ') }}
                                            </td>
                                            <td class="px-3 py-3 text-right font-bold text-emerald-600">
                                                @php
                                                    $modulePaid = $module->market ? $module->market->paiements()->where('status', 'Effectué')->sum('montant') : 0;
                                                @endphp
                                                {{ number_format($modulePaid, 0, ',', ' ') }}
                                            </td>
                                            <td class="px-3 py-3 text-center">
                                                @php
                                                    $moduleProgress = $module->budget_value > 0 ? ($modulePaid / $module->budget_value) * 100 : 0;
                                                @endphp
                                                <div class="w-24 bg-gray-200 rounded-full h-1.5 inline-block align-middle mr-2">
                                                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ min($moduleProgress, 100) }}%"></div>
                                                </div>
                                                <span class="font-bold text-gray-700 inline-block align-middle w-8 text-right">{{ number_format($moduleProgress, 0) }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>