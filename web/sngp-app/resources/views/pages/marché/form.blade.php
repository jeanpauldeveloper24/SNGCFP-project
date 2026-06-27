<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | {{ isset($marche) ? 'Édition' : 'Initialisation' }} du Marché</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased min-h-screen flex flex-col justify-between">

    @include('components.header')

    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            
            <div class="mb-8 border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ isset($marche) ? 'Régulation & Édition du Marché' : 'Initialisation du Marché Public' }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Gestion des étapes d'attribution, du dépôt des candidatures et de l'immatriculation du prestataire retenu.
                    </p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-sm font-semibold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                        Procédure de Passation
                    </span>
                </div>
            </div>

            <form action="{{ isset($marche) ? route('menus.marches.update', $marche->id) : route('menus.marches.store') }}" method="POST" class="space-y-8">
                @csrf
                @if(isset($marche))
                    @method('PUT')
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">1. Caractéristiques Générales</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label for="objet" class="block text-xs font-semibold text-gray-700 uppercase">Objet du Marché (Nature de la prestation)</label>
                            <input type="text" name="objet" id="objet" value="{{ old('objet', $marche->objet ?? '') }}" placeholder="ex: Travaux de construction d'un forage ou Fourniture de matériel informatique..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-medium text-gray-900" required>
                        </div>

                        <div>
                            <label for="project_id" class="block text-xs font-semibold text-gray-700 uppercase">Ligne Projet Associée</label>
                            <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs text-gray-800" required>
                                <option value="" disabled selected>-- Sélectionner un projet --</option>
                                @foreach($projects as $proj)
                                    <option value="{{ $proj->id }}" {{ (old('project_id', $marche->project_id ?? '') == $proj->id) ? 'selected' : '' }}>[{{ $proj->code }}] {{ $proj->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="montant" class="block text-xs font-semibold text-gray-700 uppercase">Montant global du Marché (FCFA)</label>
                            <input type="number" name="montant" id="montant" value="{{ old('montant', $marche->montant ?? '') }}" placeholder="ex: 45000000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-mono font-bold text-cyan-800" required>
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-semibold text-gray-700 uppercase">État Actuel du Marché</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-bold text-gray-700" required>
                                <option value="Non attribué" {{ (old('status', $marche->status ?? '') == 'Non attribué') ? 'selected' : '' }}>Non attribué</option>
                                <option value="En cours d'attribution" {{ (old('status', $marche->status ?? '') == 'En cours d\'attribution') ? 'selected' : '' }}>En cours d'attribution</option>
                                <option value="Attribué" {{ (old('status', $marche->status ?? '') == 'Attribué') ? 'selected' : '' }}>Attribué</option>
                            </select>
                        </div>

                        <div>
                            <label for="etape" class="block text-xs font-semibold text-gray-700 uppercase">Étape du Processus</label>
                            <select name="etape" id="etape" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-medium text-gray-800" required>
                                <option value="Expression du besoin" {{ (old('etape', $marche->etape ?? '') == 'Expression du besoin') ? 'selected' : '' }}>1. Expression du besoin</option>
                                <option value="Lancement de l'AO" {{ (old('etape', $marche->etape ?? '') == 'Lancement de l\'AO') ? 'selected' : '' }}>2. Lancement de l’Appel d'Offres (AO)</option>
                                <option value="Analyse des offres" {{ (old('etape', $marche->etape ?? '') == 'Analyse des offres') ? 'selected' : '' }}>3. Analyse des candidatures</option>
                                <option value="Attribution" {{ (old('etape', $marche->etape ?? '') == 'Attribution') ? 'selected' : '' }}>4. Notification d'attribution</option>
                                <option value="1er versement" {{ (old('etape', $marche->etape ?? '') == '1er versement') ? 'selected' : '' }}>5. Avance de démarrage (1er versement)</option>
                                <option value="En cours d'exécution" {{ (old('etape', $marche->etape ?? '') == 'En cours d\'exécution') ? 'selected' : '' }}>6. Travaux / Prestations en cours</option>
                                <option value="Fin du marché" {{ (old('etape', $marche->etape ?? '') == 'Fin du marché') ? 'selected' : '' }}>7. Réception finale (Fin du marché)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-cyan-700 uppercase tracking-wider">2. Chronogramme Officiel</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                        <div>
                            <label for="candidature_start_date" class="block font-semibold text-gray-700 uppercase">Début Dépôt Dossiers</label>
                            <input type="date" name="candidature_start_date" id="candidature_start_date" value="{{ old('candidature_start_date', isset($marche) && $marche->candidature_start_date ? $marche->candidature_start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                        </div>
                        <div>
                            <label for="candidature_end_date" class="block font-semibold text-gray-700 uppercase">Fin Dépôt Dossiers</label>
                            <input type="date" name="candidature_end_date" id="candidature_end_date" value="{{ old('candidature_end_date', isset($marche) && $marche->candidature_end_date ? $marche->candidature_end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                        </div>
                        <div>
                            <label for="date_attribution" class="block font-semibold text-gray-700 uppercase">Date Signature Contrat</label>
                            <input type="date" name="date_attribution" id="date_attribution" value="{{ old('date_attribution', isset($marche) && $marche->date_attribution ? $marche->date_attribution->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                        </div>
                        <div>
                            <label for="date_lancement" class="block font-semibold text-gray-700 uppercase">Date Ordre de Service (OS)</label>
                            <input type="date" name="date_lancement" id="date_lancement" value="{{ old('date_lancement', isset($marche) && $marche->date_lancement ? $marche->date_lancement->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 font-mono">
                        </div>
                    </div>
                </div>

                <div id="section_prestataire" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">3. Titulaire du Marché (Uniquement si Attribué)</h3>
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
                        <p class="text-[11px] text-gray-400 mt-2">L'utilisateur sélectionné doit posséder le rôle fonctionnel **PRESTATAIRE** afin d'interagir avec l'écosystème Flutter terrain.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 border-t border-gray-200 pt-6">
                    <a href="{{ route('menus.marches.liste') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 uppercase tracking-wider transition">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-emerald-600 py-2 px-6 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 uppercase tracking-wider transition">
                        {{ isset($marche) ? '⚡ Mettre à jour le dossier' : '💾 Enregistrer le projet de marché' }}
                    </button>
                </div>
            </form>

        </div>
    </main>

    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const sectionPrestataire = document.getElementById('section_prestataire');

            function togglePrestataireSection() {
                if (statusSelect.value === 'Attribué') {
                    sectionPrestataire.style.opacity = '1';
                    sectionPrestataire.style.pointerEvents = 'auto';
                } else {
                    sectionPrestataire.style.opacity = '0.5';
                }
            }

            statusSelect.addEventListener('change', togglePrestataireSection);
            togglePrestataireSection();
        });
    </script>
</body>
</html>