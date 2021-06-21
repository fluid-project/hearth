<?php

namespace InclusiveDesign\Hearth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \InclusiveDesign\Hearth\Hearth
 */
class HearthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hearth';
    }
}
