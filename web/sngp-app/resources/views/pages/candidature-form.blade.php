<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | Soumission de Candidature</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased min-h-screen flex flex-col justify-between">

    @include('components.header')

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">
            
            <!-- En-tête de la page -->
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-xs font-bold text-cyan-700 uppercase tracking-widest ring-1 ring-inset ring-cyan-700/20">
                    Dépôt d'Offre en Ligne
                </span>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Formulaire de Soumission
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Conformément aux exigences de la Réglementation des Marchés Publics, veuillez fournir vos documents d'habilitation légale ainsi que vos propositions.
                </p>
            </div>

            <!-- Détails du marché -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-[11px] font-mono font-bold text-cyan-700 uppercase">
                            Code : {{ $marche->code_marche }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $marche->nom }}</h2>
                    </div>
                </div>
            </div>

            <!-- Formulaire de Candidature -->
            <form action="{{ route('pages.marche.postuler', $marche->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="marche_id" value="{{ $marche->id }}">

                <!-- 1. Identité de l'Opérateur Économique -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">1. Identité de l'Entreprise</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nom_candidat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Raison Sociale / Nom de l'Entreprise <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nom_candidat" 
                                name="nom_candidat" 
                                value="{{ old('nom_candidat', $candidature->nom_candidat ?? '') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm" 
                                placeholder="Ex: Ivoire Prestations SARL"
                                required 
                            />
                        </div>

                        <div>
                            <label for="numero_registre_commerce" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Numéro RCCM <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="numero_registre_commerce" 
                                name="numero_registre_commerce" 
                                value="{{ old('numero_registre_commerce', $candidature->numero_registre_commerce ?? '') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm" 
                                placeholder="Ex: CI-ABJ-03-2023-B12-00000"
                                required 
                            />
                        </div>
                    </div>
                </div>

                <!-- 2. Pièces Justificatives Légales et Réglementaires -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">2. Documents d'Habilitation Réglementaires</h2>
                    <p class="text-xs text-gray-500 mb-4">Téléversez vos pièces officielles en format PDF (Taille max: 10 Mo par document).</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- 1. RCCM -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_rccm" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 déclaration d'immatriculation RCCM <span class="text-red-500">*</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Preuve d'immatriculation et d'autorisation d'exercer.</span>
                            <input type="file" id="file_rccm" name="file_rccm" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" {{ isset($candidature->file_rccm) ? '' : 'required' }} />
                        </div>

                        <!-- 2. Acte Légal de Constitution -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_acte_constitution" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Acte Légal de Constitution <span class="text-gray-400 font-normal">(Requis pour SARL, EURL, SA...)</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Statuts de la société enregistrés et notariés.</span>
                            <input type="file" id="file_acte_constitution" name="file_acte_constitution" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" />
                        </div>

                        <!-- 3. DFE -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_dfe" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Déclaration Fiscale d'Existence (DFE) <span class="text-red-500">*</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Immatriculation auprès de la Direction Générale des Impôts (DGI).</span>
                            <input type="file" id="file_dfe" name="file_dfe" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" {{ isset($candidature->file_dfe) ? '' : 'required' }} />
                        </div>

                        <!-- 4. ARF -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_arf" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Attestation de Régularité Fiscale (ARF) <span class="text-red-500">*</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Quitus fiscal valide certifiant que vous êtes à jour des impôts.</span>
                            <input type="file" id="file_arf" name="file_arf" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" {{ isset($candidature->file_arf) ? '' : 'required' }} />
                        </div>

                        <!-- 5. CNPS -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_cnps" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Attestation CNPS <span class="text-red-500">*</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Attestation de mise à jour des cotisations sociales du personnel.</span>
                            <input type="file" id="file_cnps" name="file_cnps" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" {{ isset($candidature->file_cnps) ? '' : 'required' }} />
                        </div>

                        <!-- 6. Attestation Bancaire -->
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_attestation_bancaire" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Attestation Bancaire <span class="text-red-500">*</span>
                            </label>
                            <span class="block text-[11px] text-gray-400">Délivrée par une banque commerciale agréée par le Ministère des Finances.</span>
                            <input type="file" id="file_attestation_bancaire" name="file_attestation_bancaire" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" {{ isset($candidature->file_attestation_bancaire) ? '' : 'required' }} />
                        </div>

                    </div>
                </div>

                <!-- 3. Proposition Technique -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">3. Proposition Technique</h2>
                    <p class="text-xs text-gray-500">Renseignez les quantités proposées pour répondre aux besoins exigés.</p>

                    <div class="overflow-x-auto">
                        @if(!empty($marche->besoins_materiels) && is_array($marche->besoins_materiels))
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs uppercase bg-gray-50 text-gray-700 font-bold">
                                    <tr>
                                        <th class="p-3">Désignation de la prestation / matériel</th>
                                        <th class="p-3 text-right">Votre Quantité Proposée</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($marche->besoins_materiels as $index => $item)
                                        <tr>
                                            <td class="p-3 font-medium text-gray-800">
                                                {{ $item['designation'] ?? $item['nom'] ?? 'Élément #' . ($index + 1) }}
                                                <input type="hidden" name="propositions_techniques[{{ $index }}][designation]" value="{{ $item['designation'] ?? $item['nom'] ?? '' }}">
                                            </td>
                                            <td class="p-3 text-right">
                                                <input 
                                                    type="number" 
                                                    name="propositions_techniques[{{ $index }}][quantite]" 
                                                    class="w-32 text-right px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm" 
                                                    placeholder="0" 
                                                    min="0"
                                                    required 
                                                />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-4 bg-gray-50 rounded-xl text-center text-gray-500 text-sm">
                                Aucune spécification technique particulière enregistrée pour ce marché.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 4. Proposition Financière -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">4. Offre Financière Globale</h2>
                    
                    <div>
                        <label for="proposition_financiere" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Montant Total Proposé TTC (FCFA) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="proposition_financiere" 
                            name="proposition_financiere" 
                            step="0.01" 
                            value="{{ old('proposition_financiere', $candidature->proposition_financiere ?? '') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 font-bold text-lg text-emerald-700" 
                            placeholder="Ex: 8500000" 
                            required 
                        />
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ url()->previous() }}" class="text-xs font-bold text-cyan-700 hover:text-cyan-900 uppercase tracking-wider">
                        ← Retour
                    </a>
                    
                    <button 
                        type="submit" 
                        class="inline-flex items-center rounded-lg bg-cyan-700 hover:bg-cyan-800 px-6 py-3 text-xs font-bold text-white shadow-sm transition uppercase tracking-wider cursor-pointer">
                        Enregistrer / Transmettre la Candidature →
                    </button>
                </div>
            </form>

        </div>
    </main>

    @include('components.footer')

</body>
</html>