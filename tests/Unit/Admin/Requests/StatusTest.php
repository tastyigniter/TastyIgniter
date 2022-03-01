<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Status;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\Status::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, Status::factory(['status_name' => null])];
        },
    ],
    'request_should_fail_when_for_is_not_provided' => [
        function () {
            return [FALSE, Status::factory(['status_for' => null])];
        },
    ],
    'request_should_fail_when_notify_is_not_provided' => [
        function () {
            return [FALSE, Status::factory(['notify_customer' => null])];
        },
    ],
    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, Status::factory(['status_name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_name_has_more_than_32_characters' => [
        function () {
            return [FALSE, Status::factory(['status_name' => faker()->sentence(33)])];
        },
    ],
    'request_should_fail_when_for_is_not_valid' => [
        function () {
            return [FALSE, Status::factory(['status_for' => faker()->word()])];
        },
    ],
    'request_should_fail_when_color_has_more_than_7_characters' => [
        function () {
            return [FALSE, Status::factory(['status_color' => faker()->sentence(8)])];
        },
    ],
    'request_should_fail_when_comment_has_more_than_1028_characters' => [
        function () {
            return [FALSE, Status::factory(['status_comment' => faker()->sentence(1029)])];
        },
    ],
    'request_should_fail_when_notify_is_not_boolean' => [
        function () {
            return [FALSE, Status::factory(['notify_customer' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Status::factory()];
        },
    ],
]);
