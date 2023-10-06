<?php

namespace Hearth\Components;

use Hearth\Traits\GeneratesTranslatableFieldAttributes;
use Illuminate\View\Component;
use Illuminate\View\View;

class TranslatableTextarea extends Component
{
    use GeneratesTranslatableFieldAttributes;

    /**
     * The name for the input.
     */
    public string $name;

    /**
     * The label for the input.
     */
    public string $label;

    /**
     * The locales supported by the input.
     */
    public array $locales;

    /**
     * The model to which the input field belongs.
     */
    public mixed $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $locales = null, $model = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->locales = $locales ?? config('locales.supported');
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.translatable-textarea');
    }
}
