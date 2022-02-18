<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\CustomerGroup;
use Faker\Factory;
use Tests\TestCase;

class CustomerGroupTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = CustomerGroup::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_group_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['group_name']),
            ],
            'request_should_fail_when_no_approval_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['approval']),
            ],

            'request_should_fail_when_group_name_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'group_name' => $faker->sentence(33),
                ]),
            ],
            'request_should_fail_when_description_has_more_than_500_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'description' => $faker->sentence(501),
                ]),
            ],

            'request_should_fail_when_approval_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'approval' => $faker->word(),
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
            'group_name' => $faker->word(),
            'approval' => $faker->boolean(),
            'description' => $faker->sentence(6),
        ];
    }
}
