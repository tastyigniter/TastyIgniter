<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Category;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\Category::class, $callback);
})->with([
    'request_should_fail_when_no_name_is_provided' => [
        function () {
            return [FALSE, Category::factory(['name' => null])];
        },
    ],
    'request_should_fail_when_name_has_more_than_128_characters' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->sentence(129),
            ])];
        },
    ],
    'request_should_fail_when_description_has_less_than_2_characters' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'description' => faker()->lexify('?'),
            ])];
        },
    ],
    'request_should_fail_when_permalink_slug_has_non_alpha_dash_characters' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'permalink_slug' => faker()->sentence(),
            ])];
        },
    ],
    'request_should_fail_when_permalink_slug_has_more_than_255_characters' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'permalink_slug' => faker()->slug(256),
            ])];
        },
    ],
    'request_should_fail_when_parent_id_is_not_an_integer' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'parent_id' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_priority_is_not_an_integer' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'priority' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_locations_is_not_an_array' => [
        function () {
            return [FALSE, Category::factory([
                'name' => faker()->word(),
                'locations' => [faker()->word()],
            ])];
        },
    ],
    'request_should_pass_when_description_is_valid_html' => [
        function () {
            return [FALSE, Category::factory(['description' => faker()->randomHtml()])];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Category::factory()];
        },
    ],
]);
