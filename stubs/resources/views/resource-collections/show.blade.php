<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ $resourceCollection->title }}
        </h1>
    </x-slot>

    {!! Illuminate\Mail\Markdown::parse($resourceCollection->description) !!}

    @can('update', $resourceCollection)
    <p><a href="{{ localized_route('resource-collections.edit', $resourceCollection) }}">{{ __('resource-collection.edit_resource_collection') }}</a></p>
    @endcan
</x-app-layout>
