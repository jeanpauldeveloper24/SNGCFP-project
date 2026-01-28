<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SNGP-BAD') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|montserrat:400,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-gray-100">
        <div class="flex min-h-screen">
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 bg-[#F4F7F6] lg:ml-64">
                
                <header class="bg-white h-20 shadow-sm flex items-center px-8 border-b border-gray-200 sticky top-0 z-40">
                    <div class="flex justify-between items-center w-full">
                        
                        <h2 class="font-bold text-xl text-[#1B4F72] uppercase tracking-wide">
                            {{ $header ?? 'SNGP-BAD' }}
                        </h2>
                        
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800 leading-none">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-[10px] text-[#27AE60] font-extrabold uppercase tracking-widest mt-1">
                                    {{ Auth::user()->role ?? 'Utilisateur' }}
                                </p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-[#1B4F72] flex items-center justify-center text-white font-bold shadow-md border-2 border-gray-50">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>

                    </div>
                </header>

                <main class="flex-1 p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>