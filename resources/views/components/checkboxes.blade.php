@foreach($options as $value => $atts)
<div class="field">
    @php($hint = isset($atts['hint']) ? $name . '-' . Str::slug($value) . '-hint' : '')
    <input {!! $attributes !!} type="checkbox" name="{{ $name }}[]" id="{{ $name }}-{{ Str::slug($value) }}" value="{{ $value }}" {!! $describedBy($hint) ? 'aria-describedby="' . $describedBy($hint) . '"' : '' !!} @checked(in_array($value, $checked, true)) {!! $invalid ? 'aria-invalid="true"' : '' !!} />
    <x-hearth-label for="{{ $name }}-{{ Str::slug($value) }}">{{ $atts['label'] }}</x-hearth-label>
    @if(isset($atts['hint']))
    <x-hearth-hint for="{{ $name }}-{{ Str::slug($value) }}">{{ $atts['hint'] }}</x-hearth-hint>
    @endif
</div>
@endforeach
