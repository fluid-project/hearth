<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('hearth::user.settings') }}
        </h1>
    </x-slot>

    <!-- Form Validation Errors -->
    @include('partials.validation-errors')

    <form action="{{ localized_route('user-profile-information.update') }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="field">
            <x-hearth-label for="name" :value="__('hearth::user.label_name')" />
            <x-hearth-input id="name" type="text" name="name" :value="old('name', $user->name)" required />
            @error('name', 'updateProfileInformation')
            <x-validation-error>{{ $message }}</x-validation-error>
            @enderror
        </div>

        <div class="field">
            <x-hearth-label for="email" :value="__('hearth::forms.label_email')" />
            <x-hearth-input id="email" type="email" name="email" :value="old('email', $user->email)" required />
            @error('email', 'updateProfileInformation')
            <x-validation-error>{{ $message }}</x-validation-error>
            @enderror
        </div>

        <div class="field">
            <x-hearth-label for="locale" :value="__('hearth::user.label_locale')" />
            <x-hearth-locale-select :selected="old('locale', $user->locale)" />
        </div>

        <x-hearth-button>
            {{ __('hearth::forms.save_changes') }}
        </x-hearth-button>
    </form>
</x-app-layout>
