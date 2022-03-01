<?php

namespace Tests\Unit\System\Requests;

use System\Models\Language;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\System\Requests\Language::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, Language::factory(['name' => null])];
        },
    ],
    'request_should_fail_when_no_code_is_provided' => [
        function () {
            return [FALSE, Language::factory(['code' => null])];
        },
    ],
    'request_should_fail_when_no_status_is_provided' => [
        function () {
            return [FALSE, Language::factory(['status' => null])];
        },
    ],
    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, Language::factory(['name' => faker()->lexify('?')])];
        },
    ],
    'request_should_fail_when_name_has_more_than_32_characters' => [
        function () {
            return [FALSE, Language::factory(['name' => faker()->sentence(33)])];
        },
    ],
    'request_should_fail_when_code_contains_non_alpha_or_dashes' => [
        function () {
            return [FALSE, Language::factory(['code' => faker()->randomDigit()])];
        },
    ],
    'request_should_fail_when_status_is_not_boolean' => [
        function () {
            return [FALSE, Language::factory(['status' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Language::factory()];
        },
    ],
]);
