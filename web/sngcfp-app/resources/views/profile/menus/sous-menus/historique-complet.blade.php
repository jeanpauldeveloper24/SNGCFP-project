<x-app-layout>
    <x-slot name="header">
        Archive Complète des Journaux d'Audit
    </x-slot>

    <div class="space-y-6">
        <a href="{{ route('audit.logs') }}" class="text-xs text-[#1B4F72] font-bold flex items-center gap-1 mb-4 hover:underline transition-all">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Retour aux activités récentes
        </a>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-sm font-bold text-[#1B4F72] mb-4 uppercase tracking-wider">Recherche dans les archives</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="date" class="rounded-lg border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]" placeholder="Date début">
                <input type="date" class="rounded-lg border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]" placeholder="Date fin">
                <select class="rounded-lg border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]">
                    <option>Tous les utilisateurs</option>
                    <option>Awa Diop</option>
                    <option>Jean-Marc Kouassi</option>
                </select>
                <button class="bg-[#27AE60] text-white rounded-lg font-bold text-sm hover:bg-[#219150] shadow-sm transition-all">
                    Rechercher
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-[10px] uppercase text-gray-400 font-extrabold">
                        <th class="px-6 py-4">ID Log</th>
                        <th class="px-6 py-4">Date & Heure</th>
                        <th class="px-6 py-4">Auteur</th>
                        <th class="px-6 py-4">Action effectuée</th>
                        <th class="px-6 py-4">Détails</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-mono">#000842</td>
                        <td class="px-6 py-4 text-gray-500 font-mono">2025-12-15 14:20</td>
                        <td class="px-6 py-4 font-bold text-gray-800">Système</td>
                        <td class="px-6 py-4">
                            <span class="text-blue-600 font-bold uppercase text-[10px] bg-blue-50 px-2 py-0.5 rounded">Migration Mensuelle</span>
                        </td>
                        <td class="px-6 py-4 text-gray-400 italic text-xs">Clôture exercice 2025 effectuée avec succès.</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-mono">#000841</td>
                        <td class="px-6 py-4 text-gray-500 font-mono">2025-12-14 10:05</td>
                        <td class="px-6 py-4 font-bold text-gray-800">Admin_Finance</td>
                        <td class="px-6 py-4">
                            <span class="text-green-600 font-bold uppercase text-[10px] bg-green-50 px-2 py-0.5 rounded">Export Données</span>
                        </td>
                        <td class="px-6 py-4 text-gray-400 italic text-xs">Génération du rapport annuel consolidé.</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center border-t border-gray-100">
                <p class="text-[10px] text-gray-400 italic font-bold uppercase tracking-widest leading-none">Page 1 sur 12</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-white border border-gray-200 rounded text-xs text-gray-400 cursor-not-allowed" disabled>Précédent</button>
                    <button class="px-3 py-1 bg-white border border-gray-200 rounded text-xs text-[#1B4F72] font-bold hover:bg-gray-100 transition-all shadow-sm">Suivant</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>