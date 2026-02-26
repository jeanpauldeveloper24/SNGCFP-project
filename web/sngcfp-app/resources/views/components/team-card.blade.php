@props(['level', 'name', 'role'])

@php
    $isLevelOne = ($level == 1);
    
    // Classes de taille et couleur
    // On augmente un peu la largeur (w-72) pour que les noms longs comme "M. Toto Hien Jean Paul" ne soient pas coupés
    $cardClasses = match(true) {
        $level == 1 => 'w-72 p-6 bg-[#1B4F72] text-white shadow-2xl scale-110 z-10 border-b-4 border-[#27AE60]',
        $level <= 3 => 'w-56 p-4 bg-white text-[#1B4F72] shadow-md border-t-4 border-[#27AE60]',
        default    => 'w-40 p-3 bg-white text-[#1B4F72] shadow-sm text-xs border-t-2 border-gray-200',
    };

    $roleColor = ($level == 1) ? 'text-[#27AE60]' : 'text-gray-500';
@endphp

<div class="{{ $cardClasses }} rounded-xl flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2">
    <div class="relative">
        <div class="w-16 h-16 rounded-full bg-gray-100 mb-3 flex items-center justify-center border-2 border-[#27AE60] shadow-inner overflow-hidden">
            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
        @if($isLevelOne)
            <span class="absolute -top-1 -right-2 bg-yellow-400 text-[10px] text-black font-black px-2 py-0.5 rounded shadow-md uppercase">Chef</span>
        @endif
    </div>

    <h4 class="font-bold leading-tight {{ $level == 1 ? 'text-lg' : 'text-sm' }}">
        {{ $name }}
    </h4>
    
    <p class="{{ $roleColor }} text-[10px] uppercase tracking-widest mt-2 font-bold">
        {{ $role }}
    </p>
</div>