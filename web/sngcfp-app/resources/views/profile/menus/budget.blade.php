<x-app-layout>
    <x-slot name="header">Suivi Budgétaire</x-slot>

    <div class="space-y-6">
        @php
            $tauxExecGlobal = ($projets->sum('budget_alloue') > 0) ? ($projets->sum('budget_depense') / $projets->sum('budget_alloue')) * 100 : 0;
        @endphp
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-[#1B4F72]">Consommation Globale du Portefeuille</h3>
                    <p class="text-sm text-gray-500">Totalité des 10 projets BAD</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-[#1B4F72]">{{ round($tauxExecGlobal) }}%</span>
                    <p class="text-[10px] font-bold text-[#27AE60] uppercase">Taux d'exécution</p>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-4 mt-4 overflow-hidden shadow-inner">
                <div class="bg-[#27AE60] h-4 rounded-full" style="width: {{ $tauxExecGlobal }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($projets as $pj)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-bold text-gray-700">{{ $pj->nom }}</span>
                    <span class="text-xs font-mono text-gray-400">{{ number_format($pj->budget_depense/1000000, 1) }}M / {{ number_format($pj->budget_alloue/1000000, 1) }}M FCFA</span>
                </div>
                <div class="w-full bg-gray-50 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $pj->taux_execution }}%"></div>
                </div>
                <div class="mt-2 text-right">
                    <span class="text-[10px] font-bold text-gray-400">{{ $pj->taux_execution }}% consommé</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>