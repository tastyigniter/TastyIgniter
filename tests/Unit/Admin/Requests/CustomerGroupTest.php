<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\CustomerGroup;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\CustomerGroup::class, $callback);
})->with([
    'request_should_fail_when_no_group_name_is_provided' => [
        function () {
            return [FALSE, CustomerGroup::factory(['group_name' => null])];
        },
    ],
    'request_should_fail_when_no_approval_is_provided' => [
        function () {
            return [FALSE, CustomerGroup::factory(['approval' => null])];
        },
    ],

    'request_should_fail_when_group_name_has_more_than_32_characters' => [
        function () {
            return [FALSE, CustomerGroup::factory(['group_name' => faker()->sentence(33)])];
        },
    ],
    'request_should_fail_when_description_has_more_than_500_characters' => [
        function () {
            return [FALSE, CustomerGroup::factory(['description' => faker()->sentence(501)])];
        },
    ],

    'request_should_fail_when_approval_is_not_a_boolean' => [
        function () {
            return [FALSE, CustomerGroup::factory(['approval' => faker()->word()])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, CustomerGroup::factory()];
        },
    ],
]);
