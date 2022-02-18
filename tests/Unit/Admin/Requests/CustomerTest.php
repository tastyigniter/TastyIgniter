<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\Customer;
use Faker\Factory;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

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
