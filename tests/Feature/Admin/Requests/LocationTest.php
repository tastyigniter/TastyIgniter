<?php

namespace Tests\Feature\Admin\Requests;

use Admin\Requests\Location;
use Faker\Factory;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use ValidateRequest;

    protected $requestClass = Location::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_location_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_name']),
            ],
            'request_should_fail_when_no_location_email_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_email']),
            ],
            'request_should_fail_when_no_location_address_1_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_address_1']),
            ],
            'request_should_fail_when_no_location_country_id_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_country_id']),
            ],
            'request_should_fail_when_no_location_latitude_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_lat']),
            ],
            'request_should_fail_when_no_location_longitude_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['location_lng']),
            ],

            'request_should_fail_when_location_address_1_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_address_1' => $faker->sentence(129),
                ]),
            ],
            'request_should_fail_when_location_address_2_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_address_2' => $faker->sentence(129),
                ]),
            ],
            'request_should_fail_when_location_city_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_city' => $faker->sentence(129),
                ]),
            ],
            'request_should_fail_when_location_state_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_state' => $faker->sentence(129),
                ]),
            ],
            'request_should_fail_when_location_postcode_has_more_than_15_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_postcode' => $faker->sentence(16),
                ]),
            ],
            'request_should_fail_when_description_has_more_than_5000_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'description' => $faker->sentence(5001),
                ]),
            ],
            'request_should_fail_when_permalink_slug_has_more_than_255_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'permalink_slug' => $faker->sentence(255),
                ]),
            ],
            'request_should_fail_when_gallery_title_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'gallery' => [
                        'title' => $faker->sentence(129),
                    ],
                ]),
            ],
            'request_should_fail_when_gallery_description_has_more_than_255_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'gallery' => [
                        'description' => $faker->sentence(256),
                    ],
                ]),
            ],

            'request_should_fail_when_location_country_id_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_country_id' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_delivery_time_interval_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'delivery_time_interval' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_collection_time_interval_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'collection_time_interval' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_delivery_lead_time_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'delivery_lead_time' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_collection_lead_time_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'collection_lead_time' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_future_orders_delivery_days_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'future_orders' => [
                        'delivery_days' => $faker->word(),
                    ],
                ], 'options'),
            ],
            'request_should_fail_when_future_orders_collection_days_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'future_orders' => [
                        'collection_days' => $faker->word(),
                    ],
                ], 'options'),
            ],
            'request_should_fail_when_reservation_time_interval_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'reservation_time_interval' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_reservation_lead_time_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'reservation_lead_time' => $faker->word(),
                ], 'options'),
            ],
            'request_should_fail_when_auto_allocate_table_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'auto_allocate_table' => $faker->word(),
                ], 'options'),
            ],

            'request_should_fail_when_location_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'location_status' => $faker->numberBetween(2),
                ]),
            ],
            'request_should_fail_when_auto_lat_lng_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'auto_lat_lng' => $faker->numberBetween(2),
                ], 'options'),
            ],
            'request_should_fail_when_offer_delivery_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'offer_delivery' => $faker->numberBetween(2),
                ], 'options'),
            ],
            'request_should_fail_when_offer_collection_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'offer_collection' => $faker->numberBetween(2),
                ], 'options'),
            ],
            'request_should_fail_when_offer_reservation_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'offer_reservation' => $faker->numberBetween(2),
                ], 'options'),
            ],
            'request_should_fail_when_future_orders_enable_delivery_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'future_orders' => [
                        'enable_delivery' => $faker->numberBetween(2),
                    ],
                ], 'options'),
            ],
            'request_should_fail_when_future_orders_enable_collection_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'future_orders' => [
                        'enable_collection' => $faker->numberBetween(2),
                    ],
                ], 'options'),
            ],

            'request_should_fail_when_permalink_slug_has_non_alpha_dash_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'permalink_slug' => $faker->sentence(),
                ]),
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => $this->validationData($faker),
            ],
        ];
    }

    protected function validationData($faker)
    {
        return [
            'location_name' => $faker->text(32),
            'location_email' => $faker->email(),
            'location_address_1' => $faker->streetAddress(),
            'location_country_id' => $faker->numberBetween(1, 200),
            'location_lat' => $faker->latitude(),
            'location_lng' => $faker->longitude(),
            'options' => [
                'auto_lat_lng' => 0,
            ],
        ];
    }
}
