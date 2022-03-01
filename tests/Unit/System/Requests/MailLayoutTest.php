<?php

namespace Tests\Unit\System\Requests;

use System\Models\MailLayout;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\System\Requests\MailLayout::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, MailLayout::factory(['name' => null])];
        },
    ],
    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, MailLayout::factory(['name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_name_has_more_than_32_characters' => [
        function () {
            return [FALSE, MailLayout::factory(['name' => faker()->sentence(33)])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, MailLayout::factory(['name' => faker()->word()])];
        },
    ],
]);
