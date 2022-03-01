<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Reservation;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\Reservation::class, $callback);
})->with([
    'request_should_fail_when_no_location_id_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['location_id' => null])];
        },
    ],
    'request_should_fail_when_no_first_name_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['first_name' => null])];
        },
    ],
    'request_should_fail_when_no_last_name_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['last_name' => null])];
        },
    ],
    'request_should_fail_when_no_reserve_date_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['reserve_date' => null])];
        },
    ],
    'request_should_fail_when_no_reserve_time_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['reserve_time' => null])];
        },
    ],
    'request_should_fail_when_no_guest_num_is_provided' => [
        function () {
            return [FALSE, Reservation::factory(['guest_num' => null])];
        },
    ],

    'request_should_fail_when_location_id_is_not_an_integer' => [
        function () {
            return [FALSE, Reservation::factory(['location_id' => faker()->word()])];
        },
    ],
    'request_should_fail_when_guest_num_is_not_an_integer' => [
        function () {
            return [FALSE, Reservation::factory(['guest_num' => faker()->word()])];
        },
    ],

    'request_should_fail_when_first_name_has_more_than_48_characters' => [
        function () {
            return [FALSE, Reservation::factory(['first_name' => faker()->sentence(49)])];
        },
    ],
    'request_should_fail_when_last_name_has_more_than_48_characters' => [
        function () {
            return [FALSE, Reservation::factory(['last_name' => faker()->sentence(49)])];
        },
    ],
    'request_should_fail_when_email_has_more_than_96_characters' => [
        function () {
            return [FALSE, Reservation::factory(['email' => faker()->sentence(97)])];
        },
    ],

    'request_should_fail_when_email_is_not_a_valid_email' => [
        function () {
            return [FALSE, Reservation::factory(['email' => faker()->word()])];
        },
    ],
    'request_should_fail_when_reserve_date_is_not_a_valid_date' => [
        function () {
            return [FALSE, Reservation::factory(['reserve_date' => faker()->word()])];
        },
    ],
    'request_should_fail_when_reserve_date_is_not_a_valid_time' => [
        function () {
            return [FALSE, Reservation::factory(['reserve_time' => faker()->word()])];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Reservation::factory()];
        },
    ],
]);
