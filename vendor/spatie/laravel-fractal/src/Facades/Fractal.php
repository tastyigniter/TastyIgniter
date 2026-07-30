<?php

namespace Spatie\Fractal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Fractal\Fractal
 */
class Fractal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fractal';
    }
}
