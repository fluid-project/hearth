<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ localized_route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div class="field @error('email') field--error @enderror">
                <x-hearth-label for="email" :value="__('hearth::forms.label_email')" />
                <x-hearth-input name="email" type="email" :value="old('email', request()->get('email'))" required autofocus />
                <x-hearth-error for="email" />
            </div>

            <!-- Password -->
            <div class="field @error('password') field--error @enderror">
                <x-hearth-label for="password" :value="__('hearth::auth.label_password')" />
                <x-hearth-input name="password" type="password" required />
                <x-hearth-error for="password" />
            </div>

            <!-- Confirm Password -->
            <div class="field @error('password_confirmation') field--error @enderror">
                <x-hearth-label for="password_confirmation" :value="__('hearth::auth.label_password_confirmation')" />
                <x-hearth-input name="password_confirmation" type="password" required />
                <x-hearth-error for="password_confirmation" />
            </div>

            <x-hearth-button>
                {{ __('hearth::auth.reset_submit') }}
            </x-hearth-button>
        </form>
    </x-auth-card>
</x-guest-layout>
