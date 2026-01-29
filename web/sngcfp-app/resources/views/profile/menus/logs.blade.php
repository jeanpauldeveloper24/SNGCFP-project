<x-app-layout>
    <x-slot name="header">
        Journaux d'Audit (Logs)
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" placeholder="Rechercher un utilisateur ou une action..." class="w-full rounded-lg border-gray-200 text-sm">
            </div>
            <select class="rounded-lg border-gray-200 text-sm">
                <option>Toutes les actions</option>
                <option>Connexion/Déconnexion</option>
                <option>Création de dossier</option>
                <option>Validation de paiement</option>
            </select>
            <button class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold">Filtrer</button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr class="text-[10px] uppercase text-gray-400 font-extrabold">
                            <th class="px-6 py-4">Horodatage</th>
                            <th class="px-6 py-4">Utilisateur</th>
                            <th class="px-6 py-4">Action</th>
                            <th class="px-6 py-4">Entité</th>
                            <th class="px-6 py-4">Adresse IP</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">2026-01-29 10:45:12</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#1B4F72] text-white flex items-center justify-center text-[10px]">AD</div>
                                    <span class="font-bold">Awa Diop</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">VALIDATION_PAIEMENT</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">DAO-2026-F042</td>
                            <td class="px-6 py-4 text-gray-400 font-mono text-xs">192.168.1.45</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">2026-01-29 09:15:00</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px]">SM</div>
                                    <span class="font-bold">Système</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">BACKUP_AUTO</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">Base de données</td>
                            <td class="px-6 py-4 text-gray-400 font-mono text-xs">127.0.0.1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center text-xs text-gray-400">
    Affichage des dernières activités. 
    <a href="{{ route('audit.logs.historique') }}" class="text-[#1B4F72] font-bold underline hover:text-[#27AE60] transition-colors">
    Voir tout l'historique
</a>
</div>
        </div>
    </div>
</x-app-layout>