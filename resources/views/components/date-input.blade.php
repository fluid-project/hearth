<fieldset id="{{ $name }}" x-bind:class="error ? 'date field--error' : 'date'" x-data="dateInput()" x-init="dateToComponents('{{ $value ?? '' }}')">
    <legend>
        {{ $label ?? __('forms.label_date') }}
    </legend>

    <div class="field field--year">
        <x-hearth-label :for="$name . '_year'" :value="__('forms.label_year')" />
        <x-hearth-input :name="$name . '_year'" pattern="[0-9]*" inputmode="numeric" :required="$required" x-model="year" x-on:blur="componentsToDate()" />
        <x-hearth-error :for="$name . '_year'" />
    </div>

    <div class="field field--month">
        <x-hearth-label :for="$name . '_month'" :value="__('forms.label_month')" />
        <x-hearth-select :name="$name . '_month'" :required="$required" :options="$months" x-model="month" x-on:change="componentsToDate()" />
        <x-hearth-error :for="$name . '_month'" />
    </div>

    <div class="field field--day">
        <x-hearth-label :for="$name . '_day'" :value="__('forms.label_day')" />
        <x-hearth-input :name="$name . '_day'" pattern="[0-9]*" inputmode="numeric" :required="$required" x-model="day" x-on:blur="componentsToDate()" />
        <x-hearth-error :for="$name . '_day'" />
    </div>

    <input type="hidden" name="{{ $name }}" x-model="date" />

    @if($hint)
    <x-hearth-hint :for="$name">{{ $hint }}</x-heart-hint>
    @endif

    <div x-show="error">
        <x-hearth-error :for="$name">{{ __('validation.invalid_date') }}</x-hearth-error>
    </div>
</fieldset>
