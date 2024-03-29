<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <div>
            {{ __('hearth::auth.confirm_intro') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ localized_route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="field @error('password') field--error @enderror">
                <x-hearth-label for="password" :value="__('hearth::auth.label_password')" />
                <x-hearth-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-hearth-error for="password" />
            </div>

            <button>
                {{ __('hearth::auth.action_confirm') }}
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
