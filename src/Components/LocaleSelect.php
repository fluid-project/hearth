<?php

namespace Hearth\Components;

use Illuminate\View\Component;

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
        $this->locales = [
            'en' => 'English',
            'fr' => 'Français',
        ];

        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\Factory|Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.locale-select');
    }
}
