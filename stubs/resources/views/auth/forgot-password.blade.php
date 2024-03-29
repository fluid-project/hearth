<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <div>
            {{ __('hearth::auth.forgot_intro') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="field @error('email') field--error @enderror">
                <x-hearth-label for="email" :value="__('hearth::forms.label_email')" />
                <x-hearth-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                <x-hearth-error for="email" />
            </div>

            <button>
                {{ __('hearth::auth.forgot_submit') }}
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
