<x-app-layout>
    <x-slot name="header">
        <h1 itemprop="name">{{ config('app.name', 'Hearth') }}</h1>
    </x-slot>

    <p>{{ __('hearth::welcome.intro') }}</p>
    <p>{{ __('hearth::welcome.details') }}</p>
</x-app-layout>
