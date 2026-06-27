<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Registre de Transparence & Audit Système</h2>
                <p class="mt-2 text-sm text-gray-600">Traçabilité absolue des actions (CRUD) et journal d'activité en temps réel des utilisateurs du système.</p>
            </div>
            <div>
                <span class="inline-flex items-center rounded-md bg-red-50 px-3 py-2 text-sm font-bold text-red-700 ring-1 ring-inset ring-red-600/10 uppercase tracking-wider">
                    🛡️ Sécurité & Non-Répudiation
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-gray-400 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contrats sous Revue</dt>
                <dd class="mt-2 text-xl font-bold text-gray-900">{{ $totalMarketsCount ?? 0 }} <span class="text-xs font-medium text-gray-400">Dossiers</span></dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Certifiés Conformes</dt>
                <dd class="mt-2 text-xl font-bold text-emerald-700">{{ $certifiedCount ?? 0 }}</dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-red-500 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Alertes / Anomalies</dt>
                <dd class="mt-2 text-xl font-bold text-red-600">{{ $alertCount ?? 0 }}</dd>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-4">
                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Événements Logs</dt>
                <dd class="mt-2 text-xl font-bold text-cyan-700">{{ $logs->count() ?? 0 }} <span class="text-xs font-medium text-gray-400">Actions</span></dd>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-cyan-700 uppercase tracking-wider">Flux d'Activité Temps Réel (Logs Système)</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Chaque écriture, modification, lecture ou suppression est automatiquement capturée ici.</p>
                </div>
                <div class="text-xs font-mono bg-white px-3 py-1.5 rounded border border-gray-200 text-gray-500 shadow-sm">
                    Filtre actif : <span class="text-emerald-600 font-bold">Live 🟢</span>
                </div>
            </div>

            @if($logs->isEmpty())
                <div class="text-center p-12 text-gray-500">
                    <span class="text-4xl">📝</span>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune action enregistrée dans le journal</h3>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th scope="col" class="py-3 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Horodatage</th>
                                <th scope="col" class="px-3 py-3 text-xs font-bold uppercase tracking-wider">Acteur (Utilisateur)</th>
                                <th scope="col" class="px-3 py-3 text-xs font-bold uppercase tracking-wider">Rôle Fonctionnel</th>
                                <th scope="col" class="px-3 py-3 text-xs font-bold uppercase tracking-wider text-center">Type d'Action</th>
                                <th scope="col" class="px-3 py-3 text-xs font-bold uppercase tracking-wider">Description de l'Opération</th>
                                <th scope="col" class="px-3 py-3 text-xs font-bold uppercase tracking-wider font-mono">Adresse IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                            @foreach($logs as $log)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    
                                    <td class="whitespace-nowrap py-4 pr-3 pl-6 font-mono text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 font-bold text-gray-900">
                                        👤 {{ $log->user->name ?? 'Système Automatique' }}
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 text-xs">
                                        <span class="inline-flex items-center rounded-md bg-cyan-50 px-2 py-0.5 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                                            {{ str_replace('_', ' ', $log->user_role ?? 'N/A') }}
                                        </span>
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 text-center">
                                        @if($log->action_type === 'écriture' || $log->action_type === 'CREATE')
                                            <span class="inline-flex items-center rounded bg-emerald-50 px-2 py-1 text-xs font-bold text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                                📥 Écriture
                                            </span>
                                        @elseif($log->action_type === 'modification' || $log->action_type === 'UPDATE')
                                            <span class="inline-flex items-center rounded bg-amber-50 px-2 py-1 text-xs font-bold text-amber-700 border border-amber-200 uppercase tracking-wider">
                                                ✏️ Modification
                                            </span>
                                        @elseif($log->action_type === 'suppression' || $log->action_type === 'DELETE')
                                            <span class="inline-flex items-center rounded bg-red-50 px-2 py-1 text-xs font-bold text-red-700 border border-red-200 uppercase tracking-wider animate-pulse">
                                                🗑️ Suppression
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded bg-gray-100 px-2 py-1 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                👁️ Lecture
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-4 text-xs max-w-sm font-medium text-gray-600 break-words">
                                        {{ $log->description }}
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 font-mono text-xs text-gray-400">
                                        {{ $log->ip_address ?? '127.0.0.1' }}
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