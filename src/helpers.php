<?php

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Support\Str;

if (! function_exists('get_locale_name')) {
    /**
     * Get the name of a locale from its code.
     *
     * @param  string  $code  An ISO 639-1 language code.
     * @param  string  $locale  An ISO 639-1 language code (in which the locale name should be returned).
     * @return null|string The localized name of the locale, if found.
     */
    function get_locale_name(string $code, string $locale = 'en', $capitalize = true): ?string
    {
        $languages = new LanguageRepository;

        try {
            $language = $languages->get($code, $locale);

            return $capitalize ? Str::ucfirst($language->getName()) : $language->getName();
        } catch (CommerceGuys\Intl\Exception\UnknownLanguageException $e) {
            return null;
        }
    }
}
