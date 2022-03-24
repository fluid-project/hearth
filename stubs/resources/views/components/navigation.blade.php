<!-- Primary Navigation Menu -->
<nav x-data="{ open: false }" aria-label="{{ 'primary menu' }}" @keyup.escape.window="open = false" @click.outside="open = false" @close.stop="open = false">
    <button @click="open = ! open" x-bind:aria-expanded="open.toString()">
        {{ __('Menu') }}
    </button>

    <!-- Navigation Links -->
    <ul role="list" class="nav">
        @auth
        <x-nav-link :href="localized_route('dashboard')" :active="request()->routeIs(locale() . '.dashboard')">
            {{ __('hearth::dashboard.title') }}
        </x-nav-link>
        @else
        @if (Route::has(locale() . '.register'))
        <x-nav-link :href="localized_route('register')">
            {{ __('hearth::auth.create_account') }}
        </x-nav-link>
        @endif
        <x-nav-link :href="localized_route('login')">
            {{ __('hearth::auth.sign_in') }}
        </x-nav-link>
        @endauth

        @auth
        <!-- User Dropdown -->
        <x-nav-dropdown class="user">
            <x-slot name="trigger">
                {{ Auth::user()->name }}
            </x-slot>

            <x-slot name="content">
                <x-nav-link href="{{ localized_route('users.edit') }}" :active="request()->routeIs(locale() . '.users.edit')">
                    {{ __('hearth::user.settings') }}
                </x-nav-link>

                <x-nav-link href="{{ localized_route('users.admin') }}" :active="request()->routeIs(locale() . '.users.admin')">
                    {{ __('hearth::user.account') }}
                </x-nav-link>

                <!-- Authentication -->
                <x-nav-link :href="localized_route('logout')" x-on:click.prevent="$refs.form.submit()">
                    {{ __('hearth::auth.sign_out') }}
                </x-nav-link>

                <form method="POST" action="{{ localized_route('logout') }}" x-ref="form">
                    @csrf
                </form>
            </x-slot>
        </x-nav-dropdown>
        @endauth

        <!-- Language Switcher -->
        <x-hearth-language-switcher class="languages" />
    </ul>
</nav>
