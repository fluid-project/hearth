@error($field, $bag)
<p class="field__error" id="{{ $for }}-error">
    {{ $message }}
</p>
@elseif($slot)
<p class="field__error" id="{{ $for }}-error">
    {{ $slot }}
</p>
@enderror
