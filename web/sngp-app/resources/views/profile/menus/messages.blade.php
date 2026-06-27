<x-app-layout>
    <x-slot name="header">
        Messagerie Sécurisée SNG-CFP
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex h-[calc(100vh-250px)]">
        <div class="w-1/3 border-r border-gray-100 flex flex-col bg-gray-50/30">
            <div class="p-4 border-b border-gray-100">
                <input type="text" placeholder="Rechercher un contact..." class="w-full rounded-lg border-gray-200 text-xs">
            </div>
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 flex items-center gap-3 bg-white border-b border-gray-50 cursor-pointer hover:bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#1B4F72] text-white flex items-center justify-center font-bold text-xs shrink-0">BAD</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-xs font-bold text-gray-800 truncate">Représentant BAD</h4>
                            <span class="text-[9px] text-gray-400">10:45</span>
                        </div>
                        <p class="text-[10px] text-[#27AE60] font-medium truncate">Re: Validation RSF T4...</p>
                    </div>
                </div>

                <div class="p-4 flex items-center gap-3 border-b border-gray-50 cursor-pointer hover:bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#27AE60] text-white flex items-center justify-center font-bold text-xs shrink-0">PR</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-xs font-bold text-gray-800 truncate">SOGEA-SATOM (Prestataire)</h4>
                            <span class="text-[9px] text-gray-400">Hier</span>
                        </div>
                        <p class="text-[10px] text-gray-500 truncate">La facture n°45 est déposée.</p>
                    </div>
                </div>

                <div class="p-4 flex items-center gap-3 border-b border-gray-50 cursor-pointer hover:bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">MT</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-xs font-bold text-gray-800 truncate">Ministère de Tutelle</h4>
                            <span class="text-[9px] text-gray-400">25 Janv.</span>
                        </div>
                        <p class="text-[10px] text-gray-500 truncate">Demande d'audience signée.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col bg-white">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#1B4F72] text-white flex items-center justify-center font-bold text-[10px]">BAD</div>
                    <h3 class="text-sm font-bold text-[#1B4F72]">Représentant de la BAD <span class="text-[10px] font-normal text-green-500 ml-2">● En ligne</span></h3>
                </div>
            </div>

            <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/20">
                <div class="flex items-end gap-2 max-w-[80%]">
                    <div class="bg-gray-100 p-3 rounded-2xl rounded-bl-none">
                        <p class="text-xs text-gray-700">Bonjour, nous avons bien reçu le Rapport de Suivi Financier. Des clarifications sont nécessaires sur la ligne "Logistique".</p>
                    </div>
                </div>

                <div class="flex items-end gap-2 max-w-[80%] ml-auto flex-row-reverse">
                    <div class="bg-[#1B4F72] p-3 rounded-2xl rounded-br-none text-white shadow-md">
                        <p class="text-xs">Bonjour. Très bien, je demande au Comptable de projet de vous transmettre les pièces justificatives d'ici demain.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100">
                <div class="flex gap-2">
                    <button class="p-2 text-gray-400 hover:text-[#1B4F72] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </button>
                    <input type="text" placeholder="Écrivez votre message ici..." class="flex-1 rounded-full border-gray-200 text-sm focus:ring-[#27AE60] focus:border-[#27AE60]">
                    <button class="p-2 bg-[#27AE60] text-white rounded-full hover:bg-[#219150] transition-all shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>