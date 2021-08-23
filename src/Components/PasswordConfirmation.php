<?php

namespace Hearth\Components;

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
    public function __construct($message = null, $cancel = null, $confirm = null)
    {
        $this->message = $message ?? __('hearth::auth.confirm_intro');

        $this->cancel = $cancel ?? __('hearth::auth.action_cancel');

        $this->confirm = $confirm ?? __('hearth::auth.action_confirm');
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
