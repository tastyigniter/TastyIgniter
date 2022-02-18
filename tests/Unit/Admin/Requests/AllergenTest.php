<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\Allergen;
use Faker\Factory;
use Tests\TestCase;

class AllergenTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = Allergen::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'description' => $faker->sentence(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->sentence(129),
                ],
            ],
            'request_should_fail_when_description_has_more_than_500_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(501),
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_status_is_not_valid' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(),
                    'status' => $faker->word(),
                ],
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(),
                    'status' => $faker->boolean(),
                ],
            ],
        ];
    }
}
