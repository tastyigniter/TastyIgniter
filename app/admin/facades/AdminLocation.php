<?php

namespace Admin\Facades;

use Illuminate\Support\Facades\Facade;

class AdminLocation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @see \Admin\Classes\User
     */
    protected static function getFacadeAccessor()
    {
        return 'admin.location';
    }
}
