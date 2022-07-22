@foreach($options as $option)
<div class="field">
    @php($id = $name . '-' . Str::slug($option['value']))
    @php($hint = isset($option['hint']) ? $id . '-hint' : '')
    <input {!! $attributes !!} type="checkbox" name="{{ $name }}[]" id="{{ $id }}" value="{{ $option['value'] }}" {!! $describedBy($hint) ? 'aria-describedby="' . $describedBy($hint) . '"' : '' !!} @checked(in_array($option['value'], $checked)) {!! $invalid ? 'aria-invalid="true"' : '' !!} />
    <x-hearth-label for="{{ $id }}">{{ $option['label'] }}</x-hearth-label>
    @if($option['hint'])
    <x-hearth-hint for="{{ $id }}">{{ $option['hint'] }}</x-hearth-hint>
    @endif
</div>
@endforeach
