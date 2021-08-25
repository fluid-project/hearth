<?php

namespace Hearth\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class RadioButtons extends Component
{
    /**
     * The name of the radio buttons as used in form submission.
     *
     * @var string
     */
    public $name;

    /**
     * The radio button options.
     *
     * @var array
     */
    public $options;

    /**
     * The selected option.
     *
     * @var null|string
     */
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $selected = null)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.radio-buttons');
    }
}
