<input type="checkbox"
    {!! $attributes->merge([
        'name' => $name,
        'id' => $id,
    ]) !!}
    value="1"
    {{ $required ? 'required' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    @disabled($disabled)
    @checked($checked)
    {!! $describedBy() ? 'aria-describedby="' . $describedBy() . '"' : '' !!}
    {!! $invalid ? 'aria-invalid="true"' : '' !!}
>
