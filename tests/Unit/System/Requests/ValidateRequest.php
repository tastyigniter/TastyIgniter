<?php

namespace Tests\Unit\System\Requests;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Flame\Exception\ValidationException;

trait ValidateRequest
{
    protected $factory;

    public function assertFormRequestAsExpected($requestClass, $callback)
    {
        [$shouldPass, $mockedRequestData] = $callback;

        if (is_null($requestClass))
            $requestClass = $this->requestClass;

        $this->app->resolving($requestClass, function ($resolved) use ($mockedRequestData) {
            if ($mockedRequestData instanceof Factory) {
                $resolved->setModel($mockedRequestData->newModel());
                $mockedRequestData = $mockedRequestData->raw();
            }

            $resolved->merge($mockedRequestData);
        });

        try {
            app($requestClass);
            $actualResult = TRUE;
        }
        catch (ValidationException $ex) {
            $actualResult = $shouldPass ? $ex->getErrors()->toJson() : FALSE;
        }

        expect($shouldPass)->toBe($actualResult);
    }
}
