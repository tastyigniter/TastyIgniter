<?php

namespace Tests\Feature\System\Requests;

use Faker\Factory;
use System\Requests\MailLayout;
use Tests\TestCase;

class MailLayoutTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = MailLayout::class;

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
                'data' => [],
            ],
            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->lexify('?'),
                ],
            ],
            'request_should_fail_when_name_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->sentence(33),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'name' => $faker->word(),
                ],
            ],
        ];
    }
}
