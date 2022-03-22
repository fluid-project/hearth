<?php

namespace Hearth\Components;

use Hearth\Traits\AriaDescribable;
use Hearth\Traits\HandlesValidation;
use Illuminate\View\Component;
use Illuminate\View\View;

class RadioButtons extends Component
{
    use AriaDescribable;
    use HandlesValidation;

    /**
     * The name of the radio buttons as used in form submission.
     *
     * @var string
     */
    public $name;

    /**
     * The error bag associated with the form input.
     *
     * @var null|string
     */
    public $bag;

    /**
     * The radio button options.
     *
     * @var (string|array)[]
     */
    public $options;

    /**
     * The selected option.
     *
     * @var null|string
     */
    public $selected;

    /**
     * Whether the form input has validation errors.
     *
     * @var bool
     */
    public $invalid;

    /**
     * Whether the radio buttons have a hint associated with them, or the id of the hint.
     *
     * @var bool|string
     */
    public $hinted;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $selected = null, $bag = 'default', $hinted = false)
    {
        $options = array_map(function ($option) {
            if (!is_array($option)) {
                return ['label' => $option];
            }
            return $option;
        }, $options);

        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->bag = $bag;
        $this->hinted = $hinted;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.radio-buttons');
    }
}
