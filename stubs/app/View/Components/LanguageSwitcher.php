<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

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
        $languages = new LanguageRepository();

        $locales = config('locales.supported', [
            'en-ca',
            'fr-ca',
        ]);

        $this->locales = [];

        foreach ($locales as $locale) {
            $this->locales[$locale] = $languages->get($locale, $locale)->getName();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.language-switcher');
    }

    public function getLocalizedRoute($locale)
    {
        return Route::currentRouteName()
            ? current_route($locale)
            : localized_route('welcome', [], $locale);
    }
}
