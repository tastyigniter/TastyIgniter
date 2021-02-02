<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Table;
use Faker\Factory;
use Tests\TestCase;

class TableTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Table::class;

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
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_min_capacity_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_max_capacity_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'min_capacity' => 1,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_extra_capacity_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_priority_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_joinable_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'table_status' => $faker->boolean()
                ],
            ],
            'request_should_fail_when_no_status_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('??'),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                ],
            ],

            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->lexify('?'),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_255_characters' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->sentence(256),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_min_capacity_is_less_than_1' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 0,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_min_capacity_is_greater_than_max_capacity' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 5,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_max_capacity_is_less_than_1' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 0,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_min_capacity_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => $faker->word(),
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_max_capacity_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => $faker->word(),
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_extra_capacity_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => $faker->word(),
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_priority_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => $faker->word(),
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_joinable_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->word(),
                    'table_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->word(),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'table_name' => $faker->word(),
                    'min_capacity' => 1,
                    'max_capacity' => 2,
                    'extra_capacity' => 1,
                    'priority' => 1,
                    'is_joinable' => $faker->boolean(),
                    'table_status' => $faker->boolean(),
                ],
            ],
        ];
    }
}
