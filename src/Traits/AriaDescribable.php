<?php

namespace Hearth\Traits;

trait AriaDescribable
{
    /**
     * Generate the aria-describedby attribute for the form input.
     *
     * @return string
     */
    public function describedBy()
    {
        $descriptors = [];

        if ($this->hinted) {
            $descriptors[] = ($this->hinted === true) ? $this->name . '-hint' : $this->hinted;
        }

        if ($this->invalid) {
            $descriptors[] = $this->name . '-error';
        }

        return implode(' ', $descriptors);
    }
}
