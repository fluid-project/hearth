<x-nav-dropdown {{ $attributes->merge() }}>
    <x-slot name="trigger">
        {{ __('hearth::nav.languages') }}
    </x-slot>

    <x-slot name="content">
        @foreach ($locales as $key => $locale )
        <x-nav-link rel="alternate" hreflang="{{ $key }}" :href="current_route($key, route($key . '.welcome'))" :active="request()->routeIs($key . '.*')">
            {{ $locale }}
        </x-nav-link>
        @endforeach
    </x-slot>
</x-nav-dropdown>
