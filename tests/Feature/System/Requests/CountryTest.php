<?php

namespace Tests\Feature\System\Requests;

use Faker\Factory;
use System\Requests\Country;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Country::class;

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
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_priority_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_iso_code_2_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => 1,
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_iso_code_3_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_status_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                ],
            ],

            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->lexify('?'),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->sentence(129),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_priority_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_2_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => $faker->boolean(),
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_2_is_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => $faker->lexify('?'),
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_2_is_more_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => $faker->lexify('???'),
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_3_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' =>  $faker->boolean(),
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_3_is_less_than_3_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' =>  $faker->lexify('??'),
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_iso_code_3_is_more_than_3_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' =>  $faker->lexify('????'),
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_format_is_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => $faker->word(),
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => $faker->lexify('?'),
                    'status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->word(),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'country_name' => $faker->word(),
                    'priority' => 1,
                    'iso_code_2' => 'GB',
                    'iso_code_3' => 'GBR',
                    'format' => 'en',
                    'status' => $faker->boolean(),
                ],
            ],
        ];
    }
}
