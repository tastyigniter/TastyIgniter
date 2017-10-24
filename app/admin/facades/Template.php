<?php

namespace Admin\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Template extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @see \System\Libraries\Template
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin.template';
    }
}
