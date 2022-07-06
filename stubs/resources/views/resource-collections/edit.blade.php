<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('resource-collection.edit_title') }}
        </h1>
    </x-slot>

    <!-- Form Validation Errors -->
    @include('partials.validation-errors')

    <form action="{{ localized_route('resource-collections.update', $resourceCollection) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="field @error('title') field--error @enderror">
            <x-hearth-label for="title" :value="__('resource-collection.label_title')" />
            <x-hearth-input id="title" type="text" name="title" :value="old('title', $resourceCollection->title)" required />
            <x-hearth-error for="title" />
            </div>
        <div class="field @error('description') field--error @enderror">
            <x-hearth-label for="description" :value="__('resource-collection.label_description')" />
            <x-hearth-textarea name="description" :value="old('description', $resourceCollection->description)" required />
            <x-hearth-error for="description" />
        </div>

        <x-hearth-button>{{ __('forms.save_changes') }}</x-hearth-button>
    </form>

    <h2>
        {{ __('resource-collection.delete_title') }}
    </h2>

    <p>{{ __('resource-collection.delete_intro') }}</p>

    <form action="{{ localized_route('resource-collections.destroy', $resourceCollection) }}" method="POST" novalidate>
        @csrf
        @method('DELETE')

        <div class="field @error('current_password', 'destroyResourceCollection') field--error @enderror">
            <x-hearth-label for="current_password" :value="__('hearth::auth.label_current_password')" />
            <x-hearth-input id="current_password" type="password" name="current_password" required />
            <x-hearth-error for="current_password" bag="destroyResourceCollection" />
        </div>

        <x-hearth-button>
            {{ __('resource-collection.action_delete') }}
        </x-hearth-button>
    </form>
</x-app-layout>
