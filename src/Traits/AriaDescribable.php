<?php

namespace Hearth\Traits;

trait AriaDescribable
{
    /**
     * Generate the aria-describedby attribute for the form input.
     *
     * @param string $hint
     * @return string
     */
    public function describedBy($hint = '')
    {
        $descriptors = [$hint];

        if ($this->hinted) {
            $descriptors[] = ($this->hinted === true) ? $this->name . '-hint' : $this->hinted;
        }

        if ($this->invalid) {
            $descriptors[] = str_replace(['[', ']'], ['_', ''], $this->name) . '-error';
        }

        return implode(' ', array_filter($descriptors));
    }
}
