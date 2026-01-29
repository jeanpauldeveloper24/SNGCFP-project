<x-app-layout>
    <x-slot name="header">
        Passation de Marchés
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border-b-4 border-gray-300">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Dossiers Planifiés</p>
                <p class="text-2xl font-black text-[#1B4F72]">42</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-b-4 border-blue-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">En cours de DAO</p>
                <p class="text-2xl font-black text-blue-600">08</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-b-4 border-yellow-500">
                <p class="text-[10px] font-bold text-gray-400 uppercase">En Évaluation</p>
                <p class="text-2xl font-black text-yellow-600">05</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border-b-4 border-[#27AE60]">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Contrats Signés</p>
                <p class="text-2xl font-black text-[#27AE60]">29</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                <h3 class="font-bold text-[#1B4F72]">Suivi des Dossiers d'Appel d'Offres (DAO)</h3>
                <button class="text-xs bg-[#1B4F72] text-white px-3 py-1.5 rounded-md font-bold hover:bg-[#2E86C1] transition-all">
                    + Nouveau Dossier
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr class="text-[10px] uppercase text-gray-400 font-extrabold border-b border-gray-100">
                            <th class="px-6 py-4">N° Référence</th>
                            <th class="px-6 py-4">Objet du Marché</th>
                            <th class="px-6 py-4">Méthode</th>
                            <th class="px-6 py-4">Statut / Étape</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-[#1B4F72]">DAO-2026-T014</td>
                            <td class="px-6 py-4">Construction de 5 centres de santé ruraux</td>
                            <td class="px-6 py-4"><span class="bg-gray-100 px-2 py-0.5 rounded text-[10px]">AON</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                    <span class="text-xs font-medium">Ouverture des plis</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="text-[#27AE60] hover:underline font-bold text-xs">Suivre</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-[#1B4F72]">DAO-2026-S005</td>
                            <td class="px-6 py-4">Audit externe de clôture d'exercice</td>
                            <td class="px-6 py-4"><span class="bg-gray-100 px-2 py-0.5 rounded text-[10px]">SFQC</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-[#27AE60]"></div>
                                    <span class="text-xs font-medium text-[#27AE60]">Contrat Adjugé</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="text-[#27AE60] hover:underline font-bold text-xs">Suivre</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>