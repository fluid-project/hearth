<?php

use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (! function_exists('get_region_name')) {
    /**
     * Get the name of an administrative subdivision from its code.
     *
     * @param  string  $code An administrative subdivision code.
     * @param  array  $countries An array of ISO 3166-1 alpha-2 country codes.
     * @param  string  $locale An ISO 639-1 language code.
     * @return null|string The name of the administrative subdivision, if found.
     */
    function get_region_name(string $code, array $countries = ['CA'], string $locale = 'en'): ?string
    {
        $subdivisionRepository = new SubdivisionRepository();

        $subdivision = $subdivisionRepository->get($code, $countries);

        if ($subdivision) {
            return ($locale === $subdivision->getLocale()) ? $subdivision->getLocalName() : $subdivision->getName();
        }

        return null;
    }
}

if (! function_exists('get_regions')) {
    /**
     * Retrieve an array of administrative subdivisions within a country or countries.
     *
     * @param  array  $countries An array of ISO 3166-1 alpha-2 country codes.
     * @param  string  $locale An ISO 639-1 language code.
     * @return array An array of administrative subdivision names keyed by administrative subdivision codes.
     */
    function get_regions(array $countries = ['CA'], string $locale = 'en'): array
    {
        $subdivisionRepository = new SubdivisionRepository();

        $regions = ['' => ''];

        foreach ($subdivisionRepository->getAll($countries) as $region) {
            $regions[$region->getCode()] = ($locale === $region->getLocale()) ? $region->getLocalName() : $region->getName();
        }

        return $regions;
    }
}

if (! function_exists('get_region_codes')) {
    /**
     * Retrieve an array of administrative subdivision codes within a country or countries.
     *
     * @param  array  $countries An array of ISO 3166-1 alpha-2 country codes.
     * @return array An array of administrative subdivision codes.
     */
    function get_region_codes(array $countries = ['CA']): array
    {
        $subdivisionRepository = new SubdivisionRepository();

        $regions = [];

        foreach ($subdivisionRepository->getAll($countries) as $region) {
            $regions[] = $region->getCode();
        }

        return $regions;
    }
}

if (! function_exists('get_locale_name')) {
    /**
     * Get the name of a locale from its code.
     *
     * @param  string  $code An ISO 639-1 language code.
     * @param  string  $locale An ISO 639-1 language code (in which the locale name should be returned).
     * @return null|string The localized name of the locale, if found.
     */
    function get_locale_name(string $code, string $locale = 'en', $capitalize = true): ?string
    {
        $languages = new LanguageRepository();

        try {
            $language = $languages->get($code, $locale);

            return $capitalize ? Str::ucfirst($language->getName()) : $language->getName();
        } catch (CommerceGuys\Intl\Exception\UnknownLanguageException $e) {
            return null;
        }
    }
}

if (! function_exists('trans_current_route')) {
    /**
     * Retrieve the current route in another locale.
     *
     * @param  string|null  $locale
     * @param  string|null  $fallback
     * @param  bool  $absolute
     * @return string
     */
    function trans_current_route(string $locale = null, string $fallback = null, bool $absolute = true): string
    {
        if (is_null($fallback)) {
            $fallback = url(request()->server('REQUEST_URI'));
        }

        $route = Route::getCurrentRoute();

        if (! $route) {
            return $fallback;
        }

        $name = Str::replaceFirst(
            locale().'.',
            "{$locale}.",
            $route->getName()
        );

        if (! $name || ! in_array($locale, locales()) || ! Route::has($name)) {
            return $fallback;
        }

        $current = locale();

        locale($locale);

        $url = route($name, array_merge(
            (array) $route->parameters,
            (array) request()->getQueryString()
        ), $absolute);

        locale($current);

        return $url;
    }
}
