<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Journal & Situation de Caisse</h2>
                    <p class="mt-2 text-sm text-gray-600">Suivi des flux de trésorerie réels, disponibilités immédiates et historique des décaissements validés.</p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-700/10 uppercase tracking-wider">
                        Flux de Trésorerie
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
    <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-cyan-700 p-5">
        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Trésorerie Nette Globale</dt>
        <dd class="mt-2 text-3xl font-bold tracking-tight text-gray-900 font-mono">
            {{ number_format($soldeGlobal, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500">FCFA</span>
        </dd>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-emerald-600 p-5">
        <div class="flex justify-between items-center">
            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Compte Spécial (Fonds BAD)</dt>
            <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700">Devises/CFA</span>
        </div>
        <dd class="mt-2 text-2xl font-bold text-emerald-700 font-mono">
            {{ number_format($soldeBAD, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-400">FCFA</span>
        </dd>
    </div>

    <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 border-l-4 border-amber-500 p-5">
        <div class="flex justify-between items-center">
            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contrepartie État de CI</dt>
            <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 rounded bg-amber-50 text-amber-700">Trésor Public</span>
        </div>
        <dd class="mt-2 text-2xl font-bold text-amber-700 font-mono">
            {{ number_format($soldeEtat, 0, ',', ' ') }} <span class="text-xs font-medium text-gray-400">FCFA</span>
        </dd>
    </div>
</div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-emerald-800 uppercase tracking-wider">Chronologie des Flux Financiers Exécutés</h3>
                    <span class="text-xs text-gray-500 font-mono">Grand Livre de Caisse</span>
                </div>

                @if($fluxCaisse->isEmpty())
    <div class="text-center p-12">
        <span class="text-4xl">💸</span>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun mouvement de caisse enregistré</h3>
        <p class="mt-1 text-sm text-gray-500">Aucun décaissement n'a encore été finalisé sur les comptes bancaires.</p>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left">
            <thead class="bg-cyan-700 text-white">
                <tr>
                    <th scope="col" class="py-3.5 pr-3 pl-6 text-xs font-bold uppercase tracking-wider">Date Valeur</th>
                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Références Pièce</th>
                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Projet / Marché Mandaté</th>
                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Bénéficiaire (Prestataire)</th>
                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider">Jalon Exécuté</th>
                    <th scope="col" class="px-3 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Montant Décaissé</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                @foreach($fluxCaisse as $paiement)
                    <tr class="hover:bg-gray-50/70 transition-colors text-sm">
                        
                        <td class="whitespace-nowrap py-4 pr-3 pl-6 font-medium text-gray-900 font-mono">
                            {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : '—' }}
                        </td>
                        
                        <td class="whitespace-nowrap px-3 py-4 font-mono text-xs text-cyan-800 font-semibold">
                            {{ $paiement->references ?? 'CHQ / VIR-SANS-REF' }}
                        </td>
                        
                        <td class="px-3 py-4 text-xs">
                            @if($paiement->project)
                                <div class="font-bold text-gray-900">[{{ $paiement->project->code }}]</div>
                            @endif
                            @if($paiement->market)
                                <div class="text-gray-500 truncate max-w-xs">{{ $paiement->market->objet }}</div>
                            @endif
                        </td>
                        
                        <td class="whitespace-nowrap px-3 py-4 font-mono text-xs text-gray-600">
                            👤 {{ Str::limit($paiement->user_id_prestataire ?? 'N/A', 12) }}
                        </td>
                        
                        <td class="whitespace-nowrap px-3 py-4 text-xs">
                            <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 font-medium text-gray-800">
                                📋 {{ $paiement->etape_administrative ?? 'Non renseigné' }}
                            </span>
                        </td>
                        
                        <td class="whitespace-nowrap px-3 py-4 text-right font-bold text-red-600 font-mono">
                            - {{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FCFA' }}
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