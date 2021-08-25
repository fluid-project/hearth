<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('membership.edit_user_role_title', ['user' => $user->name]) }}
        </h1>
    </x-slot>

    <!-- Form Validation Errors -->
    @include('partials.validation-errors')

    <p>{{ __('membership.edit_user_role_intro', ['user' => $user->name, 'memberable' => $memberable->name]) }}</p>

    <form action="{{ localized_route('memberships.update', $membership) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <fieldset @error('role') class="field--error" @enderror>
            <legend>{{ __('organization.label_user_role') }}</legend>
            @foreach($roles as $role => $label)
            <div class="field">
                <x-hearth-input type="radio" name="role" id="role-{{ $role }}" value="{{ $role }}" {{ ($role === $membership->role) ? 'checked' : '' }} />
                <x-hearth-label for="role-{{ $role }}">{{ $label }}</label>
            </div>
            @endforeach
        </fieldset>
        <a class="button" href="{{ localized_route($memberable->getRoutePrefix() . '.edit', $memberable) }}">{{ __('organization.action_cancel_user_role_update') }}</a>
        <x-hearth-button>{{ __('organization.action_update_user_role') }}</x-hearth-button>
    </form>
</x-app-layout>
