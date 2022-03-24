<input type="checkbox"
    {!! $attributes->merge([
        'name' => $name,
        'id' => $id,
    ]) !!}
    value="1" @checked($checked)
    {{ $required ? 'required' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {!! $describedBy() ? 'aria-describedby="' . $describedBy() . '"' : '' !!}
    {!! $invalid ? 'aria-invalid="true"' : '' !!}
>
