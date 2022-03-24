<li {{ $attributes->merge(['class' => 'dropdown']) }} x-data="{ open: false }" @keyup.escape.window="open = false" @click.outside="open = false" @close.stop="open = false">
    <button class="link" @click="open = ! open" x-bind:aria-expanded="open.toString()">
        {{ $trigger }}
    </button>

    <ul role="list" @click="open = false">
        {{ $content }}
    </ul>
</li>
