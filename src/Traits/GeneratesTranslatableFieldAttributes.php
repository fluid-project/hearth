<?php

namespace Hearth\Traits;

trait GeneratesTranslatableFieldAttributes
{
    /**
     * Generate id for input field and its label
     *
     * @param string $name
     * @param string $locale
     *
     * @return string
     */
    public function generateFieldId($name, $locale)
    {
        return $name . '_' . $locale;
    }

    /**
     * Generate error id for input field
     *
     * @param string $name
     * @param string $locale
     *
     * @return string
     */
    public function generateErrorId($name, $locale)
    {
        return $name . '.' . $locale;
    }

    /**
     * Generate label value for translatable components
     *
     * @param string $label
     * @param string $locale
     *
     * @return string
     */
    public function generateLabelString($label, $locale)
    {
        return __(':label (:locale)', ['label' => $label, 'locale' => get_locale_name($locale)]);
    }
}
