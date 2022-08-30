<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ localized_route('welcome') }}">
                {{ config('app.name', 'Hearth') }}
            </a>
        </x-slot>

        <div>
            {{ __('hearth::auth.verification_intro') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <x-hearth-alert type="success">
                {{ __('hearth::auth.verification_sent') }}
            </x-hearth-alert>
        @endif

        <div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button>
                        {{ __('hearth::auth.resend_verification_email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ localized_route('logout') }}">
                @csrf

                <button type="submit">
                    {{ __('hearth::auth.sign_out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
