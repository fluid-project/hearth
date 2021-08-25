@foreach($options as $value => $label)
<div class="field">
    <input type="radio" name="{{ $name }}" id="{{ $name }}-{{ $value }}" value="{{ $value }}" @if ($value === $selected) checked @endif />
    <x-hearth-label for="{{ $name }}-{{ $value }}">{{ $label }}</x-hearth-label>
</div>
@endforeach
