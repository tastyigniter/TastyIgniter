<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\UserGroup;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\UserGroup::class, $callback);
})->with([
    'request_should_fail_when_no_user_group_name_is_provided' => [
        function () {
            return [FALSE, UserGroup::factory(['user_group_name' => null])];
        },
    ],
    'request_should_fail_when_no_auto_assign_is_provided' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign' => null])];
        },
    ],
    'request_should_fail_when_no_auto_assign_mode_is_provided' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign' => TRUE, 'auto_assign_mode' => null])];
        },
    ],
    'request_should_fail_when_no_auto_assign_limit_is_provided' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign_mode' => 2, 'auto_assign_limit' => null])];
        },
    ],
    'request_should_fail_when_no_assignment_availability_is_provided' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign' => TRUE, 'assignment_availability' => null])];
        },
    ],

    'request_should_fail_when_user_group_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, UserGroup::factory(['user_group_name' => faker()->sentence(129)])];
        },
    ],

    'request_should_fail_when_user_group_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, UserGroup::factory(['user_group_name' => faker()->randomLetter])];
        },
    ],

    'request_should_fail_when_auto_assign_mode_is_not_an_integer' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign_mode' => faker()->word()])];
        },
    ],
    'request_should_fail_when_auto_assign_limit_is_not_an_integer' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign_limit' => faker()->word()])];
        },
    ],

    'request_should_fail_when_auto_assign_is_not_a_boolean' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign' => faker()->word()])];
        },
    ],
    'request_should_fail_when_assignment_availability_is_not_a_boolean' => [
        function () {
            return [FALSE, UserGroup::factory(['auto_assign' => TRUE, 'assignment_availability' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, UserGroup::factory()];
        },
    ],
]);
