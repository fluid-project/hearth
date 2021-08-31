<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ localized_route('register') }}" novalidate>
            @csrf

            <x-hearth-input id="locale" type="hidden" name="locale" value="{{ locale() ?: config('app.locale') }}" />

            <!-- Name -->
            <div class="field @error('name') field--error @enderror">
                <x-hearth-label for="name" :value="__('hearth::user.label_name')" />
                <x-hearth-input name="name" type="text" :value="old('name')" required autofocus />
                <x-hearth-error for="name" />
            </div>

            <!-- Email Address -->
            <div class="field @error('email') field--error @enderror">
                <x-hearth-label for="email" :value="__('hearth::forms.label_email')" />
                <x-hearth-input name="email" type="email" :value="old('email')" required />
                <x-hearth-error for="email" />
            </div>

            <!-- Password -->
            <div class="field @error('password') field--error @enderror">
                <x-hearth-label for="password" :value="__('hearth::auth.label_password')" />
                <x-hearth-input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-hearth-error for="password" />
            </div>

            <!-- Confirm Password -->
            <div class="field @error('password_confirmation') field--error @enderror">
                <x-hearth-label for="password_confirmation" :value="__('hearth::auth.label_password_confirmation')" />
                <x-hearth-input id="password_confirmation" type="password" name="password_confirmation" required />
                <x-hearth-error for="password_confirmation" />
            </div>

            <div class="field">
                <a href="{{ localized_route('login') }}">
                    {{ __('hearth::auth.existing_account_prompt') }}
                </a>
            </div>

            <x-hearth-button>
                {{ __('hearth::auth.create_your_account') }}
            </x-hearth-button>
        </form>
    </x-auth-card>
</x-guest-layout>
