<?php namespace Main\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Auth extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @see \Admin\Helpers\Admin
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'customer.auth';
    }
}
