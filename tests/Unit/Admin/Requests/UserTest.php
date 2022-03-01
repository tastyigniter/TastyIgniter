<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\User;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\User::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, User::factory(['name' => null])];
        },
    ],
    'request_should_fail_when_no_email_is_provided' => [
        function () {
            return [FALSE, User::factory(['email' => null])];
        },
    ],
    'request_should_fail_when_no_username_is_provided' => [
        function () {
            return [FALSE, User::factory(['username' => null])];
        },
    ],
    'request_should_fail_when_no_password_is_provided' => [
        function () {
            return [FALSE, User::factory(['password' => null])];
        },
    ],
    'request_should_fail_when_no_user_role_id_is_provided' => [
        function () {
            return [FALSE, User::factory(['user_role_id' => null])];
        },
    ],
    'request_should_fail_when_no_groups_is_provided' => [
        function () {
            return [FALSE, User::factory(['groups' => null])];
        },
    ],

    'request_should_fail_when_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, User::factory(['name' => faker()->sentence(129)])];
        },
    ],
    'request_should_fail_when_email_has_more_than_96_characters' => [
        function () {
            return [FALSE, User::factory(['email' => faker()->sentence(97)])];
        },
    ],
    'request_should_fail_when_username_has_more_than_255_characters' => [
        function () {
            return [FALSE, User::factory(['username' => faker()->sentence(32)])];
        },
    ],
    'request_should_fail_when_password_has_more_than_255_characters' => [
        function () {
            return [FALSE, User::factory(['password' => faker()->password(6, 32)])];
        },
    ],

    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, User::factory(['name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_username_has_less_than_2_characters' => [
        function () {
            return [FALSE, User::factory(['username' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_password_has_less_than_6_characters' => [
        function () {
            return [FALSE, User::factory(['password' => faker()->password(2, 5)])];
        },
    ],

    'request_should_fail_when_language_id_is_not_an_integer' => [
        function () {
            return [FALSE, User::factory(['language_id' => faker()->word()])];
        },
    ],
    'request_should_fail_when_user_role_id_is_not_an_integer' => [
        function () {
            return [FALSE, User::factory(['user_role_id' => faker()->word()])];
        },
    ],

    'request_should_fail_when_status_is_not_a_boolean' => [
        function () {
            return [FALSE, User::factory(['status' => faker()->word()])];
        },
    ],

    'request_should_fail_when_groups_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, User::factory(['groups' => [faker()->word]])];
        },
    ],
    'request_should_fail_when_locations_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, User::factory(['locations' => [faker()->word]])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, User::factory()];
        },
    ],
]);
