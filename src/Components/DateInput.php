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
     * The hint for the form input.
     *
     * @var null|string
     */
    public $hint;

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
        $hint = null,
        $required = false,
        $disabled = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->id = $id ?? $this->name;
        $this->bag = $bag;
        $this->hinted = $hint !== null;
        $this->hint = $hint;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
        $this->required = $required;
        $this->disabled = $disabled;
        $this->months = [
            [
                'value' => '01',
                'label' => __('forms.month_january'),
            ],
            [
                'value' => '02',
                'label' => __('forms.month_february'),
            ],
            [
                'value' => '03',
                'label' => __('forms.month_march'),
            ],
            [
                'value' => '04',
                'label' => __('forms.month_april'),
            ],
            [
                'value' => '05',
                'label' => __('forms.month_may'),
            ],
            [
                'value' => '06',
                'label' => __('forms.month_june'),
            ],
            [
                'value' => '07',
                'label' => __('forms.month_july'),
            ],
            [
                'value' => '08',
                'label' => __('forms.month_august'),
            ],
            [
                'value' => '09',
                'label' => __('forms.month_september'),
            ],
            [
                'value' => '10',
                'label' => __('forms.month_october'),
            ],
            [
                'value' => '11',
                'label' => __('forms.month_november'),
            ],
            [
                'value' => '12',
                'label' => __('forms.month_december'),
            ],
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
