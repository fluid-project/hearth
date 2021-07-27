<div {{ $attributes->merge(['class' => 'flow']) }} x-data="confirmPassword('{{ route('password.confirmation') }}', '{{ localized_route('password.confirm') }}')">
    {{ $slot }}
    <div class="modal-wrapper" x-show="showingModal">
        <div class="modal flow" @keydown.escape.window="hideModal()" @click.away="hideModal()">
            <p>{{ $message }}</p>

            <div class="field">
                <x-hearth-label for="password" :value="__('hearth::auth.label_password')" />
                <x-hearth-input id="password" type="password" name="password" required x-ref="password" />
                <template x-cloak x-if="validationError">
                    <x-validation-error>{{ __('validation.current_password') }}</x-validation-error>
                </template>
            </div>

            <button type="button" @click="cancel">{{ $cancel }}</button>
            <button type="button" @click="confirmPassword">{{ $confirm }}</button>
        </div>
    </div>
</div>
