<?php

namespace Hearth\Traits;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

trait HandlesValidation
{
    /**
     * Determine whether a form input has any errors.
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
}
