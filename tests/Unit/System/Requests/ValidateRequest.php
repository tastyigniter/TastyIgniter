<?php

namespace Tests\Unit\System\Requests;

use Igniter\Flame\Database\Factories\Factory;
use Igniter\Flame\Exception\ValidationException;

trait ValidateRequest
{
    protected $factory;

    /**
     * @dataProvider validationProvider
     * @param \Closure $callback
     */
    public function test_validation_results_as_expected($callback)
    {
        [$shouldPass, $mockedRequestData] = $callback();

        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    public function assertFormRequest($requestClass, $callback)
    {
        [$shouldPass, $mockedRequestData] = $callback;

        expect($this->validate($mockedRequestData, $requestClass))
            ->toBe($shouldPass);
    }

    public function validationProvider()
    {
        return [];
    }

    protected function factory(...$parameters)
    {
        return $this->modelClass::factory(...$parameters);
    }

    protected function validate($mockedRequestData, $requestClass = null)
    {
        if (is_null($requestClass))
            $requestClass = $this->requestClass;

        $this->app->resolving($requestClass, function ($resolved) use ($mockedRequestData) {
            if ($mockedRequestData instanceof Factory)
                $mockedRequestData = $mockedRequestData->raw();

            $resolved->merge($mockedRequestData);
        });

        try {
            app($requestClass);

            return TRUE;
        }
        catch (ValidationException $ex) {
            return FALSE;
        }
    }
}
