<?php

namespace Hearth\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;

class LanguageSwitcher extends Component
{
    /**
     * The list of locales.
     *
     * @var array
     */
    public $locales;

    /**
     * The route targeted by links in the language switcher.
     *
     * @var string
     */
    public $target;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $locales = config('locales.supported', [
            'en',
            'fr',
        ]);

        $this->locales = [];

        foreach ($locales as $locale) {
            $this->locales[$locale] = get_locale_name($locale, $locale);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.language-switcher');
    }
}
