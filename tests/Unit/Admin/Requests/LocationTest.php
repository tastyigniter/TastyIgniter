<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Location;
use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\Location::class, $callback);
})->with([
    'request_should_fail_when_no_location_name_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_name'])];
        },
    ],
    'request_should_fail_when_no_location_email_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_email'])];
        },
    ],
    'request_should_fail_when_no_location_address_1_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_address_1'])];
        },
    ],
    'request_should_fail_when_no_location_country_id_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_country_id'])];
        },
    ],
    'request_should_fail_when_no_location_latitude_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_lat'])];
        },
    ],
    'request_should_fail_when_no_location_longitude_is_provided' => [
        function () {
            return [FALSE, array_except(Location::factory()->raw(), ['location_lng'])];
        },
    ],

    'request_should_fail_when_location_address_1_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'location_address_1' => faker()->sentence(129),
            ])];
        },
    ],
    'request_should_fail_when_location_address_2_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'location_address_2' => faker()->sentence(129),
            ])];
        },
    ],
    'request_should_fail_when_location_city_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'location_city' => faker()->sentence(129),
            ])];
        },
    ],
    'request_should_fail_when_location_state_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'location_state' => faker()->sentence(129),
            ])];
        },
    ],
    'request_should_fail_when_location_postcode_has_more_than_15_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'location_postcode' => faker()->sentence(16),
            ])];
        },
    ],
    'request_should_fail_when_description_has_more_than_5000_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'description' => faker()->sentence(5001),
            ])];
        },
    ],
    'request_should_fail_when_permalink_slug_has_more_than_255_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'permalink_slug' => faker()->sentence(255),
            ])];
        },
    ],
    'request_should_fail_when_gallery_title_has_more_than_128_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'gallery' => [
                    'title' => faker()->sentence(129),
                ],
            ])];
        },
    ],
    'request_should_fail_when_gallery_description_has_more_than_255_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'gallery' => [
                    'description' => faker()->sentence(256),
                ],
            ])];
        },
    ],

    'request_should_fail_when_location_country_id_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), ['location_country_id' => faker()->word()])];
        },
    ],
    'request_should_fail_when_delivery_time_interval_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['delivery_time_interval' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_collection_time_interval_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['collection_time_interval' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_delivery_lead_time_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['delivery_lead_time' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_collection_lead_time_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['collection_lead_time' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_future_orders_delivery_days_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['future_orders' => ['delivery_days' => faker()->word()]],
            ])];
        },
    ],
    'request_should_fail_when_future_orders_collection_days_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['future_orders' => ['collection_days' => faker()->word()]],
            ])];
        },
    ],
    'request_should_fail_when_reservation_time_interval_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['reservation_time_interval' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_reservation_lead_time_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['reservation_lead_time' => faker()->word()],
            ])];
        },
    ],
    'request_should_fail_when_auto_allocate_table_is_not_an_integer' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => ['auto_allocate_table' => faker()->word()],
            ])];
        },
    ],

    'request_should_fail_when_location_status_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'location_status' => faker()->numberBetween(2),
            ])];
        },
    ],
    'request_should_fail_when_auto_lat_lng_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'auto_lat_lng' => faker()->numberBetween(2),
                ],
            ])];
        },
    ],
    'request_should_fail_when_offer_delivery_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'offer_delivery' => faker()->numberBetween(2),
                ],
            ])];
        },
    ],
    'request_should_fail_when_offer_collection_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'offer_collection' => faker()->numberBetween(2),
                ],
            ])];
        },
    ],
    'request_should_fail_when_offer_reservation_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'offer_reservation' => faker()->numberBetween(2),
                ],
            ])];
        },
    ],
    'request_should_fail_when_future_orders_enable_delivery_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'future_orders' => [
                        'enable_delivery' => faker()->numberBetween(2),
                    ],
                ],
            ])];
        },
    ],
    'request_should_fail_when_future_orders_enable_collection_is_not_a_boolean' => [
        function () {
            return [FALSE, array_merge_recursive(Location::factory()->raw(), [
                'options' => [
                    'future_orders' => [
                        'enable_collection' => faker()->numberBetween(2),
                    ],
                ],
            ])];
        },
    ],

    'request_should_fail_when_permalink_slug_has_non_alpha_dash_characters' => [
        function () {
            return [FALSE, array_merge(Location::factory()->raw(), [
                'permalink_slug' => faker()->sentence(),
            ])];
        },
    ],
    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, Location::factory()];
        },
    ],
]);
