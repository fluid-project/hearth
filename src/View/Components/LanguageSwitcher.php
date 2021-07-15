<?php

namespace Hearth\View\Components;

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
            'en',
            'fr',
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
        return View::make('hearth::components.language-switcher');
    }
}
