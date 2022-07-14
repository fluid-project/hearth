@foreach($options as $value => $atts)
<div class="field">
    @php($id = $name . '-' . Str::slug($value))
    @php($hint = isset($atts['hint']) ? $id . '-hint' : '')
    <input {!! $attributes !!} type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" {!! $describedBy($hint) ? 'aria-describedby="' . $describedBy($hint) . '"' : '' !!} @checked($checked == $value) {!! $invalid ? 'aria-invalid="true"' : '' !!} />
    <x-hearth-label for="{{ $id }}">{{ $atts['label'] }}</x-hearth-label>
    @if(isset($atts['hint']))
    <x-hearth-hint for="{{ $id }}">{{ $atts['hint'] }}</x-hearth-hint>
    @endif
</div>
@endforeach
