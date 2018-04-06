<?php namespace Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
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
