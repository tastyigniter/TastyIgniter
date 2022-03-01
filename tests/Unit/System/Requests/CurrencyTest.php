<?php

namespace Tests\Unit\System\Requests;

use System\Models\Currency;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\System\Requests\Currency::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, Currency::factory(['currency_name' => null])];
        },
    ],
    'request_should_fail_when_no_code_is_provided' => [
        function () {
            return [FALSE, Currency::factory(['currency_code' => null])];
        },
    ],
    'request_should_fail_when_no_country_id_is_provided' => [
        function () {
            return [FALSE, Currency::factory(['country_id' => null])];
        },
    ],
    'request_should_fail_when_no_status_is_provided' => [
        function () {
            return [FALSE, Currency::factory(['currency_status' => null])];
        },
    ],

    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, Currency::factory(['currency_name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_name_has_more_than_32_characters' => [
        function () {
            return [FALSE, Currency::factory(['currency_name' => faker()->sentence(33)])];
        },
    ],
    'request_should_fail_when_currency_code_is_not_a_string' => [
        function () {
            return [FALSE, Currency::factory(['currency_code' => faker()->boolean()])];
        },
    ],
    'request_should_fail_when_currency_code_is_less_than_3_characters' => [
        function () {
            return [FALSE, Currency::factory(['currency_code' => faker()->lexify('??')])];
        },
    ],
    'request_should_fail_when_currency_code_is_more_than_3_characters' => [
        function () {
            return [FALSE, Currency::factory(['currency_code' => faker()->lexify('?????')])];
        },
    ],
    'request_should_fail_when_currency_symbol_is_not_a_string' => [
        function () {
            return [FALSE, Currency::factory(['currency_symbol' => faker()->boolean()])];
        },
    ],
    'request_should_fail_when_country_id_is_not_an_integer' => [
        function () {
            return [FALSE, Currency::factory(['country_id' => faker()->word()])];
        },
    ],
    'request_should_fail_when_symbol_position_is_not_a_string' => [
        function () {
            return [FALSE, Currency::factory(['symbol_position' => faker()->randomDigit()])];
        },
    ],
    'request_should_fail_when_symbol_position_is_more_than_1_character' => [
        function () {
            return [FALSE, Currency::factory(['symbol_position' => faker()->lexify('??')])];
        },
    ],
    'request_should_fail_when_currency_rate_is_not_numeric' => [
        function () {
            return [FALSE, Currency::factory(['currency_rate' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_thousand_sign_is_not_a_string' => [
        function () {
            return [FALSE, Currency::factory(['thousand_sign' => faker()->randomDigit()])];
        },
    ],
    'request_should_fail_when_thousand_sign_is_more_than_1_character' => [
        function () {
            return [FALSE, Currency::factory(['thousand_sign' => faker()->lexify('??')])];
        },
    ],
    'request_should_fail_when_decimal_sign_is_more_than_1_character' => [
        function () {
            return [FALSE, Currency::factory(['decimal_sign' => faker()->lexify('??')])];
        },
    ],
    'request_should_fail_when_decimal_position_is_not_an_integer' => [
        function () {
            return [FALSE, Currency::factory(['decimal_position' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_currency_status_is_not_a_boolean' => [
        function () {
            return [FALSE, Currency::factory(['currency_status' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Currency::factory()];
        },
    ],
]);
