<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Équipe Projet SNGP-BAD</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F4F7F6]">

    @include('components.header')

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-20">
                <span class="text-[#27AE60] font-black uppercase tracking-[0.3em] text-xs">SNGP-BAD</span>
                <h2 class="text-4xl font-extrabold text-[#1B4F72] mt-4 mb-6">
                    L'Équipe de Digitalisation
                </h2>
                <div class="h-1.5 w-24 bg-[#27AE60] mx-auto rounded-full"></div>
                <p class="mt-8 text-gray-600 max-w-2xl mx-auto leading-relaxed text-lg">
                    Une équipe d'experts de la <strong>DSID</strong> dédiée à la réussite du Système National de Gestion des Projets.
                </p>
            </div>

            <div class="flex flex-col items-center">
                
                <div class="relative flex flex-col items-center">
                    <x-team-card 
                        :level="1" 
                        name="M. Toto Hien Jean Paul" 
                        role="Directeur de la DSID" 
                    />
                    <div class="h-16 w-1 bg-gradient-to-b from-[#27AE60] to-gray-300"></div>
                </div>

                <div class="relative flex flex-col items-center">
                    <x-team-card 
                        :level="2" 
                        name="Mme N'Guessan" 
                        role="Sous-Directrice" 
                    />
                    <div class="h-16 w-1 bg-gray-300"></div>
                </div>

                <div class="w-full flex flex-col items-center">
                    <div class="h-px w-full max-w-4xl bg-gray-300"></div>
                    
                    <div class="flex justify-between w-full max-w-4xl">
                        <div class="h-8 w-px bg-gray-300"></div>
                        <div class="h-8 w-px bg-gray-300"></div>
                        <div class="h-8 w-px bg-gray-300"></div>
                        <div class="h-8 w-px bg-gray-300"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 w-full mt-4">
                        <x-team-card 
                            :level="3" 
                            name="M. Gbaney" 
                            role="Développeur" 
                        />
                        <x-team-card 
                            :level="3" 
                            name="M. Diarassouba" 
                            role="Développeur" 
                        />
                        <x-team-card 
                            :level="3" 
                            name="M. Lela" 
                            role="Développeur" 
                        />
                        <x-team-card 
                            :level="3" 
                            name="Kouassi Yao J.P. Danick" 
                            role="Développeur Multimédia" 
                        />
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>