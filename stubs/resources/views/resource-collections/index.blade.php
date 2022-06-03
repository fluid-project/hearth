<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('resourceCollection.index_title') }}
        </h1>
    </x-slot>

   <div class="flow">
    @forelse($resourceCollections as $resourceCollection)
    <article>
        <h2>
            <a href="{{ localized_route('resource-collections.show', $resourceCollection) }}">{{ $resourceCollection->title }}</a>
        </h2>
    </article>
    @empty
    <p>{{ __('resourceCollection.none_found') }}</p>
    @endforelse
    </div>
</x-app-layout>
