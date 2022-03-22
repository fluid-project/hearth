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
     *
     * @var string
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
     * @var (string|array)[]
     */
    public array $options;

    /**
     * The selected options.
     *
     * @var array
     */
    public array $selected;

    /**
     * Whether the form input has validation errors.
     *
     * @var bool
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
    public function __construct($name, $options, $selected = [], $bag = 'default', $hinted = false)
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
        return view('hearth::components.checkboxes');
    }
}
