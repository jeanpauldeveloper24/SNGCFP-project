<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">
            
            {{-- En-tête de la page --}}
            <div class="mb-8 border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        {{ (isset($marche) && $marche->exists) ? 'Régulation & Édition du Marché' : 'Initialisation du Marché Public' }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Gestion des étapes d'attribution, du dépôt des candidatures et des exigences techniques/financières.
                    </p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-1.5 text-xs font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                        Procédure de Passation
                    </span>
                </div>
            </div>

            <form action="{{ (isset($marche) && $marche->exists) ? route('passation.update-etape', $marche) : route('menus.marches.store') }}" method="POST" class="space-y-8">
                @csrf
                @if(isset($marche) && $marche->exists)
                    @method('PUT')
                @endif

                {{-- SECTION 1 : CARACTÉRISTIQUES GÉNÉRALES --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">1. Caractéristiques Générales</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label for="objet" class="block text-xs font-semibold text-gray-700 uppercase">Objet du Marché (Nature de la prestation)</label>
                            <input type="text" name="objet" id="objet" value="{{ old('objet', $marche->objet ?? '') }}" placeholder="ex: Travaux de construction d'un forage ou Fourniture de matériel informatique..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-medium text-gray-900" required>
                            @error('objet') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        {{-- Sélection du Projet --}}
                        <div>
                            <label for="project_id" class="block text-xs font-semibold text-gray-700 uppercase">Ligne Projet Associée</label>
                            <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs text-gray-800" required>
                                <option value="" disabled selected>-- Sélectionner un projet --</option>
                                @foreach($projects as $proj)
                                    <option value="{{ $proj->id }}" {{ (old('project_id', $marche->project_id ?? '') == $proj->id) ? 'selected' : '' }}>
                                        [{{ $proj->code }}] {{ $proj->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        {{-- Sélection du Module --}}
                        <div>
                            <label for="project_module_id" class="block text-xs font-semibold text-gray-700 uppercase">Module / Composante rattachée</label>
                            <select name="project_module_id" id="project_module_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs text-gray-800" required>
                                <option value="" disabled selected>-- Veuillez d'abord choisir un projet --</option>
                            </select>
                            @error('project_module_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-xs font-semibold text-gray-700 uppercase">État Actuel du Marché</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-bold text-gray-700" required>
                                <option value="Non attribué" {{ (old('status', $marche->status ?? '') == 'Non attribué') ? 'selected' : '' }}>Non attribué</option>
                                <option value="En cours d'attribution" {{ (old('status', $marche->status ?? '') == 'En cours d\'attribution') ? 'selected' : '' }}>En cours d'attribution</option>
                                <option value="Attribué" {{ (old('status', $marche->status ?? '') == 'Attribué') ? 'selected' : '' }}>Attribué</option>
                            </select>
                            @error('status') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                {{-- SECTION 2 : CAHIER DES CHARGES / BESOINS MATÉRIELS --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Cahier des Charges (Besoins Matériels)</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">Saisissez les besoins matériels indispensables à l'exécution du marché.</p>
                        </div>
                        <button type="button" id="add-row" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-cyan-50 text-cyan-700 rounded-lg text-xs font-semibold hover:bg-cyan-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Ajouter une ligne</span>
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-600" id="besoins-table">
                                <thead class="bg-gray-50 text-gray-700 uppercase font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 rounded-l-lg">Désignation du besoin matériel</th>
                                        <th class="px-4 py-3 w-32">Quantité</th>
                                        <th class="px-4 py-3 text-center w-16 rounded-r-lg">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="besoins-container">
                                    @php
                                        $besoinsMat = old('besoins_materiels', $marche->besoins_materiels ?? [['designation' => '', 'quantite' => 1]]);
                                    @endphp
                                    @foreach($besoinsMat as $idx => $mat)
                                        <tr class="besoin-row">
                                            <td class="px-4 py-3">
                                                <input type="text" name="besoins_materiels[{{ $idx }}][designation]" value="{{ $mat['designation'] ?? '' }}" required placeholder="Ex: Ordinateurs portables i7 16Go RAM" class="w-full text-xs rounded-lg border-gray-300 focus:border-cyan-700 focus:ring-cyan-700">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="besoins_materiels[{{ $idx }}][quantite]" value="{{ $mat['quantite'] ?? 1 }}" required min="1" class="w-full text-xs rounded-lg border-gray-300 focus:border-cyan-700 focus:ring-cyan-700">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <button type="button" class="remove-row text-red-500 hover:text-red-700 p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3 : BESOIN FINANCIER ESTIMÉ --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Besoin Financier Estimé</h3>
                    </div>
                    <div class="p-6">
                        <div>
                            <label for="besoin_financier" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Montant du besoin financier / Enveloppe Maximale (FCFA) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="besoin_financier" id="besoin_financier" step="0.01" min="0" value="{{ old('besoin_financier', $marche->besoin_financier ?? $marche->montant ?? '') }}" required readonly placeholder="Sélectionnez d'abord un module..." class="w-full rounded-xl border-gray-300 bg-gray-100 focus:border-cyan-700 focus:ring-cyan-700 text-xs py-2.5 font-mono font-bold text-amber-800">
                            <p class="text-[11px] text-gray-400 mt-1">Les offres financières des candidats dépassant ce seuil pourront être automatiquement marquées comme non recevables.</p>
                            @error('besoin_financier') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 4 : CHRONOGRAMME --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">4. Chronogramme Officiel</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label for="candidature_start_date" class="block font-semibold text-gray-700 uppercase">Début Dépôt Dossiers</label>
                            <input type="date" name="candidature_start_date" id="candidature_start_date" value="{{ old('candidature_start_date', isset($marche) && $marche->candidature_start_date ? $marche->candidature_start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                            @error('candidature_start_date') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="candidature_end_date" class="block font-semibold text-gray-700 uppercase">Fin Dépôt Dossiers</label>
                            <input type="date" name="candidature_end_date" id="candidature_end_date" value="{{ old('candidature_end_date', isset($marche) && $marche->candidature_end_date ? $marche->candidature_end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                            @error('candidature_end_date') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 5 : TITULAIRE --}}
                <div id="section_prestataire" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">5. Titulaire du Marché (Uniquement si Attribué)</h3>
                    </div>
                    <div class="p-6">
                        <label for="user_id" class="block text-xs font-semibold text-gray-700 uppercase">Sélectionner l'entreprise adjudicataire (Rôle: PRESTATAIRE)</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600 text-xs font-bold text-gray-900">
                            <option value="" selected>-- Aucun attributaire désigné pour le moment --</option>
                            @foreach($prestataires as $prestataire)
                                <option value="{{ $prestataire->id }}" {{ (old('user_id', $marche->user_id ?? '') == $prestataire->id) ? 'selected' : '' }}>
                                    🏢 {{ $prestataire->name }} (ID: {{ $prestataire->id }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-gray-400 mt-2">L'utilisateur sélectionné doit posséder le rôle fonctionnel PRESTATAIRE afin d'interagir avec l'écosystème Flutter terrain.</p>
                        @error('user_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Actions Formulaire --}}
                <div class="flex items-center justify-end space-x-4 border-t border-gray-200 pt-6">
                    <a href="{{ route('passation.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 uppercase tracking-wider transition">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-emerald-600 py-2 px-6 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 uppercase tracking-wider transition">
                        {{ (isset($marche) && $marche->exists) ? '⚡ Mettre à jour le dossier' : '💾 Enregistrer le projet de marché' }}
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Script JS Unifié --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Dynamic Modules Cascading Dropdown & Data-Besoin Mapping
            const projectsData = @json($projects);
            const projectSelect = document.getElementById('project_id');
            const moduleSelect = document.getElementById('project_module_id');
            const besoinInput = document.getElementById('besoin_financier');
            const selectedModuleId = "{{ old('project_module_id', $marche->project_module_id ?? '') }}";

            function triggerBesoinUpdate() {
                const selectedOption = moduleSelect.options[moduleSelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.besoin !== undefined) {
                    besoinInput.value = selectedOption.dataset.besoin;
                }
            }

            function updateModulesOptions(selectedProjectId, preselectedModuleId = null) {
                moduleSelect.innerHTML = '<option value="" disabled selected>-- Sélectionner un module --</option>';
                
                const selectedProject = projectsData.find(p => String(p.id) === String(selectedProjectId));
                
                if (selectedProject && selectedProject.modules && selectedProject.modules.length > 0) {
                    selectedProject.modules.forEach(mod => {
                        const option = document.createElement('option');
                        option.value = mod.id;
                        option.textContent = mod.description ?? mod.nom ?? mod.title ?? `Module #${mod.id}`;
                        
                        // Stockage du besoin financier dans le dataset HTML
                        if (mod.besoin_financier !== undefined && mod.besoin_financier !== null) {
                            option.dataset.besoin = mod.besoin_financier;
                        }
                        
                        if (preselectedModuleId && String(mod.id) === String(preselectedModuleId)) {
                            option.selected = true;
                        }
                        
                        moduleSelect.appendChild(option);
                    });
                    moduleSelect.disabled = false;
                    
                    // Mettre à jour la valeur si un module est pré-sélectionné
                    triggerBesoinUpdate();
                } else {
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "Aucun module disponible pour ce projet";
                    moduleSelect.appendChild(option);
                    moduleSelect.disabled = true;
                    besoinInput.value = '';
                }
            }

            // Écouteur changement projet
            projectSelect.addEventListener('change', function () {
                updateModulesOptions(this.value);
            });

            // Écouteur changement module -> auto-remplissage du besoin financier
            moduleSelect.addEventListener('change', function () {
                triggerBesoinUpdate();
            });

            if (projectSelect.value) {
                updateModulesOptions(projectSelect.value, selectedModuleId);
            }

            // 2. Status & Prestataire Section Toggle
            const statusSelect = document.getElementById('status');
            const sectionPrestataire = document.getElementById('section_prestataire');
            const selectUser = document.getElementById('user_id');

            function togglePrestataireSection() {
                if (statusSelect.value === 'Attribué') {
                    sectionPrestataire.style.opacity = '1';
                    sectionPrestataire.style.pointerEvents = 'auto';
                    selectUser.disabled = false;
                } else {
                    sectionPrestataire.style.opacity = '0.5';
                    sectionPrestataire.style.pointerEvents = 'none';
                    selectUser.disabled = true;
                }
            }

            statusSelect.addEventListener('change', togglePrestataireSection);
            togglePrestataireSection();

            // 3. Dynamic Rows for Material Needs Table
            const containerMat = document.getElementById('besoins-container');
            const addBtnMat = document.getElementById('add-row');

            function reindexBesoins() {
                const rows = containerMat.querySelectorAll('.besoin-row');
                rows.forEach((row, index) => {
                    const desInput = row.querySelector('input[name*="[designation]"]');
                    const qtyInput = row.querySelector('input[name*="[quantite]"]');
                    if (desInput) desInput.name = `besoins_materiels[${index}][designation]`;
                    if (qtyInput) qtyInput.name = `besoins_materiels[${index}][quantite]`;
                });
            }

            addBtnMat.addEventListener('click', function () {
                const rowIdx = containerMat.querySelectorAll('.besoin-row').length;
                const tr = document.createElement('tr');
                tr.className = 'besoin-row';
                tr.innerHTML = `
                    <td class="px-4 py-3">
                        <input type="text" name="besoins_materiels[${rowIdx}][designation]" required placeholder="Ex: Imprimante multifonction" class="w-full text-xs rounded-lg border-gray-300 focus:border-cyan-700 focus:ring-cyan-700">
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="besoins_materiels[${rowIdx}][quantite]" required min="1" value="1" class="w-full text-xs rounded-lg border-gray-300 focus:border-cyan-700 focus:ring-cyan-700">
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button type="button" class="remove-row text-red-500 hover:text-red-700 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </td>
                `;
                containerMat.appendChild(tr);
            });

            containerMat.addEventListener('click', function (e) {
                if (e.target.closest('.remove-row')) {
                    const rows = containerMat.querySelectorAll('.besoin-row');
                    if (rows.length > 1) {
                        e.target.closest('.besoin-row').remove();
                        reindexBesoins();
                    }
                }
            });
        });
    </script>
</x-app-layout>