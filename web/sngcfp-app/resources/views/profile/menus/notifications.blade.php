<x-app-layout>
    <x-slot name="header">
        Centre de Notifications
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-[#1B4F72] font-bold">Alertes et Activités Système</h3>
            <button class="text-xs text-gray-500 hover:text-[#1B4F72] underline font-medium">Tout marquer comme lu</button>
        </div>

        <div class="bg-white border-l-4 border-red-500 p-5 rounded-xl shadow-sm flex gap-4 items-start">
            <div class="p-2 bg-red-50 rounded-full text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h4 class="font-bold text-gray-800 text-sm">Alerte Seuil Budgétaire</h4>
                    <span class="text-[10px] text-gray-400 font-mono italic text-right leading-none">Il y a 10 min</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">La composante <span class="font-bold">"Infrastructures"</span> a atteint 85% de son budget alloué. Une révision budgétaire pourrait être nécessaire.</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('budget.index') }}" class="text-[10px] font-bold bg-red-600 text-white px-3 py-1 rounded-md uppercase tracking-wider">Analyser le budget</a>
                </div>
            </div>
        </div>

        <div class="bg-white border-l-4 border-yellow-500 p-5 rounded-xl shadow-sm flex gap-4 items-start">
            <div class="p-2 bg-yellow-50 rounded-full text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h4 class="font-bold text-gray-800 text-sm">Délai de Passation</h4>
                    <span class="text-[10px] text-gray-400 font-mono italic text-right leading-none">Ce matin</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">L'ouverture des plis pour le dossier <span class="font-bold text-[#1B4F72]">DAO-2026-T014</span> est prévue dans 48 heures.</p>
                <div class="mt-3">
                    <a href="{{ route('marches.index') }}" class="text-[10px] font-bold text-yellow-600 border border-yellow-600 px-3 py-1 rounded-md uppercase tracking-wider hover:bg-yellow-600 hover:text-white transition-all">Voir le dossier</a>
                </div>
            </div>
        </div>

        <div class="bg-white border-l-4 border-blue-500 p-5 rounded-xl shadow-sm flex gap-4 items-start opacity-75">
            <div class="p-2 bg-blue-50 rounded-full text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h4 class="font-bold text-gray-800 text-sm">Rapport Archivé</h4>
                    <span class="text-[10px] text-gray-400 font-mono italic text-right leading-none">Hier</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">Le rapport trimestriel <span class="font-bold italic underline">RSF_T4_2025</span> a été généré et archivé avec succès par le système.</p>
            </div>
        </div>
    </div>
</x-app-layout>