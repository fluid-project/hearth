<?php

use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;

if (! function_exists('get_regions')) {
    /**
     * Retrieve an array of administrative subdivisions within a country or countries.
     *
     * @param array $countries An array of ISO 3166-1 alpha-2 country codes.
     * @param string $locale An ISO 639-1 language code.
     *
     * @return array
     */
    function get_regions($countries = ['CA'], $locale = 'en')
    {
        $subdivisionRepository = new SubdivisionRepository();

        $regions = [];

        foreach ($subdivisionRepository->getAll($countries) as $region) {
            $regions[$region->getCode()] = ($locale === $region->getLocale()) ? $region->getLocalName() : $region->getName();
        }

        return $regions;
    }
}
