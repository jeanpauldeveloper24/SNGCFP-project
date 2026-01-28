<x-app-layout>
    <x-slot name="header">
        {{ __('Tableau de bord') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-[#27AE60]">
                    <p class="text-sm text-gray-500 font-medium">Budget Global</p>
                    <p class="text-2xl font-bold text-[#1B4F72]">450 000 000 FCFA</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    {{ __("Bienvenue dans votre espace de gestion transactionnelle SNGP-BAD.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>