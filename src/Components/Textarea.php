<?php

namespace Hearth\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * The name of the form input.
     *
     * @var null|string
     */
    public $name;

    /**
     * The id of the form input.
     *
     * @var null|string
     */
    public $id;

    /**
     * The value of the form input.
     *
     * @var null|string
     */
    public $value;

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
     * Whether the form input is should be autofocused.
     *
     * @var bool
     */
    public $autofocus;

    /**
     * Create a new component instance.
     *
     * @param string $name The name of the form input.
     * @param string $bag The error bag associated with the form input.
     * @param bool $hinted Whether the form input has a hint associated with it.
     * @param bool $required Whether the form input is required.
     * @param bool $disabled Whether the form input is disabled.
     * @param bool $autofocus Whether the form input is should be autofocused.
     *
     * @return void
     */
    public function __construct(
        $name,
        $id = null,
        $value = null,
        $bag = 'default',
        $hinted = false,
        $required = false,
        $disabled = false,
        $autofocus = false
    ) {
        $this->name = $name;
        $this->id = $id ?? $this->name;
        $this->value = $value;
        $this->bag = $bag;
        $this->hinted = $hinted;
        $this->invalid = $this->hasErrors($this->name, $this->bag);
        $this->required = $required;
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
    }

    /**
     * Determine whether the form input has any errors.
     *
     * @param string $name The name of the form input.
     * @param string $bag The error bag associated with the form input.
     *
     * @return bool
     */
    public function hasErrors($name, $bag)
    {
        $errors = View::shared('errors', function () {
            return request()->session()->get('errors', new ViewErrorBag);
        });

        return $errors->getBag($bag)->has($name);
    }

    /**
     * Generate the aria-describedby attribute for the form input.
     *
     * @return string
     */
    public function describedBy()
    {
        $descriptors = [];

        if ($this->hinted) {
            $descriptors[] = $this->name . '-hint';
        }

        if ($this->invalid) {
            $descriptors[] = $this->name . '-error';
        }

        return implode(' ', $descriptors);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('hearth::components.textarea');
    }
}
