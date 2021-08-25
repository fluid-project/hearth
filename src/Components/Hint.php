<?php

namespace Hearth\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Hint extends Component
{
    /**
     * The name of the associated form input.
     *
     * @var string
     */
    public $for;

    /**
     * Create a new component instance.
     *
     * @param string $for The name of the associated form input.
     *
     * @return void
     */
    public function __construct($for)
    {
        $this->for = $for;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.hint');
    }
}
