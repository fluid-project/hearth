<?php

namespace Hearth\Components;

use Hearth\Traits\AriaDescribable;
use Hearth\Traits\HandlesValidation;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class RadioButton extends Component
{
    use AriaDescribable;
    use HandlesValidation;

    /**
     * The name of the form input.
     *
     * @var null|string
     */
    public $name;

    /**
     * The value of the form input.
     *
     * @var null|string
     */
    public $value;

    /**
     * The id of the form input.
     *
     * @var null|string
     */
    public $id;

    /**
     * The error bag associated with the form input.
     *
     * @var null|string
     */
    public $bag;

    /**
     * Whether the checkbox is checked.
     */
    public bool $checked;

    /**
     * Whether the form input has validation errors.
     *
     * @var bool
     */
    public $invalid;

    /**
     * Whether the form input has a hint associated with it, or the id of the hint.
     *
     * @var bool|string
     */
    public $hinted;

    /**
     * Whether the form input is disabled.
     *
     * @var bool
     */
    public $disabled;

    /**
     * Whether the form input is should be autofocused.
     *
     * @var bool
     */
    public $autofocus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $value,
        $id = null,
        $bag = 'default',
        $checked = false,
        $hinted = false,
        $disabled = false,
        $autofocus = false
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->id = $id ?? $this->name.'-'.Str::slug($value);
        $this->bag = $bag;
        $this->checked = $checked;
        $this->hinted = $hinted;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.radio-button');
    }
}
