<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Mealtime;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\Mealtime::class, $callback);
})->with([
    'request_should_fail_when_no_mealtime_name_is_provided' => [
        function () {
            return [FALSE, array_except(Mealtime::factory()->raw(), ['mealtime_name'])];
        },
    ],
    'request_should_fail_when_no_start_time_is_provided' => [
        function () {
            return [FALSE, array_except(Mealtime::factory()->raw(), ['start_time'])];
        },
    ],
    'request_should_fail_when_no_end_time_is_provided' => [
        function () {
            return [FALSE, array_except(Mealtime::factory()->raw(), ['end_time'])];
        },
    ],
    'request_should_fail_when_no_mealtime_status_is_provided' => [
        function () {
            return [FALSE, array_except(Mealtime::factory()->raw(), ['mealtime_status'])];
        },
    ],

    'request_should_fail_when_mealtime_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Mealtime::factory()->raw(), ['mealtime_name' => faker()->sentence(129)])];
        },
    ],

    'request_should_fail_when_mealtime_status_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge(Mealtime::factory()->raw(), ['mealtime_status' => faker()->word()])];
        },
    ],
    'request_should_fail_when_locations_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, array_merge(Mealtime::factory()->raw(), ['locations' => [faker()->word()]])];
        },
    ],
    'request_should_fail_when_start_time_is_not_a_valid_time' => [
        function () {
            return [FALSE, array_merge(Mealtime::factory()->raw(), ['start_time' => faker()->word()])];
        },
    ],
    'request_should_fail_when_end_time_is_not_a_valid_time' => [
        function () {
            return [FALSE, array_merge(Mealtime::factory()->raw(), ['end_time' => faker()->word()])];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Mealtime::factory()];
        },
    ],
]);
