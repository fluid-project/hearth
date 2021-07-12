@if (flash()->message)
    <x-hearth-alert :type="flash()->class">
        <p>{{ flash()->message }}
    </x-hearth-alert>
@endif

@if(session('status') === 'verification-link-sent')
<x-hearth-alert type="success">
    <p>{{ __('hearth::auth.verification_sent') }}</p>
</x-hearth-alert>
@endif

@if(session('status') === 'password-updated')
<x-hearth-alert type="success">
    <p>{{ __('hearth::auth.password_change_succeeded') }}</p>
</x-hearth-alert>
@endif

@auth
@unless(Auth::user()->hasVerifiedEmail())
    <x-hearth-alert type="notice">
        <p>{{ __('hearth::auth.verification_intro') }}</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-hearth-button>
                    {{ __('hearth::auth.resend_verification_email') }}
                </x-hearth-button>
            </div>
        </form>
    </x-hearth-alert>
@endunless
@endauth


