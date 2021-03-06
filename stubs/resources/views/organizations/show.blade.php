<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ $organization->name }}
        </h1>
    </x-slot>

    <p>{{ $organization->locality }}, {{ get_region_name($organization->region, ["CA"], locale()) }}</p>

    @can('update', $organization)
    <p><a href="{{ localized_route('organizations.edit', $organization) }}">{{ __('organization.edit_organization') }}</a></p>
    @endcan

    @can('join', $organization)
    <form action="{{ localized_route('organizations.join', $organization) }}" method="POST">
        @csrf
        <button>{{ __('Request to join') }}</button>
    </form>
    @endcan
    @if(Auth::user()->hasRequestedToJoin($organization))
    <form action="{{ localized_route('requests.cancel') }}" method="POST">
        @csrf
        <button>{{ __('Cancel request to join :organization', ['organization' => $organization->name]) }}</button>
    </form>
    @endif
</x-app-layout>
