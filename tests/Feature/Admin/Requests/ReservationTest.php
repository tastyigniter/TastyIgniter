<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Reservation;
use Faker\Factory;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Reservation::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_location_id_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_id']),
            ],
            'request_should_fail_when_no_first_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['first_name']),
            ],
            'request_should_fail_when_no_last_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['last_name']),
            ],
            'request_should_fail_when_no_reserve_date_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['reserve_date']),
            ],
            'request_should_fail_when_no_reserve_time_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['reserve_time']),
            ],
            'request_should_fail_when_no_guest_num_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['guest_num']),
            ],

            'request_should_fail_when_location_id_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_id' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_guest_num_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'guest_num' => $faker->word(),
                ]),
            ],

            'request_should_fail_when_first_name_has_more_than_48_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'first_name' => $faker->sentence(49),
                ]),
            ],
            'request_should_fail_when_last_name_has_more_than_48_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'last_name' => $faker->sentence(49),
                ]),
            ],
            'request_should_fail_when_email_has_more_than_96_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'email' => $faker->sentence(97),
                ]),
            ],

            'request_should_fail_when_email_is_not_a_valid_email' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'email' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_reserve_date_is_not_a_valid_date' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'reserve_date' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_reserve_date_is_not_a_valid_time' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'reserve_time' => $faker->word(),
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
            'location_id' => $faker->numberBetween(1, 50),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->name,
            'email' => $faker->email,
            'telephone' => $faker->phoneNumber,
            'reserve_date' => $faker->date(),
            'reserve_time' => $faker->time(),
            'guest_num' => $faker->numberBetween(3, 20),
        ];
    }
}
