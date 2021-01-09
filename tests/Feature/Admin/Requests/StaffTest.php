<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Staff;
use Faker\Factory;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Staff::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
//            'request_should_fail_when_no_staff_name_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['staff_name']),
//            ],
//            'request_should_fail_when_no_staff_email_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['staff_email']),
//            ],
//            'request_should_fail_when_no_username_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['user.username']),
//            ],
//            'request_should_fail_when_no_password_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['user.password']),
//            ],
//            'request_should_fail_when_no_staff_role_id_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['staff_role_id']),
//            ],
//            'request_should_fail_when_no_groups_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['groups']),
//            ],
//
//            'request_should_fail_when_staff_name_has_more_than_128_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_name' => $faker->sentence(129),
//                ]),
//            ],
//            'request_should_fail_when_staff_email_has_more_than_96_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_email' => $faker->sentence(97),
//                ]),
//            ],
//            'request_should_fail_when_username_has_more_than_255_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'username' => $faker->sentence(32),
//                ], 'user'),
//            ],
//            'request_should_fail_when_password_has_more_than_255_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'password' => $faker->password(6, 32),
//                ], 'user'),
//            ],
//
//            'request_should_fail_when_staff_name_has_less_than_2_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_name' => $faker->lexify('?'),
//                ]),
//            ],
//            'request_should_fail_when_username_has_less_than_2_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'username' => $faker->lexify('?'),
//                ], 'user'),
//            ],
//            'request_should_fail_when_password_has_less_than_6_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'password' => $faker->password(2, 5),
//                ], 'user'),
//            ],
//
//            'request_should_fail_when_language_id_is_not_an_integer' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'language_id' => $faker->word(),
//                ]),
//            ],
//            'request_should_fail_when_staff_role_id_is_not_an_integer' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_role_id' => $faker->word(),
//                ]),
//            ],
//
//            'request_should_fail_when_staff_status_is_not_a_boolean' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_status' => $faker->word(),
//                ]),
//            ],
//
//            'request_should_fail_when_groups_is_not_an_array_of_integers' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'groups' => [$faker->word],
//                ]),
//            ],
//            'request_should_fail_when_locations_is_not_an_array_of_integers' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'locations' => [$faker->word],
//                ]),
//            ],
//
//            'request_should_pass_when_data_is_provided' => [
//                'passed' => TRUE,
//                'data' => [
//                    'name' => $faker->word(),
//                    'description' => $faker->sentence(),
//                    'status' => $faker->boolean(),
//                ],
//            ],
        ];
    }

    protected function validationData($faker)
    {
        return [
            'staff_name' => $faker->name(),
            'staff_email' => $faker->email(),
            'user' => [
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'password_confirm' => $faker->password(),
            ],
            'staff_status' => $faker->boolean(),
            'language_id' => $faker->numberBetween(2, 50),
            'staff_role_id' => $faker->numberBetween(2, 50),
            'groups' => [$faker->numberBetween(2, 50)],
            'locations' => [$faker->numberBetween(2, 50)],
        ];
    }
}
