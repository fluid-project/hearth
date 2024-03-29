<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors :errors="$errors" />

        <form method="POST" action="{{ localized_route('login') }}" novalidate>
            @csrf

            <!-- Email Address -->
            <div class="field @error('email') field--error @enderror">
                <x-hearth-label for="email" :value="__('hearth::forms.label_email')" />
                <x-hearth-input name="email" type="email" :value="old('email')" required autofocus />
                <x-hearth-error for="email" />
            </div>

            <!-- Password -->
            <div class="field @error('password') field--error @enderror">
                <x-hearth-label for="password" :value="__('hearth::auth.label_password')" />
                <x-hearth-input name="password" type="password" required autocomplete="current-password" />
                <x-hearth-error for="password" />
            </div>

            <!-- Remember Me -->
            <div class="field">
                <x-hearth-input name="remember" type="checkbox" />
                <x-hearth-label for="remember" :value="__('hearth::auth.label_remember_me')" />
            </div>

            @if (Route::has('en.password.request'))
            <p>
                <a href="{{ localized_route('password.request') }}">
                    {{ __('hearth::auth.forget_prompt') }}
                </a>
            </p>
            @endif

            <button>
                {{ __('hearth::auth.sign_in') }}
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
