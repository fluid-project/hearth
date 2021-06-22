<?php

namespace Hearth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hearth\Hearth
 */
class HearthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hearth';
    }
}
