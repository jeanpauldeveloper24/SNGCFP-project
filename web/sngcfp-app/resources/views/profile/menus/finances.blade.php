<x-app-layout>
    <x-slot name="header">
        Gestion Finances & Budget
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-[#1B4F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Fonds Reçus (BAD)</p>
                        <p class="text-xl font-black text-[#1B4F72]">1 250 000 000 FCFA</p>
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
                        <p class="text-xl font-black text-[#27AE60]">64.5%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Engagements Non Payés</p>
                        <p class="text-xl font-black text-gray-800">85 400 000 FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-[#1B4F72] mb-6 flex items-center gap-2">
                <span class="w-1 h-5 bg-[#27AE60] rounded-full"></span>
                Analyse des Dépenses par Catégorie
            </h3>
            
            <div class="space-y-4">
                @php
                    $categories = [
                        ['nom' => 'Travaux Civil', 'alloue' => 500, 'depense' => 320, 'percent' => 64],
                        ['nom' => 'Consultance & Études', 'alloue' => 200, 'depense' => 180, 'percent' => 90],
                        ['nom' => 'Fonctionnement Unité', 'alloue' => 100, 'depense' => 45, 'percent' => 45],
                    ];
                @endphp

                @foreach($categories as $cat)
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-bold text-gray-700">{{ $cat['nom'] }}</span>
                        <span class="text-gray-500">{{ $cat['depense'] }}M / {{ $cat['alloue'] }}M FCFA</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-[#1B4F72] h-2 rounded-full" style="width: {{ $cat['percent'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>