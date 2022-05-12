<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotLastAdmin implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $value->membershipable()->administrators()->count() > 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.custom.membership.not_last_admin');
    }
}
