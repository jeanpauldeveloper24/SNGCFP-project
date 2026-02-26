<x-app-layout>
    <x-slot name="header">Gestion Finances & Budget</x-slot>

    <div class="space-y-6">
        @php
            $totalAlloue = $projets->sum('budget_alloue');
            $totalDepense = $projets->sum('budget_depense');
            $totalRecu = $projets->sum('fonds_recus_bad');
            $tauxGlobal = ($totalRecu > 0) ? ($totalDepense / $totalRecu) * 100 : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-[#1B4F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Fonds Reçus (BAD)</p>
                        <p class="text-xl font-black text-[#1B4F72]">{{ number_format($totalRecu, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Taux de Décaissement</p>
                        <p class="text-xl font-black text-[#27AE60]">{{ number_format($tauxGlobal, 1) }}%</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Reliquat à décaisser</p>
                        <p class="text-xl font-black text-gray-800">{{ number_format($totalAlloue - $totalDepense, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-[#1B4F72] mb-6 flex items-center gap-2">Analyse des Dépenses par Catégorie</h3>
            <div class="space-y-4">
                @foreach($projets->groupBy('categorie') as $catNom => $items)
                @php
                    $catAlloue = $items->sum('budget_alloue');
                    $catDepense = $items->sum('budget_depense');
                    $percent = ($catAlloue > 0) ? ($catDepense / $catAlloue) * 100 : 0;
                @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-bold text-gray-700">{{ $catNom }}</span>
                        <span class="text-gray-500">{{ number_format($catDepense/1000000, 1) }}M / {{ number_format($catAlloue/1000000, 1) }}M FCFA</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-[#1B4F72] h-2 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>