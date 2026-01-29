<x-app-layout>
    <x-slot name="header">
        Comptabilité & Paiements
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#27AE60]">
                <p class="text-xs font-bold text-gray-500 uppercase">Total Décaissements</p>
                <p class="text-xl font-bold text-[#1B4F72] mt-1">125 000 000 FCFA</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Paiements en attente</p>
                <p class="text-xl font-bold text-[#1B4F72] mt-1">12 450 000 FCFA</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Dernier transfert</p>
                <p class="text-xl font-bold text-[#1B4F72] mt-1">Hier (28/01)</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-[#1B4F72]">Historique des Paiements</h3>
                <button class="bg-[#27AE60] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-[#219150] transition-all">
                    + Nouveau Paiement
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] uppercase text-gray-400 font-bold">
                            <th class="px-6 py-3">Réf. Transaction</th>
                            <th class="px-6 py-3">Bénéficiaire</th>
                            <th class="px-6 py-3">Montant</th>
                            <th class="px-6 py-3">Statut</th>
                            <th class="px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs">BAD-2026-001</td>
                            <td class="px-6 py-4 font-medium text-gray-800">Fournisseur SNGP-IT</td>
                            <td class="px-6 py-4 font-bold text-[#1B4F72]">5 000 000 FCFA</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full">EFFECTUÉ</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">28/01/2026</td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>