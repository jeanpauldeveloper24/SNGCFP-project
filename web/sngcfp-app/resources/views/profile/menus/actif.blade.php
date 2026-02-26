<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comptabilité de l\'Actif & Inventaire du Patrimoine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600">
                    <p class="text-xs text-gray-500 uppercase font-bold">Valeur Totale des Actifs</p>
                    <p class="text-2xl font-black text-[#1B4F72]">125 000 000 FCFA</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-600">
                    <p class="text-xs text-gray-500 uppercase font-bold">Amortissements cumulés</p>
                    <p class="text-2xl font-black text-green-600">- 12 500 000 FCFA</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <p class="text-xs text-gray-500 uppercase font-bold">Valeur Nette Comptable</p>
                    <p class="text-2xl font-black text-gray-800">112 500 000 FCFA</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Registre des Immobilisations (Biens du Projet)</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="p-3 text-xs font-bold text-gray-600 uppercase">Code Actif</th>
                                <th class="p-3 text-xs font-bold text-gray-600 uppercase">Désignation</th>
                                <th class="p-3 text-xs font-bold text-gray-600 uppercase">Date d'Acquisition</th>
                                <th class="p-3 text-xs font-bold text-gray-600 uppercase">Valeur d'Origine</th>
                                <th class="p-3 text-xs font-bold text-gray-600 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="p-3 text-sm font-mono">VH-001-BAD</td>
                                <td class="p-3 text-sm font-medium">Véhicule Toyota Hilux 4x4 (Mission Terrain)</td>
                                <td class="p-3 text-sm text-gray-500">12/01/2026</td>
                                <td class="p-3 text-sm font-bold">28 500 000 FCFA</td>
                                <td class="p-3"><span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full uppercase font-bold">En Service</span></td>
                            </tr>
                            <tr>
                                <td class="p-3 text-sm font-mono">IT-045-CFP</td>
                                <td class="p-3 text-sm font-medium">Serveur de Données Centralisé</td>
                                <td class="p-3 text-sm text-gray-500">05/01/2026</td>
                                <td class="p-3 text-sm font-bold">4 200 000 FCFA</td>
                                <td class="p-3"><span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full uppercase font-bold">Installé</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>