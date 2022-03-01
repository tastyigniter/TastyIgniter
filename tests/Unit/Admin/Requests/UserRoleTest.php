<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\UserRole;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\UserRole::class, $callback);
})->with([
    'request_should_fail_when_no_code_is_provided' => [
        function () {
            return [FALSE, UserRole::factory(['code' => null])];
        },
    ],
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, UserRole::factory(['name' => null])];
        },
    ],
    'request_should_fail_when_no_permissions_is_provided' => [
        function () {
            return [FALSE, UserRole::factory(['permissions' => null])];
        },
    ],

    'request_should_fail_when_code_has_non_alpha_dash_characters' => [
        function () {
            return [FALSE, UserRole::factory(['code' => faker()->text()])];
        },
    ],

    'request_should_fail_when_code_has_more_than_32_characters' => [
        function () {
            return [FALSE, UserRole::factory(['code' => faker()->sentence(33)])];
        },
    ],
    'request_should_fail_when_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, UserRole::factory(['name' => faker()->sentence(129)])];
        },
    ],

    'request_should_fail_when_code_has_less_than_2_characters' => [
        function () {
            return [FALSE, UserRole::factory(['code' => faker()->randomLetter])];
        },
    ],
    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, UserRole::factory(['name' => faker()->randomLetter])];
        },
    ],

    'request_should_fail_when_permissions_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, UserRole::factory(['permissions' => [faker()->word]])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, UserRole::factory()];
        },
    ],
]);
