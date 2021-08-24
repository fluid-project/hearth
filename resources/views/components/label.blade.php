<label {{ $attributes->merge([]) }}>
    {{ $value ? $value : $slot }}
</label>
