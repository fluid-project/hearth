@if (flash()->message)
    <x-alert :type="flash()->class">
        <p>{{ flash()->message }}
    </x-alert>
@endif

@if(session('status') === 'verification-link-sent')
<x-alert type="success">
    <p>{{ __('hearth::auth.verification_sent') }}</p>
</x-alert>
@endif

@if(session('status') === 'password-updated')
<x-alert type="success">
    <p>{{ __('hearth::auth.password_change_succeeded') }}</p>
</x-alert>
@endif

@auth
@unless(Auth::user()->hasVerifiedEmail())
    <x-alert type="notice">
        <p>{{ __('hearth::auth.verification_intro') }}</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-button>
                    {{ __('hearth::auth.resend_verification_email') }}
                </x-button>
            </div>
        </form>
    </x-alert>
@endunless
@endauth


