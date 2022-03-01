<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Table;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\Table::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, tableFactory(['table_name' => null])];
        },
    ],
    'request_should_fail_when_no_min_capacity_is_provided' => [
        function () {
            return [FALSE, tableFactory(['min_capacity' => null])];
        },
    ],
    'request_should_fail_when_no_max_capacity_is_provided' => [
        function () {
            return [FALSE, tableFactory(['max_capacity' => null])];
        },
    ],
    'request_should_fail_when_no_extra_capacity_is_provided' => [
        function () {
            return [FALSE, tableFactory(['extra_capacity' => null])];
        },
    ],
    'request_should_fail_when_no_priority_is_provided' => [
        function () {
            return [FALSE, tableFactory(['priority' => null])];
        },
    ],
    'request_should_fail_when_no_joinable_is_provided' => [
        function () {
            return [FALSE, tableFactory(['is_joinable' => null])];
        },
    ],
    'request_should_fail_when_no_status_is_provided' => [
        function () {
            return [FALSE, tableFactory(['table_status' => null])];
        },
    ],

    'request_should_fail_when_name_has_less_than_2_characters' => [
        function () {
            return [FALSE, tableFactory([
                'table_name' => faker()->lexify('?'),
            ])];
        },
    ],
    'request_should_fail_when_name_has_more_than_255_characters' => [
        function () {
            return [FALSE, tableFactory([
                'table_name' => faker()->sentence(256),
            ])];
        },
    ],
    'request_should_fail_when_min_capacity_is_less_than_1' => [
        function () {
            return [FALSE, tableFactory([
                'min_capacity' => 0,
            ])];
        },
    ],
    'request_should_fail_when_min_capacity_is_greater_than_max_capacity' => [
        function () {
            return [FALSE, tableFactory([
                'min_capacity' => 5,
                'max_capacity' => 2,
            ])];
        },
    ],
    'request_should_fail_when_max_capacity_is_less_than_1' => [
        function () {
            return [FALSE, tableFactory([
                'max_capacity' => 0,
            ])];
        },
    ],
    'request_should_fail_when_min_capacity_is_not_an_integer' => [
        function () {
            return [FALSE, tableFactory([
                'min_capacity' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_max_capacity_is_not_an_integer' => [
        function () {
            return [FALSE, tableFactory([
                'max_capacity' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_extra_capacity_is_not_an_integer' => [
        function () {
            return [FALSE, tableFactory([
                'extra_capacity' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_priority_is_not_an_integer' => [
        function () {
            return [FALSE, tableFactory([
                'priority' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_joinable_is_not_a_boolean' => [
        function () {
            return [FALSE, tableFactory([
                'is_joinable' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_status_is_not_a_boolean' => [
        function () {
            return [FALSE, tableFactory([
                'table_status' => faker()->word(),
            ])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, tableFactory()];
        },
    ],
]);

function tableFactory($params = [])
{
    return Table::factory(array_merge($params, ['locations' => [faker()->numberBetween(1, 99)]]));
}
