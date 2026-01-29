<x-app-layout>
    <x-slot name="header">
        Analyses & Audit
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-6">
                <div class="relative w-20 h-20">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="stroke-current text-gray-100" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="stroke-current text-[#27AE60]" stroke-width="3" stroke-dasharray="95, 100" stroke-linecap="round" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center font-bold text-[#1B4F72]">95%</div>
                </div>
                <div>
                    <h4 class="font-bold text-[#1B4F72]">Conformité Procédures BAD</h4>
                    <p class="text-xs text-gray-500 mt-1">Sur la base des 50 dernières transactions vérifiées.</p>
                </div>
            </div>

            <div class="bg-[#1B4F72] p-6 rounded-xl shadow-lg text-white">
                <h4 class="font-bold mb-2">Générateur de Rapports</h4>
                <p class="text-xs text-white/70 mb-4">Exportez instantanément les données au format standard BAD (Excel/PDF).</p>
                <button class="w-full py-2 bg-[#27AE60] hover:bg-[#219150] rounded-lg text-xs font-bold transition-all uppercase">
                    Télécharger le Rapport Mensuel
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-[#1B4F72] text-sm uppercase tracking-wider">Journaux d'Audit (Récents)</h3>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800">Awa Diop</span> 
                                <span class="text-gray-500">a validé le paiement</span> 
                                <span class="font-mono text-[#27AE60]">#PAY-882</span>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-gray-400">Il y a 10 min</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800">Système</span> 
                                <span class="text-gray-500">a généré l'alerte budget : </span> 
                                <span class="font-mono text-red-500">Seuil 80% atteint (Composante A)</span>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-gray-400">Il y a 2 heures</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>