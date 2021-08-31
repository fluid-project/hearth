<?php

namespace Hearth\Components;

use Hearth\Traits\AriaDescribable;
use Hearth\Traits\HandlesValidation;
use Illuminate\View\Component;

class DateInput extends Component
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
     * The label of the form input.
     *
     * @var string
     */
    public $label;

    /**
     * The value of the form input.
     *
     * @var string
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
     * Whether the form input has validation errors.
     *
     * @var bool
     */
    public $invalid;

    /**
     * Whether the form input has a hint associated with it.
     *
     * @var bool
     */
    public $hinted;

    /**
     * The hint string for the form input.
     *
     * @var null|string
     */
    public $hintString;

    /**
     * Whether the form input is disabled.
     *
     * @var bool
     */
    public $disabled;

    /**
     * Whether the form input is required.
     *
     * @var bool
     */
    public $required;

    /**
     * An array of months, localized.
     *
     * @var array
     */
    public $months;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $label,
        $value = '',
        $id = null,
        $bag = 'default',
        $hinted = false,
        $hintString = null,
        $required = false,
        $disabled = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->id = $id ?? $this->name;
        $this->bag = $bag;
        $this->hinted = $hintString !== null;
        $this->hintString = $hintString;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
        $this->required = $required;
        $this->disabled = $disabled;
        $this->months = [
            '01' => __('forms.month_january'),
            '02' => __('forms.month_february'),
            '03' => __('forms.month_march'),
            '04' => __('forms.month_april'),
            '05' => __('forms.month_may'),
            '06' => __('forms.month_june'),
            '07' => __('forms.month_july'),
            '08' => __('forms.month_august'),
            '09' => __('forms.month_september'),
            '10' => __('forms.month_october'),
            '11' => __('forms.month_november'),
            '12' => __('forms.month_december'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('hearth::components.date-input', ['months' => $this->months]);
    }
}
