<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Status;
use Faker\Factory;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Status::class;

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
                    'status_for' => 'order',
                ],
            ],
            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => 'a',
                ],
            ],
            'request_should_fail_when_name_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(33),
                ],
            ],
            'request_should_fail_when_for_is_not_provided' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'notify_customer' => true,
                ],
            ],
            'request_should_fail_when_for_is_not_alphanumeric' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => $faker->randomElements(['!', '#', '$', '%', '~', '.', ':', ':'], 4),
                ],
            ],
            'request_should_fail_when_color_has_more_than_7_characters' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => 'order',
                    'status_color' => $faker->text(8),
                    'notify_customer' => true,
                ],
            ],
            'request_should_fail_when_comment_has_more_than_1028_characters' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => 'order',
                    'status_color' => $faker->text(7),
                    'status_comment' => $faker->text(1029),
                ],
            ],
            'request_should_fail_when_notify_is_not_provided' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => 'order',
                    'status_color' => $faker->text(7),
                ],
            ],
            'request_should_fail_when_notify_is_not_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => 'order',
                    'status_color' => $faker->text(7),
                    'notify_customer' => $faker->word(),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'status_name' => $faker->text(7),
                    'status_for' => 'order',
                    'status_color' => $faker->text(7),
                    'status_comment' => $faker->sentence(),
                    'notify_customer' => $faker->boolean(),
                ],
            ],
        ];
    }
}
