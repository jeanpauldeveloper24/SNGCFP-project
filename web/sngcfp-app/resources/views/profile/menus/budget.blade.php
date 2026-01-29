<x-app-layout>
    <x-slot name="header">
        Suivi Budgétaire
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-[#1B4F72]">Consommation Globale du Projet</h3>
                    <p class="text-sm text-gray-500">Exercice 2026 - Période Janvier</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-[#1B4F72]">28%</span>
                    <p class="text-[10px] font-bold text-[#27AE60] uppercase tracking-widest">Taux d'exécution</p>
                </div>
            </div>
            
            <div class="w-full bg-gray-100 rounded-full h-4 mt-4 overflow-hidden">
                <div class="bg-[#27AE60] h-4 rounded-full shadow-inner" style="width: 28%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @php
                $composantes = [
                    ['titre' => 'Infrastructures & Travaux', 'total' => 200, 'conso' => 45, 'color' => 'bg-blue-500'],
                    ['titre' => 'Acquisition Équipements', 'total' => 150, 'conso' => 80, 'color' => 'bg-yellow-500'],
                    ['titre' => 'Renforcement Capacités', 'total' => 50, 'conso' => 10, 'color' => 'bg-purple-500'],
                    ['titre' => 'Gestion du Projet', 'total' => 50, 'conso' => 35, 'color' => 'bg-red-500']
                ];
            @endphp

            @foreach($composantes as $item)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-bold text-gray-700">{{ $item['titre'] }}</span>
                    <span class="text-xs font-mono text-gray-400">{{ $item['conso'] }}M / {{ $item['total'] }}M FCFA</span>
                </div>
                <div class="w-full bg-gray-50 rounded-full h-2">
                    <div class="{{ $item['color'] }} h-2 rounded-full" style="width: {{ ($item['conso']/$item['total'])*100 }}%"></div>
                </div>
                <div class="mt-2 text-right">
                    <span class="text-[10px] font-bold text-gray-400">{{ round(($item['conso']/$item['total'])*100) }}% consommé</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>