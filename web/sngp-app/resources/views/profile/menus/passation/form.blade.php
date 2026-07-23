<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Mise à jour du Cycle de Vie</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl mx-auto">
                <!-- En-tête -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900 text-base">Faire progresser le dossier</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Enregistrer une nouvelle étape réglementaire ou financière pour ce marché.</p>
                </div>

                <!-- Formulaire avec état dynamique Alpine.js -->
                <form action="{{ isset($marche) && $marche->exists ? route('passation.update-etape', $marche->id) : route('passation.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="p-6 space-y-5"
                      x-data="{ 
                          etapeSelectionnee: '{{ old('etape', $marche->etape ?? '') }}',
                          methodeExistante: '{{ $marche->methode_passation ?? '' }}',
                          
                          // Étapes exigeant impérativement une méthode de passation
                          etapesExigeantes: [
                              'REDACTION_DAO', 'VALIDATION_DGMP', 'PUBLICATION_AVIS', 
                              'RECEPTION_OFFRES', 'OUVERTURE_PLIS', 'EVALUATION_TECHNIQUE', 
                              'ATTRIBUTION_PROVISOIRE', 'SIGNATURE_CONTRAT', 'ORDRE_SERVICE', 
                              'PREMIER_VERSEMENT', 'EXECUTION_TRAVAUX', 'DERNIER_VERSEMENT', 'RECEPTION_DEFINITIVE'
                          ],

                          doitAfficherMethode() {
                              return !this.methodeExistante && this.etapesExigeantes.includes(this.etapeSelectionnee);
                          }
                      }">
                    @csrf
                    @method('PUT')

                    <!-- Rappel Contextuel du Marché -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Référence unique</span>
                                <span class="text-sm font-mono font-bold text-slate-900">{{ $marche->numero_reference ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Étape Actuelle</span>
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-0.5 font-bold text-amber-700 ring-1 ring-inset ring-amber-600/10 mt-1 text-xs">
                                    {{ $marche->etape_actuelle_libelle ?? $marche->etape ?? 'Non définie' }}
                                </span>
                            </div>
                        </div>
                        <div class="border-t border-slate-200/60 pt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Objet complet du marché</span>
                                <p class="text-xs font-semibold text-gray-800 mt-0.5">{{ $marche->objet ?? 'Aucun objet spécifié' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sélection de la Nouvelle Étape -->
                    <div class="space-y-2">
                        <label for="etape" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                            Nouvelle Étape de Passation <span class="text-red-500">*</span>
                        </label>
                        <select id="etape" 
                                name="etape" 
                                x-model="etapeSelectionnee" 
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500" 
                                required>
                            <option value="" disabled selected>Choisir la prochaine étape réglementaire...</option>
                            
                            <optgroup label="1. Phase Amont / Préparation">
                                <option value="EXPRESSION_BESOIN">01 - Expression du besoin & Planification (PPM)</option>
                                <option value="REDACTION_DAO">02 - Rédaction du Dossier d'Appel d'Offres (DAO)</option>
                                <option value="VALIDATION_DGMP">03 - Validation par l'organe de contrôle (DGMP)</option>
                            </optgroup>

                            <optgroup label="2. Phase de Concurrence">
                                <option value="PUBLICATION_AVIS">04 - Publication de l'Avis Public d'Appel d'Offres</option>
                                <option value="RECEPTION_OFFRES">05 - Réception des offres des soumissionnaires</option>
                                <option value="OUVERTURE_PLIS">06 - Ouverture des plis (Séance publique)</option>
                            </optgroup>

                            <optgroup label="3. Phase d'Arbitrage & Attribution">
                                <option value="EVALUATION_TECHNIQUE">07 - Évaluation Technique & Financière (Comité)</option>
                                <option value="ATTRIBUTION_PROVISOIRE">08 - Attribution Provisoire & Notification</option>
                                <option value="SIGNATURE_CONTRAT">09 - Signature du Contrat / Marché Adjugé</option>
                            </optgroup>

                            <optgroup label="4. Phase d'Exécution & Suivi Financier">
                                <option value="ORDRE_SERVICE">10 - Notification de l'Ordre de Service (OS)</option>
                                <option value="PREMIER_VERSEMENT">11 - Premier Versement (Avance de démarrage décaissée)</option>
                                <option value="EXECUTION_TRAVAUX">12 - Exécution physique des prestations (En cours)</option>
                                <option value="DERNIER_VERSEMENT">13 - Dernier Versement (Paiement du solde / Clôture financière)</option>
                                <option value="RECEPTION_DEFINITIVE">14 - Réception définitive & Quitus au titulaire</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- CAS A : La méthode existe déjà en BD (Rappel visuel verrouillé) -->
                    @if(!empty($marche->methode_passation))
                        <div class="p-3 bg-slate-100 rounded-lg border border-slate-200 flex justify-between items-center">
                            <div>
                                <span class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Méthode de Passation (Déjà enregistrée)</span>
                                <span class="text-xs font-bold text-slate-800">{{ $marche->methode_passation }}</span>
                            </div>
                            <span class="text-[10px] bg-slate-200 text-slate-700 px-2 py-0.5 rounded font-bold uppercase">Classifié</span>
                        </div>
                    @endif

                    <!-- CAS B : La méthode N'EXISTE PAS ENCORE -> Apparition dynamique -->
                    <div x-show="doitAfficherMethode()" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="space-y-2 p-4 bg-cyan-50/80 border border-cyan-200 rounded-lg">
                        <label for="methode_passation" class="block text-[11px] font-bold text-cyan-900 uppercase tracking-wider">
                            Méthode de Passation du Marché <span class="text-red-500">*</span>
                        </label>
                        <p class="text-[11px] text-cyan-700 mb-2">
                            Pour faire passer le marché à cette étape, veuillez préciser sa méthode de passation réglementaire.
                        </p>
                        <select id="methode_passation" 
                                name="methode_passation" 
                                :required="doitAfficherMethode()"
                                class="block w-full rounded-lg border border-cyan-300 bg-white px-3 py-2.5 font-semibold text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                            <option value="" disabled selected>Sélectionner le mode de passation...</option>
                            <option value="AON" {{ old('methode_passation') === 'AON' ? 'selected' : '' }}>AON - Appel d'Offres National</option>
                            <option value="AOI" {{ old('methode_passation') === 'AOI' ? 'selected' : '' }}>AOI - Appel d'Offres International</option>
                            <option value="AOR" {{ old('methode_passation') === 'AOR' ? 'selected' : '' }}>AOR - Appel d'Offres Restreint</option>
                            <option value="COTA" {{ old('methode_passation') === 'COTA' ? 'selected' : '' }}>DC - Demande de Cotation / Devis</option>
                        </select>
                    </div>

                    <!-- Date d'effet -->
                    <div class="space-y-2">
                        <label for="date_changement" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                            Date d'effet du changement <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_changement" name="date_changement" value="{{ old('date_changement', date('Y-m-d')) }}" class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 font-medium text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                    </div>

                    <!-- Fichier Justificatif -->
                    <div class="space-y-2">
                        <label for="document_justificatif" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                            Pièce justificative officielle (PV, OS, ou Ordre de virement PDF)
                        </label>
                        <input type="file" id="document_justificatif" name="document_justificatif" accept=".pdf" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    </div>

                    <!-- Observations / Notes -->
                    <div class="space-y-2">
                        <label for="commentaire" class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                            Observations / Rapport motivant la transition <span class="text-red-500">*</span>
                        </label>
                        <textarea id="commentaire" name="commentaire" rows="3" placeholder="Saisir les détails officiels de la décision administrative ou comptable..." class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 font-normal text-gray-800 shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>{{ old('commentaire') }}</textarea>
                    </div>

                    <!-- Boutons d'Action -->
                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-100">
                        <a href="{{ route('passation.index') }}" class="rounded-lg border border-gray-300 bg-white py-2.5 px-4 font-bold text-gray-700 hover:bg-gray-50 uppercase tracking-wider text-[10px] text-center">
                            Retour à la liste
                        </a>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-5 font-bold transition shadow-sm uppercase tracking-wider text-[10px]">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Valider le changement d'étape
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>