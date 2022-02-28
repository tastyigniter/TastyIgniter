<?php

namespace Tests\Unit\Admin\Requests;

use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\Ingredient::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, ['description' => faker()->sentence()]];
        },
    ],
    'request_should_fail_when_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, ['name' => faker()->sentence(129)]];
        },
    ],
    'request_should_fail_when_description_has_less_than_2_characters' => [
        function () {
            return [FALSE, [
                'name' => faker()->word(),
                'description' => 'a',
                'status' => faker()->boolean(),
            ]];
        },
    ],
    'request_should_fail_when_status_is_not_valid' => [
        function () {
            return [FALSE, [
                'name' => faker()->word(),
                'description' => faker()->sentence(),
                'status' => faker()->word(),
            ]];
        },
    ],
    'request_should_fail_when_is_allergen_is_not_valid' => [
        function () {
            return [FALSE, [
                'name' => faker()->word(),
                'description' => faker()->sentence(),
                'status' => faker()->word(),
                'is_allergen' => faker()->word(),
            ]];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, [
                'name' => faker()->word(),
                'description' => faker()->sentence(),
                'status' => faker()->boolean(),
            ]];
        },
    ],
]);
