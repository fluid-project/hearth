<?php

namespace Hearth\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Hint extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('hearth::components.hint');
    }
}
