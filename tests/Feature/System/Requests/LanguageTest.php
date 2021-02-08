<?php

namespace Tests\Feature\System\Requests;

use Faker\Factory;
use System\Requests\Language;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Language::class;

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
                    'code' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_code_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'name' => 'English',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_status_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'name' => 'English',
                    'code' => 'en',
                ],
            ],
            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->lexify('?'),
                    'code' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->sentence(33),
                    'code' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_code_contains_non_alpha_or_dashes' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'code' => $faker->randomDigit(),
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_status_is_not_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'code' => 'en',
                    'status' => $faker->word(),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'name' => $faker->word(),
                    'code' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
        ];
    }
}
