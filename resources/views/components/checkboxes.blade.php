@foreach($options as $value => $label)
<div class="field">
    <input {!! $attributes !!} type="checkbox" name="{{ $name }}" id="{{ $name }}-{{ $value }}" value="{{ $value }}" {!! $describedBy() ? 'aria-describedby="' . $describedBy() . '"' : '' !!} @if ($value === $selected) checked @endif />
    <x-hearth-label for="{{ $name }}-{{ $value }}">{{ $label }}</x-hearth-label>
</div>
@endforeach
