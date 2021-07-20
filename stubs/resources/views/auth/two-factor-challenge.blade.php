<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Accessibility in Action') }}
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ localized_route('two-factor.login') }}">
            @csrf

            <!-- Two-Factor Code -->
            <div class="field">
                <x-hearth-label for="code" :value="__('hearth::auth.two_factor_auth_code')" />

                <x-hearth-input id="code"
                                type="text"
                                name="code"
                                inputmode="numeric"
                                required autocomplete="one-time-code" />
            </div>

            <x-hearth-button>
                {{ __('hearth::auth.sign_in') }}
            </x-hearth-button>
        </form>
    </x-auth-card>
</x-guest-layout>
