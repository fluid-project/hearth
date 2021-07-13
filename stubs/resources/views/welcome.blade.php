<x-app-layout>
    <x-slot name="header">
        <h1 itemprop="name">{{ config('app.name', 'Hearth') }}</h1>
    </x-slot>

    <p>{{ __('welcome.intro') }}</p>
    <p>{{ __('welcome.details') }}</p>
</x-app-layout>
