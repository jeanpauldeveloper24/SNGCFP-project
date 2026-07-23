<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de votre compte, votre numéro de téléphone et votre rôle.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Téléphone -->
        <div>
            <x-input-label for="phone" :value="__('Téléphone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="+225 0700000000" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Rôle (En lecture seule pour des raisons de sécurité) -->
        <div>
            <x-input-label for="role" :value="__('Rôle / Fonction')" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full bg-gray-100 text-gray-600 cursor-not-allowed" :value="old('role', $user->role ?? 'Utilisateur')" readonly disabled />
            <p class="mt-1 text-xs text-gray-500">Le rôle est attribué par l'administrateur et ne peut pas être modifié ici.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>