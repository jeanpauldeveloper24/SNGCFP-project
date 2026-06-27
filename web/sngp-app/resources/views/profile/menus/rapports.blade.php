<x-app-layout>
    <x-slot name="header">
        Rapports Officiels BAD
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <div class="max-w-2xl">
                <h3 class="text-lg font-bold text-[#1B4F72] mb-2">Générer un nouveau rapport périodique</h3>
                <p class="text-sm text-gray-500 mb-6">Sélectionnez le type de rapport et la période pour compiler les données du projet.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select class="rounded-lg border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]">
                        <option>Rapport de Suivi Financier (RSF)</option>
                        <option>État des Décaissements</option>
                        <option>Rapport d'Avancement Physique</option>
                    </select>
                    
                    <select class="rounded-lg border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]">
                        <option>1er Trimestre 2026</option>
                        <option>Année 2025 (Complet)</option>
                    </select>

                    <button class="bg-[#27AE60] text-white px-6 py-2 rounded-lg font-bold text-sm hover:shadow-lg transition-all">
                        Générer
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-[#1B4F72]">Archives des Rapports</h3>
            </div>
            
            <div class="grid grid-cols-1 divide-y divide-gray-50">
                <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-red-50 rounded-lg text-red-600">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A1 1 0 0111 2.293l4.707 4.707a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">RSF_T4_2025_FINAL.pdf</p>
                            <p class="text-xs text-gray-400">Généré le 15/01/2026 par Admin</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-xs font-bold border border-gray-200 rounded-lg hover:bg-gray-100">Visualiser</button>
                        <button class="px-4 py-2 text-xs font-bold bg-[#1B4F72] text-white rounded-lg">Télécharger</button>
                    </div>
                </div>

                <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-50 rounded-lg text-green-600">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A1 1 0 0111 2.293l4.707 4.707a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Annexe_Depenses_2025.xlsx</p>
                            <p class="text-xs text-gray-400">Généré le 10/01/2026 par Comptable</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-xs font-bold bg-[#1B4F72] text-white rounded-lg">Télécharger</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>