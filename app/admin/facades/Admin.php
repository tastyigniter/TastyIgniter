<?php namespace Admin\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Admin extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @see \Admin\Helpers\Admin
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin.helper';
    }
}
