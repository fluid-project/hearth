<?php

namespace Hearth\Traits;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

trait HandlesValidation
{
    /**
     * Determine whether a form input has any errors.
     *
     * @param  string  $name  The name of the form input.
     * @param  string  $bag  The error bag associated with the form input.
     */
    public function hasErrors(string $name, string $bag): bool
    {
        $errors = View::shared('errors', function () {
            return request()->session()->get('errors', new ViewErrorBag);
        });

        $name = str_replace(['[', ']'], ['.', ''], $name);

        foreach ($errors->getBag($bag)->keys() as $key) {
            if (Str::startsWith($key, $name)) {
                return true;
            }
        }

        return false;
    }
}
