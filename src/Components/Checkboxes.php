<?php

namespace Hearth\Components;

use Hearth\Traits\AriaDescribable;
use Hearth\Traits\HandlesValidation;
use Illuminate\View\Component;
use Illuminate\View\View;

class Checkboxes extends Component
{
    use AriaDescribable;
    use HandlesValidation;

    /**
     * The name of the checkboxes as used in form submission.
     */
    public string $name;

    /**
     * The error bag associated with the form input.
     *
     * @var null|string
     */
    public mixed $bag;

    /**
     * The checkbox options.
     *
     * @var array[]
     */
    public array $options;

    /**
     * The checked options.
     */
    public array $checked;

    /**
     * Whether the form input has validation errors.
     */
    public bool $invalid;

    /**
     * Whether the checkboxes have a hint associated with them, or the id of the hint.
     *
     * @var bool|string
     */
    public mixed $hinted;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $checked = [], $bag = 'default', $hinted = false)
    {
        $this->name = $name;
        $this->options = $options;
        $this->checked = $checked;
        $this->bag = $bag;
        $this->hinted = $hinted;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.checkboxes');
    }
}
