<?php

namespace Hearth\Traits;

trait AriaDescribable
{
    /**
     * Generate the aria-describedby attribute for the form input.
     *
     * @param  string  $hint
     * @return string
     */
    public function describedBy(string $hint = ''): string
    {
        $descriptors = [$hint];

        if ($this->hinted) {
            $descriptors[] = is_string($this->hinted) ? $this->hinted : $this->name.'-hint';
        }

        if ($this->invalid) {
            $descriptors[] = str_replace(['[', ']'], ['_', ''], $this->name).'-error';
        }

        return implode(' ', array_filter($descriptors));
    }
}
