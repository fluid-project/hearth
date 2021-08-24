@props(['disabled' => false, 'hinted' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'aria-describedby' => $describedBy ? $describedBy : false
]) !!}>
