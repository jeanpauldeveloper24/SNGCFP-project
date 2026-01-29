<x-app-layout>
    <x-slot name="header">
        Passation de Marchés
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-[#1B4F72]">
                <p class="text-[10px] font-bold text-gray-400 uppercase">En préparation</p>
                <p class="text-2xl font-bold text-[#1B4F72]">04</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-blue-400">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Appels d'offres</p>
                <p class="text-2xl font-bold text-[#1B4F72]">12</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-yellow-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">En évaluation</p>
                <p class="text-2xl font-bold text-[#1B4F72]">03</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-[#27AE60]">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Attribués</p>
                <p class="text-2xl font-bold text-[#1B4F72]">28</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-[#1B4F72] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Suivi des Dossiers d'Appel d'Offres (DAO)
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase text-gray-400 font-extrabold border-b border-gray-100">
                            <th class="px-6 py-4">N° Dossier</th>
                            <th class="px-6 py-4">Objet du Marché</th>
                            <th class="px-6 py-4">Méthode</th>
                            <th class="px-6 py-4">Étape Actuelle</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#1B4F72]">DAO-2026-F042</td>
                            <td class="px-6 py-4 text-gray-700">Acquisition de matériel informatique pour le siège</td>
                            <td class="px-6 py-4"><span class="text-xs text-gray-500">AON (National)</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                                    <span class="text-xs font-medium text-blue-600">Publication en cours</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button class="text-[#1B4F72] hover:underline font-bold text-xs">Détails</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>