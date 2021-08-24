<?php

namespace Hearth\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * The name of the form input.
     *
     * @var string
     */
    public $name;

    /**
     * The error bag associated with the form input.
     *
     * @var string
     */
    public $bag;

    /**
     * Whether the form input has a hint associated with it.
     *
     * @var bool
     */
    public $hinted;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $bag = 'default', $hinted = false)
    {
        $this->name = $name;
        $this->bag = $bag;
        $this->hinted = $hinted;
        $this->invalid = $this->hasError($this->name, $this->bag);
    }

    /**
     * Determine whether the form input has any errors.
     *
     * @param string $name The name of the form input.
     * @param string $bag The error bag associated with the form input.
     *
     * @return bool
     */
    public function hasError($name, $bag)
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
        $describedBy = [];

        if ($this->hinted) {
            $describedBy[] = $this->name . '-hint';
        }

        if ($this->invalid) {
            $describedBy[] = $this->name . '-error';
        }

        return implode(' ', $describedBy);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.input');
    }
}
