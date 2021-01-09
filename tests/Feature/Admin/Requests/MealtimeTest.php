<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Mealtime;
use Faker\Factory;
use Tests\TestCase;

class MealtimeTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Mealtime::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_mealtime_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['mealtime_name']),
            ],
            'request_should_fail_when_no_start_time_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['start_time']),
            ],
            'request_should_fail_when_no_end_time_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['end_time']),
            ],
            'request_should_fail_when_no_mealtime_status_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['mealtime_status']),
            ],

            'request_should_fail_when_mealtime_name_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'mealtime_name' => $faker->sentence(129),
                ]),
            ],

            'request_should_fail_when_mealtime_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'mealtime_status' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_locations_is_not_an_array_of_integers' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'locations' => [$faker->word()],
                ]),
            ],
            'request_should_fail_when_start_time_is_not_a_valid_time' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'start_time' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_end_time_is_not_a_valid_time' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'end_time' => $faker->word(),
                ]),
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => $this->validationData($faker),
            ],
        ];
    }

    protected function validationData($faker)
    {
        return [
            'mealtime_name' => $faker->word(),
            'start_time' => $faker->time('H:i'),
            'end_time' => $faker->time('H:i'),
            'mealtime_status' => $faker->boolean(),
            'locations' => [$faker->numberBetween(2, 50)],
        ];
    }
}
