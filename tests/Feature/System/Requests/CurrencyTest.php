<?php

namespace Tests\Feature\System\Requests;

use Faker\Factory;
use System\Requests\Currency;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Currency::class;

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
                    'currency_code' => 'GBP',
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_code_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => 'Pound Sterling',
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_country_id_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => 'Pound Sterling',
                    'currency_code' => 'GBP',
                    'currency_symbol' => '&pound;',
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_no_status_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => 'Pound Sterling',
                    'currency_code' => 'GBP',
                    'currency_symbol' => '&pound;',
                    'symbol_position' => '0',
                    'country_id' => 1,
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                ],
            ],

            'request_should_fail_when_name_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->lexify('?'),
                    'currency_code' => 'GBP',
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_32_characters' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->sentence(32),
                    'currency_code' => 'GBP',
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_code_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->boolean(),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_code_is_less_than_3_characters' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('??'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_code_is_more_than_3_characters' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('????'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_symbol_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('????'),
                    'currency_symbol' => $faker->boolean(),
                    'country_id' => 1,
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_country_id_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => $faker->boolean(),
                    'symbol_position' => '0',
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_symbol_position_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->randomDigit(),
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_symbol_position_is_more_than_1_character' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('??'),
                    'currency_rate' => 1,
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_rate_is_not_numeric' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => $faker->lexify('?'),
                    'thousand_sign' => ',',
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_thousand_sign_is_not_a_string' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->randomDigit(),
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_thousand_sign_is_more_than_1_character' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->lexify('??'),
                    'decimal_sign' => '.',
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_decimal_sign_is_more_than_1_character' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->lexify('?'),
                    'decimal_sign' => $faker->lexify('??'),
                    'decimal_position' => '2',
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_decimal_position_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->lexify('?'),
                    'decimal_sign' => '.',
                    'decimal_position' => $faker->lexify('?'),
                    'currency_status' => $faker->boolean(),
                ],
            ],
            'request_should_fail_when_currency_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->lexify('?'),
                    'decimal_sign' => '.',
                    'decimal_position' => $faker->randomDigit(),
                    'currency_status' => $faker->word(),
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'currency_name' => $faker->word(),
                    'currency_code' => $faker->lexify('???'),
                    'currency_symbol' => '&pound;',
                    'country_id' => 1,
                    'symbol_position' => $faker->lexify('?'),
                    'currency_rate' => 1,
                    'thousand_sign' => $faker->lexify('?'),
                    'decimal_sign' => '.',
                    'decimal_position' => $faker->randomDigit(),
                    'currency_status' => $faker->boolean(),
                ],
            ],
        ];
    }
}
