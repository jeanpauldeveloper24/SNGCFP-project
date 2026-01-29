<aside x-data="{ open: true }" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1B4F72] text-white transition-transform duration-300 transform lg:translate-x-0 flex flex-col shadow-2xl"
    :class="{'translate-x-0': open, '-translate-x-full': !open}">
    
    <div class="flex items-center px-6 h-20 bg-[#0d2a3d] shrink-0 border-b border-white/5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="font-montserrat font-bold text-xl tracking-tighter text-white">SNG<span class="text-[#27AE60]">CFP</span></span>
        </a>
    </div>

    <nav class="flex-1 mt-4 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <div class="space-y-1 mb-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">{{ __('Tableau de bord') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('profile.edit') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="font-medium">{{ __('Mon Profil') }}</span>
            </x-nav-link>
        </div>

        @php $role = strtoupper(Auth::user()->role); @endphp

        @if(in_array($role, ['COMPTABLE_BAD', 'GESTIONNAIRE_BUDGET', 'ORDONNATEUR', 'ADMIN']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Gestion Financière</p>
            <a href="{{ route('finances.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('finances.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Finances & Budget</span>
            </a>
            <a href="{{ route('comptabilite.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('comptabilite.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Comptabilité & Paiements</span>
            </a>
            <a href="{{ route('budget.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('budget.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Suivi Budgétaire</span>
            </a>
        </div>
        @endif

        @if(in_array($role, ['SPECIALISTE_MARCHE', 'ADMIN']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Marchés Publics</p>
            <a href="{{ route('passation.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('passation.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Plan de Passation</span>
            </a>
            <a href="{{ route('marches.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('marches.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Dossiers d'Appel d'Offres</span>
            </a>
        </div>
        @endif

        @if(in_array($role, ['CONTROLEUR_INTERNE', 'ADMIN']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Audit & Rapports</p>
            <a href="{{ route('audit.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('audit.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Analyses & Audit</span>
            </a>
            <a href="{{ route('rapports.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('rapports.index') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Rapports BAD</span>
            </a>
            <a href="{{ route('audit.logs') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('audit.logs') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Audit Logs</span>
            </a>
        </div>
        @endif

        <div class="mb-6 pt-4 border-t border-white/10">
            <p class="text-[10px] font-bold text-[#27AE60] uppercase px-3 mb-2 tracking-widest text-center lg:text-left">Communication</p>
            
            <div class="space-y-1">
                <a href="{{ route('messages.index') }}" 
   class="flex items-center justify-between p-3 rounded-lg bg-white/5 text-white hover:bg-[#2E86C1] transition-all group {{ request()->routeIs('messages.index') ? 'bg-[#2E86C1] text-white' : '' }}">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <span class="font-bold text-sm">Messagerie</span>
    </div>
    <span class="bg-[#ff4d4d] text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-sm">3</span>
</a>

                <a href="{{ route('notifications.index') }}" 
   class="flex items-center justify-between p-3 rounded-lg bg-white/5 text-white hover:bg-[#2E86C1] transition-all group {{ request()->routeIs('notifications.index') ? 'bg-[#2E86C1] text-white' : '' }}">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="font-bold text-sm">Notifications</span>
    </div>
    <span class="bg-yellow-500 text-[10px] text-black font-black px-2 py-0.5 rounded-full shadow-sm">3</span>
</a>
            </div>
        </div>

    </nav>

    <div class="p-4 bg-[#0d2a3d] shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                onclick="event.preventDefault(); this.closest('form').submit();"
                class="w-full flex items-center justify-center gap-3 p-3 rounded-xl bg-[#ff4d4d] hover:bg-[#e60000] transition-all text-sm font-bold shadow-lg shadow-black/20 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span>DÉCONNEXION</span>
            </button>
        </form>
    </div>
</aside>