<?php

namespace Tests\Unit\System\Requests;

use System\Models\Country;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\System\Requests\Country::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, Country::factory(['country_name' => null])];
        },
    ],
    'request_should_fail_when_no_priority_is_provided' => [
        function () {
            return [FALSE, array_except(Country::factory()->raw(), 'priority')];
        },
    ],
    'request_should_fail_when_no_iso_code_2_is_provided' => [
        function () {
            return [FALSE, array_except(Country::factory()->raw(), 'iso_code_2')];
        },
    ],
    'request_should_fail_when_no_iso_code_3_is_provided' => [
        function () {
            return [FALSE, array_except(Country::factory()->raw(), 'iso_code_3')];
        },
    ],
    'request_should_fail_when_no_status_is_provided' => [
        function () {
            return [FALSE, array_except(Country::factory()->raw(), 'status')];
        },
    ],

    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, Country::factory(['country_name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, Country::factory(['country_name' => faker()->sentence(129)])];
        },
    ],
    'request_should_fail_when_priority_is_not_an_integer' => [
        function () {
            return [FALSE, Country::factory(['priority' => faker()->word()])];
        },
    ],
    'request_should_fail_when_iso_code_2_is_not_a_string' => [
        function () {
            return [FALSE, Country::factory(['iso_code_2' => faker()->boolean()])];
        },
    ],
    'request_should_fail_when_iso_code_2_is_less_than_2_characters' => [
        function () {
            return [FALSE, Country::factory(['iso_code_2' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_iso_code_2_is_more_than_2_characters' => [
        function () {
            return [FALSE, Country::factory(['iso_code_2' => faker()->lexify('???')])];
        },
    ],
    'request_should_fail_when_iso_code_3_is_not_a_string' => [
        function () {
            return [FALSE, Country::factory(['iso_code_3' => faker()->boolean()])];
        },
    ],
    'request_should_fail_when_iso_code_3_is_less_than_3_characters' => [
        function () {
            return [FALSE, Country::factory(['iso_code_3' => faker()->lexify('??')])];
        },
    ],
    'request_should_fail_when_iso_code_3_is_more_than_3_characters' => [
        function () {
            return [FALSE, Country::factory(['iso_code_3' => faker()->lexify('?????')])];
        },
    ],
    'request_should_fail_when_format_is_less_than_2_characters' => [
        function () {
            return [FALSE, Country::factory(['format' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_status_is_not_a_boolean' => [
        function () {
            return [FALSE, Country::factory(['status' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Country::factory()];
        },
    ],
]);
