<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Initialisation d'un Marché (DAO)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900 text-base">Créer un nouveau marché</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Enregistrer les caractéristiques initiales et définir les critères de tri administratif.</p>
                </div>

                <form action="{{ route('passation.store') }}" method="POST" class="p-6 space-y-6 text-xs">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="project_id" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                                Projet Institutionnel Rattaché <span class="text-red-500">*</span>
                            </label>
                            <select id="project_id" name="project_id" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                                <option value="" disabled selected>Choisir le projet lié à ce marché...</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->nom ?? $project->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="project_module_id" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                                Composante / Module Spécifique <span class="text-red-500">*</span>
                            </label>
                            <select id="project_module_id" name="project_module_id" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                                <option value="" disabled selected>Veuillez d'abord choisir un projet...</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3 bg-gray-50/50 p-4 rounded-xl border border-gray-200">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                                Exigences Techniques (Désignation & Quantités) <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-0.5">Ajoutez explicitement chaque équipement ou matériel requis. Le système s'en servira pour valider automatiquement la conformité technique des candidats.</p>
                        </div>

                        <div id="wrapper-besoins" class="space-y-2">
                            <div class="flex items-center space-x-2 ligne-besoin">
                                <div class="flex-1">
                                    <input type="text" name="besoins_designation[]" placeholder="Désignation du matériel (Ex: Ordinateurs de bureau i7)" class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                                </div>
                                <div class="w-32">
                                    <input type="number" name="besoins_quantite[]" min="1" placeholder="Qté (Ex: 15)" class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                                </div>
                                <button type="button" onclick="retirerLigne(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-1">
                            <button type="button" onclick="ajouterLigne()" class="inline-flex items-center text-cyan-700 hover:text-cyan-800 font-bold tracking-wide text-[11px] uppercase space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <span>Ajouter un matériel à la liste</span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-3">
                        <span class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Pièces administratives exigées pour le tri initial</span>
                        <p class="text-xs text-gray-500">Cochez les documents que le système ou la commission validera obligatoirement à la réception.</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50/30 cursor-pointer">
                                <input type="checkbox" name="exige_quitus" value="1" checked class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500 mr-3 w-4 h-4">
                                <span class="font-semibold text-gray-800">Quitus Fiscal Ivoirien</span>
                            </label>

                            <label class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50/30 cursor-pointer">
                                <input type="checkbox" name="exige_cnps" value="1" checked class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500 mr-3 w-4 h-4">
                                <span class="font-semibold text-gray-800">Attestation de la CNPS</span>
                            </label>

                            <label class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50/30 cursor-pointer">
                                <input type="checkbox" name="exige_rccm" value="1" checked class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500 mr-3 w-4 h-4">
                                <span class="font-semibold text-gray-800">Registre du Commerce (RCCM)</span>
                            </label>

                            <label class="flex items-center p-3 rounded-lg border border-gray-200 bg-gray-50/30 cursor-pointer">
                                <input type="checkbox" name="exige_faillite" value="1" checked class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500 mr-3 w-4 h-4">
                                <span class="font-semibold text-gray-800">Attestation de non-faillite</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100">
                        <a href="{{ route('passation.index') }}" class="rounded-lg border border-gray-300 bg-white py-2.5 px-4 font-bold text-gray-700 hover:bg-gray-50 uppercase tracking-wider text-[10px]">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-5 font-bold transition shadow-sm uppercase tracking-wider text-[10px]">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Publier et initialiser le marché
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        // Injection dynamique des composantes selon le projet choisi
        const projectsData = @json($projects);
        
        document.getElementById('project_id').addEventListener('change', function() {
            const projectId = parseInt(this.value);
            const moduleSelect = document.getElementById('project_module_id');
            
            // On vide les options précédentes
            moduleSelect.innerHTML = '<option value="" disabled selected>Choisir la composante...</option>';
            
            // On trouve le projet sélectionné
            const selectedProject = projectsData.find(p => p.id === projectId);
            
            if (selectedProject && selectedProject.modules && selectedProject.modules.length > 0) {
                selectedProject.modules.forEach(module => {
                    const option = document.createElement('option');
                    option.value = module.id;
                    option.textContent = `Composante ${module.number} : ${module.description}`;
                    moduleSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Aucune composante associée à ce projet";
                option.disabled = true;
                moduleSelect.appendChild(option);
            }
        });

        // Gestion dynamique des besoins techniques
        function ajouterLigne() {
            const wrapper = document.getElementById('wrapper-besoins');
            const nouvelleLigne = document.createElement('div');
            nouvelleLigne.className = 'flex items-center space-x-2 ligne-besoin';
            nouvelleLigne.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="besoins_designation[]" placeholder="Désignation du matériel" class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                </div>
                <div class="w-32">
                    <input type="number" name="besoins_quantite[]" min="1" placeholder="Quantité" class="block w-full rounded-lg border border-gray-300 px-3 py-2 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                </div>
                <button type="button" onclick="retirerLigne(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            `;
            wrapper.appendChild(nouvelleLigne);
        }

        function retirerLigne(bouton) {
            const lignes = document.querySelectorAll('.ligne-besoin');
            if (lignes.length > 1) {
                bouton.closest('.ligne-besoin').remove();
            } else {
                alert("Le marché doit comporter au moins un besoin matériel ou technique.");
            }
        }
    </script>
</x-app-layout>