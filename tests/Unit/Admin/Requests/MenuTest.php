<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Menu;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\Menu::class, $callback);
})->with([
    'request_should_fail_when_no_menu_name_is_provided' => [
        function () {
            return [FALSE, array_except(Menu::factory()->raw(), ['menu_name'])];
        },
    ],
    'request_should_fail_when_no_menu_price_is_provided' => [
        function () {
            return [FALSE, array_except(Menu::factory()->raw(), ['menu_price'])];
        },
    ],
    'request_should_fail_when_no_special_start_date_is_provided' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'special' => [
                    'validity' => 'period',
                    'end_date' => faker()->date(),
                ],
            ])];
        },
    ],
    'request_should_fail_when_no_special_end_date_is_provided' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'special' => [
                    'validity' => 'period',
                    'start_date' => faker()->date(),
                ],
            ])];
        },
    ],
    'request_should_fail_when_no_special_recurring_from_is_provided' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'special' => [
                    'validity' => 'recurring',
                    'recurring_every' => 'Mon',
                    'to_time' => faker()->time('H:i'),
                ],
            ])];
        },
    ],
    'request_should_fail_when_no_special_recurring_to_is_provided' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'special' => [
                    'validity' => 'recurring',
                    'recurring_every' => 'Mon',
                    'from_time' => faker()->time('H:i'),
                ],
            ])];
        },
    ],

    'request_should_fail_when_menu_name_has_more_than_255_characters' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'menu_name' => faker()->sentence(256),
            ])];
        },
    ],
    'request_should_fail_when_menu_description_has_more_than_1028_characters' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'menu_description' => faker()->sentence(1029),
            ])];
        },
    ],

    'request_should_fail_when_menu_price_is_less_than_zero' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'menu_price' => faker()->numberBetween(-100, 0),
            ])];
        },
    ],
    'request_should_fail_when_minimum_qty_is_less_than_one' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'minimum_qty' => faker()->numberBetween(-10, 0),
            ])];
        },
    ],

    'request_should_fail_when_stock_qty_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'stock_qty' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_minimum_qty_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'minimum_qty' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_order_restriction_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'order_restriction' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_menu_priority_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'menu_priority' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_special_id_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'special' => [
                    'special_id' => faker()->word(),
                ],
            ])];
        },
    ],

    'request_should_fail_when_subtract_stock_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'subtract_stock' => faker()->word(),
            ])];
        },
    ],
    'request_should_fail_when_menu_status_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'menu_status' => faker()->word(),
            ])];
        },
    ],

    'request_should_fail_when_categories_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'categories' => [faker()->word],
            ])];
        },
    ],
    'request_should_fail_when_locations_is_not_an_array_of_integers' => [
        function () {
            return [FALSE, array_merge(Menu::factory()->raw(), [
                'locations' => [faker()->word],
            ])];
        },
    ],

    'request_should_fail_when_special_type_is_not_F_or_P' => [
        function () {
            return [FALSE, array_merge_recursive(Menu::factory()->raw(), [
                'special' => [
                    'type' => faker()->word(),
                ],
            ])];
        },
    ],
    'request_should_fail_when_special_validity_is_not_forever_period_or_recurring' => [
        function () {
            return [FALSE, array_merge_recursive(Menu::factory()->raw(), [
                'special' => [
                    'validity' => faker()->word(),
                ],
            ])];
        },
    ],

    'request_should_fail_when_special_price_is_not_a_float' => [
        function () {
            return [FALSE, array_merge_recursive(Menu::factory()->raw(), [
                'special' => [
                    'special_price' => faker()->word(),
                ],
            ])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Menu::factory()];
        },
    ],
]);
