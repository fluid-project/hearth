<div class="locales">
    <x-dropdown>
        <x-slot name="trigger">
            {{ $locales[locale()] }}
        </x-slot>

        <x-slot name="content">
            @foreach ($locales as $key => $locale )
            <p>
                <x-dropdown-link rel="alternate" hreflang="{{ $key }}" :href="$getLocalizedRoute($key)" :active="request()->routeIs($key . '.*')">
                    {{ $locale }}
                </x-dropdown-link>
            </p>
            @endforeach
        </x-slot>
    </x-dropdown>
</div>
