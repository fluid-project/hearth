<?php

namespace Hearth\Components;

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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
        $languages = new LanguageRepository();

        $locales = config('locales.supported', [
            'en',
            'fr',
        ]);

        $this->locales = [];

        foreach ($locales as $locale) {
            $this->locales[$locale] = Str::ucfirst($languages->get($locale, $locale)->getName());
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
