<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Accessibility in Action') }}
            </a>
        </x-slot>

        <div>
            {{ __('auth.verification_intro') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <x-hearth-alert type="success">
                {{ __('auth.verification_sent') }}
            </x-hearth-alert>
        @endif

        <div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-hearth-button>
                        {{ __('auth.resend_verification_email') }}
                    </x-hearth-button>
                </div>
            </form>

            <form method="POST" action="{{ localized_route('logout') }}">
                @csrf

                <button type="submit">
                    {{ __('auth.sign_out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
