<?php

namespace Hearth\Components;

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class LocaleSelect extends Component
{
    /**
     * The list of locales.
     *
     * @var array
     */
    public $locales;

    /**
     * The selected locale.
     *
     * @var string
     */
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected = "")
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

        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.locale-select');
    }
}
