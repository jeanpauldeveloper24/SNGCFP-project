<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Présentation du Projet SNGP-BAD</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F4F7F6]">

    @include('components.header')

    <section class="relative bg-[#1B4F72] py-24 text-white overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <svg width="400" height="400" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="0.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <span class="text-[#27AE60] font-black uppercase tracking-widest text-sm">Système National de Gestion des Projets</span>
            <h1 class="text-5xl font-extrabold mt-6 mb-8 leading-tight">
                Digitaliser la Performance du <br><span class="text-[#27AE60]">Portefeuille BAD</span>
            </h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Une plateforme intégrée pour l'optimisation, la transparence et le suivi transactionnel des projets financés par la Banque Africaine de Développement.
            </p>
        </div>
    </section>

    <main class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-32">
                <div>
                    <h2 class="text-3xl font-bold text-[#1B4F72] mb-6">Répondre aux exigences de rigueur de la BAD</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Le <strong>SNGP-BAD</strong> est né de la volonté de moderniser le cycle de vie des projets. Conformément aux directives de la BAD, le système assure :
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-1 bg-[#27AE60] p-1 rounded-full text-white"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-gray-700"><strong>Traçabilité totale</strong> des fonds depuis l'approbation jusqu'au décaissement final.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 bg-[#27AE60] p-1 rounded-full text-white"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-gray-700"><strong>Réduction des délais</strong> de passation de marchés grâce à des workflows automatisés.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 bg-[#27AE60] p-1 rounded-full text-white"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-gray-700"><strong>Reporting en temps réel</strong> pour les auditeurs et les directions nationales.</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-[#F4F7F6] rounded-2xl">
                            <div class="text-3xl font-bold text-[#1B4F72]">100%</div>
                            <div class="text-xs text-gray-500 uppercase mt-2">Transactionnel</div>
                        </div>
                        <div class="text-center p-6 bg-[#F4F7F6] rounded-2xl">
                            <div class="text-3xl font-bold text-[#27AE60]">Sécurisé</div>
                            <div class="text-xs text-gray-500 uppercase mt-2">Multi-Rôles</div>
                        </div>
                        <div class="text-center p-6 bg-[#F4F7F6] rounded-2xl">
                            <div class="text-3xl font-bold text-[#27AE60]">Multi-plateforme</div>
                            <div class="text-xs text-gray-500 uppercase mt-2">Web & Desktop</div>
                        </div>
                        <div class="text-center p-6 bg-[#F4F7F6] rounded-2xl">
                            <div class="text-3xl font-bold text-[#1B4F72]">Audit</div>
                            <div class="text-xs text-gray-500 uppercase mt-2">Logs complets</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-[#1B4F72]">Une Architecture de Pointe</h2>
                <div class="h-1 w-20 bg-[#27AE60] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-2xl shadow-sm border-t-4 border-[#2E86C1] hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-50 text-[#2E86C1] rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Gestion Financière</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Suivi des budgets, engagements et paiements. Synchronisation directe avec les plans de financement de la BAD.</p>
                </div>

                <div class="bg-white p-10 rounded-2xl shadow-sm border-t-4 border-[#27AE60] hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-green-50 text-[#27AE60] rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Marchés Publics</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Plan de passation, gestion des DAO, et suivi des contrats prestataires selon les normes internationales.</p>
                </div>

                <div class="bg-white p-10 rounded-2xl shadow-sm border-t-4 border-[#1B4F72] hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gray-50 text-[#1B4F72] rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Contrôle & Audit</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Tableaux de bord analytiques pour les auditeurs et génération automatique de rapports de performance (RSF).</p>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-[#0d2a3d] py-12 text-center text-white/50 text-sm">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} SNGP-BAD - Direction des Systèmes d'Information (DSID). Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>