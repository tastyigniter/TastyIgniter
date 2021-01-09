<?php

namespace Tests\Feature\Admin\Requests;

use Igniter\Flame\Exception\ValidationException;

trait ValidateRequest
{
    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    protected function validate($mockedRequestData)
    {
        $this->app->resolving($this->requestClass, function ($resolved) use ($mockedRequestData) {
            $resolved->merge($mockedRequestData);
        });

        try {
            app($this->requestClass);

            return TRUE;
        }
        catch (ValidationException $ex) {
//            dump($ex->getErrors());

            return FALSE;
        }
    }

    protected function validationData($faker)
    {
        return [
        ];
    }

    protected function exceptValidationData($faker, $except)
    {
        return array_except($this->validationData($faker), $except);
    }

    protected function mergeValidationData($faker, $merge, $key = null)
    {
        $data = $this->validationData($faker);
        if (!is_null($key)) {
            $data[$key] = array_merge($data[$key], $merge);
        }
        else {
            $data = array_merge($data, $merge);
        }

        return $data;
    }
}
