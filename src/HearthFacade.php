<?php

namespace FluidProject\Hearth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FluidProject\Hearth\Hearth
 */
class HearthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hearth';
    }
}
