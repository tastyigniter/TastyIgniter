<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Category;
use Admin\Models\Menu;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequestAsExpected(\Admin\Requests\Menu::class, $callback);
})->with([
    'request_should_fail_when_no_menu_name_is_provided' => [
        function () {
            return [FALSE, Menu::factory(['menu_name' => null])];
        },
    ],
    'request_should_fail_when_no_menu_price_is_provided' => [
        function () {
            return [FALSE, Menu::factory(['menu_price' => null])];
        },
    ],

    'request_should_fail_when_menu_name_has_more_than_255_characters' => [
        function () {
            return [FALSE, Menu::factory(['menu_name' => faker()->sentence(256)])];
        },
    ],
    'request_should_fail_when_menu_description_has_more_than_1028_characters' => [
        function () {
            return [FALSE, Menu::factory(['menu_description' => faker()->sentence(1029)])];
        },
    ],

    'request_should_fail_when_menu_price_is_less_than_zero' => [
        function () {
            return [FALSE, Menu::factory(['menu_price' => faker()->numberBetween(-100, 0),
            ])];
        },
    ],
    'request_should_fail_when_minimum_qty_is_less_than_one' => [
        function () {
            return [FALSE, Menu::factory(['minimum_qty' => faker()->numberBetween(-10, 0)])];
        },
    ],

    'request_should_fail_when_minimum_qty_is_not_an_integer' => [
        function () {
            return [FALSE, Menu::factory(['minimum_qty' => faker()->word()])];
        },
    ],
    'request_should_fail_when_order_restriction_is_not_an_string' => [
        function () {
            return [FALSE, Menu::factory(['order_restriction' => [faker()->randomDigit()]])];
        },
    ],
    'request_should_fail_when_menu_priority_is_not_an_integer' => [
        function () {
            return [FALSE, Menu::factory(['menu_priority' => faker()->word()])];
        },
    ],

    'request_should_fail_when_menu_status_is_not_a_boolean' => [
        function () {
            return [FALSE, Menu::factory(['menu_status' => faker()->word()])];
        },
    ],

    'request_should_fail_when_categories_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, Menu::factory(['categories' => [faker()->word]])];
        },
    ],
    'request_should_fail_when_locations_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, Menu::factory(['locations' => [faker()->word]])];
        },
    ],

    'request_should_pass_when_menu_description_is_valid_html' => [
        function () {
            return [FALSE, Category::factory(['menu_description' => faker()->randomHtml()])];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Menu::factory()];
        },
    ],
]);
