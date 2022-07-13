@foreach($options as $value => $atts)
<div class="field">
    @php($id = $name . '-' . Str::slug($value))
    @php($hint = isset($atts['hint']) ? $id . '-hint' : '')
    <input {!! $attributes !!} type="checkbox" name="{{ $name }}[]" id="{{ $id }}" value="{{ $value }}" {!! $describedBy($hint) ? 'aria-describedby="' . $describedBy($hint) . '"' : '' !!} @checked(in_array($value, $checked, true)) {!! $invalid ? 'aria-invalid="true"' : '' !!} />
    <x-hearth-label for="{{ $id }}">{{ $atts['label'] }}</x-hearth-label>
    @if(isset($atts['hint']))
    <x-hearth-hint for="{{ $id }}">{{ $atts['hint'] }}</x-hearth-hint>
    @endif
</div>
@endforeach
