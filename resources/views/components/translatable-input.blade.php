<div>
    <label for={{ $name }}>
        {{ $label }}
    </label>
    <input {{ $attributes->merge([]) }}>
        {{ $value ?? $slot }}
    </input>
</div>