<?php

namespace System\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Assets extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     * @see \System\Libraries\Template
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'assets';
    }
}
