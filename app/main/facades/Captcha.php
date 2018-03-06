<?php namespace Main\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Captcha extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'captcha';
    }
}
