<?php

declare(strict_types=1);

namespace Igniter\Api\Traits;

use LogicException;
use Spatie\Fractal\Fractal;

trait CreatesResponse
{
    public function response(): never
    {
        throw new LogicException('Deprecated, use Fractal::create() or response()->json() instead');
    }

    public function fractal()
    {
        return Fractal::create();
    }
}
