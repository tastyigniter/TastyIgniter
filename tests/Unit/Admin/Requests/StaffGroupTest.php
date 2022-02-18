<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\StaffGroup;
use Faker\Factory;
use Tests\TestCase;

class StaffGroupTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = StaffGroup::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
//            'request_should_fail_when_no_staff_group_name_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['staff_group_name']),
//            ],
//            'request_should_fail_when_no_auto_assign_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['auto_assign']),
//            ],
//            'request_should_fail_when_no_auto_assign_mode_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['auto_assign_mode']),
//            ],
//            'request_should_fail_when_no_auto_assign_limit_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['auto_assign_limit']),
//            ],
//            'request_should_fail_when_no_assignment_availability_is_provided' => [
//                'passed' => FALSE,
//                'data' => $this->exceptValidationData($faker, ['assignment_availability']),
//            ],
//
//            'request_should_fail_when_staff_group_name_has_more_than_128_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_group_name' => $faker->sentence(129),
//                ]),
//            ],
//
//            'request_should_fail_when_staff_group_name_has_less_than_2_characters' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'staff_group_name' => $faker->randomLetter,
//                ]),
//            ],
//
//            'request_should_fail_when_auto_assign_mode_is_not_an_integer' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'auto_assign_mode' => $faker->word(),
//                ]),
//            ],
//            'request_should_fail_when_auto_assign_limit_is_not_an_integer' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'auto_assign_limit' => $faker->word(),
//                ]),
//            ],
//
//            'request_should_fail_when_auto_assign_is_not_a_boolean' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'auto_assign' => $faker->word(),
//                ]),
//            ],
//            'request_should_fail_when_assignment_availability_is_not_a_boolean' => [
//                'passed' => FALSE,
//                'data' => $this->mergeValidationData($faker, [
//                    'assignment_availability' => $faker->word(),
//                ]),
//            ],
//
//            'request_should_pass_when_data_is_provided' => [
//                'passed' => TRUE,
//                'data' => $this->validationData($faker),
//            ],
        ];
    }

    protected function validationData($faker)
    {
        return [
            'staff_group_name' => $faker->word(),
            'description' => $faker->sentence(5),
            'auto_assign' => TRUE,
            'auto_assign_mode' => 2,
            'auto_assign_limit' => $faker->numberBetween(2, 50),
            'auto_assign_availability' => $faker->boolean(),
        ];
    }
}
