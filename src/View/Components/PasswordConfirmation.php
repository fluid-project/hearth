<?php

namespace Hearth\View\Components;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class PasswordConfirmation extends Component
{
    /**
     * The password confirmation modal's message.
     *
     * @var string
     */
    public $message;

    /**
     * The password confirmation modal's cancel button text.
     *
     * @var string
     */
    public $cancel;

    /**
     * The password confirmation modal's confirm button text.
     *
     * @var string
     */
    public $confirm;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message, $cancel, $confirm)
    {
        $this->message = $message;

        $this->cancel = $cancel;

        $this->confirm = $confirm;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return View::make('hearth::components.password-confirmation');
    }
}
