<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Customer;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use ValidateRequest, RefreshDatabase;

    protected $requestClass = Customer::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
        ];
    }
}
