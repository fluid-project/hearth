<div class="field @error($generateErrorId($name, locale())) field--error @enderror">
    <x-hearth-label :for="$generateFieldId($name, locale())" :value="$generateLabelString($label, locale())" />
    <x-hearth-textarea :id="$generateFieldId($name, locale())" :name="$name . '[' . locale() . ']'" :value="old($generateErrorId($name, locale()), $model ? $model->getTranslation($name, locale()) : '')" />
    <x-hearth-error :for="$generateErrorId($name, locale())" />
</div>
@foreach($locales as $locale)
    @if($locale !== locale())
    <div class="expander field @error($generateErrorId($name, $locale)) field--error @enderror" x-data="{expanded: false, value: '{{ old($generateErrorId($name, $locale), $model ? $model->getTranslation($name, $locale) : '') }}', badgeText: '{{ __('Content added') }}'}">
        <p class="expander__summary" id="{{ Str::slug($generateLabelString($label, $locale)) }}">
            <button type="button" x-bind:aria-expanded="expanded.toString()" x-on:click="expanded = !expanded" aria-describedby="{{ Str::slug($generateLabelString($label, $locale)) }}-status">
                {{ $generateLabelString($label, $locale) }} <span aria-hidden="true" x-text="expanded ? '-' : '+'"></span>
            </button>
        </p>
        <span class="badge" id="{{ Str::slug($generateLabelString($label, $locale)) }}-status" x-show="value && ! expanded" x-text="value ? badgeText : ''"></span>
        <div class="expander__content" x-show="expanded">
            <x-hearth-textarea :id="$generateFieldId($name, $locale)" :name="$name . '[' . $locale . ']'" :value="old($generateErrorId($name, $locale), $model ? $model->getTranslation($name, $locale) : '')" x-model="value" x-on:keyup="badgeText = '{{ __('Content added, unsaved changes') }}'" :aria-labelledby="Str::slug($generateLabelString($label, $locale))" />
            <x-hearth-error :for="$generateErrorId($name, $locale)" />
        </div>
    </div>
    @endif
@endforeach
