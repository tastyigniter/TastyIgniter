<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\StaffRole;
use Faker\Factory;
use Tests\TestCase;

class StaffRoleTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = StaffRole::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_code_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['code']),
            ],
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['name']),
            ],
            'request_should_fail_when_no_permissions_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['permissions']),
            ],

            'request_should_fail_when_code_has_non_alpha_dash_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'code' => $faker->sentence(),
                ]),
            ],

            'request_should_fail_when_code_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'code' => $faker->sentence(33),
                ]),
            ],
            'request_should_fail_when_name_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'name' => $faker->sentence(129),
                ]),
            ],

            'request_should_fail_when_code_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'code' => $faker->randomLetter,
                ]),
            ],
            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'name' => $faker->randomLetter,
                ]),
            ],

            'request_should_fail_when_permissions_is_not_an_array_of_integers' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'permissions' => [$faker->word],
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
            'code' => $faker->word(),
            'name' => $faker->word(),
            'permissions' => [$faker->numberBetween(2, 50)],
        ];
    }
}
