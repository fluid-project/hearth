<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('resource-collection.create_title') }}
        </h1>
    </x-slot>

    <!-- Form Validation Errors -->
    @include('partials.validation-errors')
    <form action="{{ localized_route('resource-collections.store') }}" method="POST" novalidate>
        @csrf
        <x-hearth-input id="user_id" type="hidden" name="user_id" :value="Auth::user()->id" required />

        <div class="field @error('title') field--error @enderror">
            <x-hearth-label for="title" :value="__('resource-collection.label_title')" />
            <x-hearth-input id="title" type="text" name="title" :value="old('title')" required />
            <x-hearth-error for="title" />
            </div>
        <div class="field @error('description') field--error @enderror">
            <x-hearth-label for="description" :value="__('resource-collection.label_description')" />
            <x-hearth-textarea name="description" :value="old('description')" required />
            <x-hearth-error for="description" />
        </div>

        <x-hearth-button>{{ __('resource-collection.action_create') }}</x-hearth-button>
    </form>
</x-app-layout>
