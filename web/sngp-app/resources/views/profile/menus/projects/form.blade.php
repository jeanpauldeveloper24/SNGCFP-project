<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-8 flex items-center justify-between border-b border-gray-200 pb-5">
            <div>
                {{-- TITRE DYNAMIQUE --}}
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    {{ isset($project) ? 'Détails & Modification du Projet' : 'Initialiser un Nouveau Projet' }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">Espace réservé aux Unités de Gestion de Projet (UGP) pour l'ouverture, le suivi et l'édition des enveloppes budgétaires.</p>
            </div>
            <div class="hidden sm:block">
                <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                    Rôle : UGP
                </span>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-600">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-red-600 font-bold">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Certains champs contiennent des erreurs :</h3>
                        <ul role="list" class="mt-2 list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- FORMULAIRE DYNAMIQUE (POST/STORE ou PUT/UPDATE) --}}
        @if(isset($project))
            <form action="{{ route('menus.projects.update', $project->id) }}" method="POST" class="space-y-8 bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                @csrf
                @method('PUT')
        @else
            <form action="{{ route('menus.projects.store') }}" method="POST" class="space-y-8 bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                @csrf
        @endif

            <div>
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-medium leading-6 text-cyan-700 flex items-center">
                        <span class="mr-2">📁</span> Données Administratives & Budgétaires
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    
                    <div class="sm:col-span-2">
                        <label for="code" class="block text-sm font-semibold text-gray-700">Code Unique du Projet</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $project->code ?? '') }}" placeholder="ex: PROJ-BAD-001" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="nom" class="block text-sm font-semibold text-gray-700">Nom / Intitulé Officiel</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $project->nom ?? '') }}" placeholder="ex: Projet d'Appui au..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="budget_initial" class="block text-sm font-semibold text-gray-700">Montant de l'Enveloppe Globale</label>
                        <input type="number" name="budget_initial" id="budget_initial" value="{{ old('budget_initial', $project->budget_initial ?? '') }}" min="0" step="0.01" placeholder="ex: 24500000" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-1">
                        <label for="budget_devise" class="block text-sm font-semibold text-gray-700">Devise</label>
                        <select name="budget_devise" id="budget_devise" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm">
                            <option value="XOF" {{ old('budget_devise', $project->budget_devise ?? '') == 'XOF' ? 'selected' : '' }}>XOF (FCFA)</option>
                            <option value="USD" {{ old('budget_devise', $project->budget_devise ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="EUR" {{ old('budget_devise', $project->budget_devise ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="taux_change" class="block text-sm font-semibold text-gray-700">Taux de Change (si != XOF)</label>
                        <input type="number" name="taux_change" id="taux_change" value="{{ old('taux_change', $project->taux_change ?? '1.00') }}" min="0" step="0.01" placeholder="ex: 612.50" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm">
                    </div>

                    <div class="sm:col-span-3">
                        <label for="pourcentage_bailleur" class="block text-sm font-semibold text-gray-700">Part du Bailleur (%)</label>
                        <input type="number" name="pourcentage_bailleur" id="pourcentage_bailleur" value="{{ old('pourcentage_bailleur', $project->pourcentage_bailleur ?? '100') }}" min="0" max="100" placeholder="ex: 80" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="pourcentage_etat" class="block text-sm font-semibold text-gray-700">Contrepartie État (%)</label>
                        <input type="number" name="pourcentage_etat" id="pourcentage_etat" value="{{ old('pourcentage_etat', $project->pourcentage_etat ?? '0') }}" min="0" max="100" placeholder="ex: 20" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700">Description et Objectifs Stratégiques</label>
                        <textarea name="description" id="description" rows="3" placeholder="Présentation succincte du projet..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm">{{ old('description', $project->description ?? '') }}</textarea>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="start_date" class="block text-sm font-semibold text-gray-700">Date de Début du projet</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($project->start_date) ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="end_date" class="block text-sm font-semibold text-gray-700">Date de fin de Projet</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($project->end_date) ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 sm:text-sm" required>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="border-b border-gray-200 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-medium leading-6 text-cyan-700 flex items-center">
                        <span class="mr-2">🧩</span> Définition des Composantes (Modules)
                    </h3>
                    <button type="button" id="btn-add-module" class="mt-2 sm:mt-0 inline-flex items-center text-xs font-bold uppercase tracking-wider text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg border border-emerald-200 transition">
                        ➕ Ajouter une composante
                    </button>
                </div>

                <div id="modules-container" class="space-y-4">
                    
                    {{-- AFFICHAGE DES COMPOSANTES EXISTANTES SI ÉDITION --}}
                    @if(isset($project) && $project->modules->count() > 0)
                        @foreach($project->modules as $index => $module)
                            <div class="module-card p-5 bg-gray-50 rounded-xl border border-gray-200 relative" data-index="{{ $index }}">
                                <div class="absolute top-4 right-4 text-xs font-bold text-gray-400 uppercase tracking-wider class-module-badge">
                                    Composante #{{ $index + 1 }}
                                </div>
                                
                                <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                    <input type="hidden" name="modules[{{ $index }}][number]" value="{{ $module->number }}">

                                    <div class="sm:col-span-6">
                                        <label class="block text-xs font-semibold text-gray-600 uppercase">Intitulé des travaux ou de la prestation</label>
                                        <input type="text" name="modules[{{ $index }}][description]" value="{{ old('modules.'.$index.'.description', $module->description) }}" placeholder="ex: Travaux de génie civil" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label class="block text-xs font-semibold text-gray-600 uppercase">Besoin Financier (Dans la devise du projet)</label>
                                        <input type="number" name="modules[{{ $index }}][besoin_financier]" value="{{ old('modules.'.$index.'.besoin_financier', $module->besoin_financier) }}" min="0" step="0.01" placeholder="Besoin financier du module" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-600 uppercase">Durée d'exécution</label>
                                        <input type="text" name="modules[{{ $index }}][duree]" value="{{ old('modules.'.$index.'.duree', $module->duree) }}" placeholder="ex: 8 mois" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                    </div>
                                </div>
                                <button type="button" class="mt-3 text-xs text-red-600 hover:text-red-800 font-semibold uppercase tracking-wider flex items-center btn-remove-module">
                                    ✕ Supprimer cette composante
                                </button>
                            </div>
                        @endforeach
                    @else
                        {{-- COMPOSANTE PAR DÉFAUT SI NOUVEAU PROJET --}}
                        <div class="module-card p-5 bg-gray-50 rounded-xl border border-gray-200 relative" data-index="0">
                            <div class="absolute top-4 right-4 text-xs font-bold text-gray-400 uppercase tracking-wider class-module-badge">
                                Composante #1
                            </div>
                            
                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                <input type="hidden" name="modules[0][number]" value="1">

                                <div class="sm:col-span-6">
                                    <label class="block text-xs font-semibold text-gray-600 uppercase">Intitulé des travaux ou de la prestation</label>
                                    <input type="text" name="modules[0][description]" placeholder="ex: Travaux de génie civil et aménagement" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                </div>

                                <div class="sm:col-span-4">
                                    <label class="block text-xs font-semibold text-gray-600 uppercase">Besoin Financier (Dans la devise du projet)</label>
                                    <input type="number" name="modules[0][besoin_financier]" min="0" step="0.01" placeholder="Besoin financier du module" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 uppercase">Durée d'exécution</label>
                                    <input type="text" name="modules[0][duree]" placeholder="ex: 8 mois" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('profile.menus.projects.list') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition">
                    Retour au portefeuille
                </a>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none transition uppercase tracking-wider">
                    {{ isset($project) ? 'Mettre à jour le projet' : 'Enregistrer le projet' }}
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    // Aligner automatiquement le taux de change si on choisit XOF ou USD au démarrage
    function checkDevise(selectElement) {
        const tauxInput = document.getElementById('taux_change');
        if (selectElement.value === 'XOF') {
            tauxInput.value = '1.00';
            tauxInput.setAttribute('readonly', 'true');
            tauxInput.classList.add('bg-gray-100');
        } else {
            tauxInput.removeAttribute('readonly');
            tauxInput.classList.remove('bg-gray-100');
            if(selectElement.value === 'USD' && (tauxInput.value == '1.00' || tauxInput.value == '')) {
                tauxInput.value = '612.50';
            }
        }
    }

    // Lancement au chargement de la page pour initialiser l'état du champ taux de change
    checkDevise(document.getElementById('budget_devise'));

    document.getElementById('budget_devise').addEventListener('change', function() {
        checkDevise(this);
    });

    document.getElementById('btn-add-module').addEventListener('click', function() {
        const container = document.getElementById('modules-container');
        const currentModules = container.getElementsByClassName('module-card');
        const nextIndex = currentModules.length;
        const displayNum = nextIndex + 1;

        const html = `
            <div class="module-card p-5 bg-gray-50 rounded-xl border border-gray-200 relative transition duration-150 ease-in-out" data-index="${nextIndex}">
                <div class="absolute top-4 right-4 text-xs font-bold text-gray-400 uppercase tracking-wider">
                    Composante #${displayNum}
                </div>
                
                <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                    <input type="hidden" name="modules[${nextIndex}][number]" value="${displayNum}">

                    <div class="sm:col-span-6">
                        <label class="block text-xs font-semibold text-gray-600 uppercase">Intitulé des travaux ou de la prestation</label>
                        <input type="text" name="modules[${nextIndex}][description]" placeholder="ex: Description de la composante..." 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                    </div>

                    <div class="sm:col-span-4">
                        <label class="block text-xs font-semibold text-gray-600 uppercase">Besoin Financier (Dans la devise du projet)</label>
                        <input type="number" name="modules[${nextIndex}][besoin_financier]" min="0" step="0.01" placeholder="Besoin financier" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 uppercase">Durée d'exécution</label>
                        <input type="text" name="modules[${nextIndex}][duree]" placeholder="ex: 12 mois" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-sm" required>
                    </div>
                </div>
                
                <button type="button" class="mt-3 text-xs text-red-600 hover:text-red-800 font-semibold uppercase tracking-wider flex items-center btn-remove-module">
                    ✕ Supprimer cette composante
                </button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    });

    document.getElementById('modules-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-remove-module')) {
            const card = e.target.closest('.module-card');
            card.remove();
            
            const currentModules = document.getElementById('modules-container').getElementsByClassName('module-card');
            Array.from(currentModules).forEach((module, idx) => {
                const currentNum = idx + 1;
                module.setAttribute('data-index', idx);
                module.querySelector('div.absolute').innerText = `Composante #${currentNum}`;
                module.querySelector('input[type="hidden"]').value = currentNum;
                
                module.querySelectorAll('input, select').forEach(input => {
                    let name = input.getAttribute('name');
                    if(name) {
                        input.setAttribute('name', name.replace(/modules\[\d+\]/, `modules[${idx}]`));
                    }
                });
            });
        }
    });
</script>
</x-app-layout>