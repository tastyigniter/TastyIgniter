<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Traits;

use Igniter\Api\Traits\CreatesResponse;
use LogicException;
use Spatie\Fractal\Fractal;

it('throws LogicException when response method is called', function(): void {
    $traitObject = new class
    {
        use CreatesResponse;
    };

    expect(function() use ($traitObject): void {
        $traitObject->response();
    })->toThrow(LogicException::class, 'Deprecated, use Fractal::create() or response()->json() instead');
});

it('returns a Fractal instance from fractal method', function(): void {
    $traitObject = new class
    {
        use CreatesResponse;
    };

    $result = $traitObject->fractal();

    expect($result)->toBeInstanceOf(Fractal::class);
});
