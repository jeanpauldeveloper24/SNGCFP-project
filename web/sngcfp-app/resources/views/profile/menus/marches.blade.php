<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>Vérification de la Passation (Expertise)</span>
            <span class="text-xs bg-[#1B4F72] text-white px-3 py-1 rounded-full">Rôle: Spécialiste Passation</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-orange-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">À vérifier (Reçu de la Direction)</p>
                <p class="text-2xl font-bold text-[#1B4F72]">07</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-[#27AE60]">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Conformes aux normes BAD</p>
                <p class="text-2xl font-bold text-[#1B4F72]">24</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-red-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Non-conformes (A corriger)</p>
                <p class="text-2xl font-bold text-[#1B4F72]">02</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Total Dossiers</p>
                <p class="text-2xl font-bold text-[#1B4F72]">33</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-[#1B4F72]/5">
                <h3 class="font-bold text-[#1B4F72] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    File de vérification des dossiers Direction Nationale
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase text-gray-400 font-extrabold border-b border-gray-100">
                            <th class="px-6 py-4">N° Dossier</th>
                            <th class="px-6 py-4">Objet / Projet</th>
                            <th class="px-6 py-4">Origine</th>
                            <th class="px-6 py-4">État de conformité</th>
                            <th class="px-6 py-4">Action Expert</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-orange-50/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#1B4F72]">DAO-2026-F042</td>
                            <td class="px-6 py-4 text-gray-700">Acquisition matériel info (PTUA)</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">DIRECTION NATIONALE</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="flex items-center gap-2 text-orange-600 font-bold">
                                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                    En attente d'expertise
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button class="bg-[#27AE60] text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">Valider Normes</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">Rejeter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>