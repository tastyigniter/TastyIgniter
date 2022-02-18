<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\Menu;
use Faker\Factory;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = Menu::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_menu_name_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['menu_name']),
            ],
            'request_should_fail_when_no_menu_price_is_provided' => [
                'passed' => FALSE,
                'data' => $this->exceptValidationData($faker, ['menu_price']),
            ],
            'request_should_fail_when_no_special_start_date_is_provided' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'validity' => 'period',
                        'end_date' => $faker->date(),
                    ],
                ]),
            ],
            'request_should_fail_when_no_special_end_date_is_provided' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'validity' => 'period',
                        'start_date' => $faker->date(),
                    ],
                ]),
            ],
            'request_should_fail_when_no_special_recurring_from_is_provided' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'validity' => 'recurring',
                        'recurring_every' => 'Mon',
                        'to_time' => $faker->time('H:i'),
                    ],
                ]),
            ],
            'request_should_fail_when_no_special_recurring_to_is_provided' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'validity' => 'recurring',
                        'recurring_every' => 'Mon',
                        'from_time' => $faker->time('H:i'),
                    ],
                ]),
            ],

            'request_should_fail_when_menu_name_has_more_than_255_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'menu_name' => $faker->sentence(256),
                ]),
            ],
            'request_should_fail_when_menu_description_has_more_than_1028_characters' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'menu_description' => $faker->sentence(1029),
                ]),
            ],

            'request_should_fail_when_menu_price_is_less_than_zero' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'menu_price' => $faker->numberBetween(-100, 0),
                ]),
            ],
            'request_should_fail_when_minimum_qty_is_less_than_one' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'minimum_qty' => $faker->numberBetween(-10, 0),
                ]),
            ],

            'request_should_fail_when_stock_qty_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'stock_qty' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_minimum_qty_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'minimum_qty' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_order_restriction_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'order_restriction' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_menu_priority_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'menu_priority' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_special_id_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'special_id' => $faker->word(),
                    ],
                ]),
            ],

            'request_should_fail_when_subtract_stock_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'subtract_stock' => $faker->word(),
                ]),
            ],
            'request_should_fail_when_menu_status_is_not_a_boolean' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'menu_status' => $faker->word(),
                ]),
            ],

            'request_should_fail_when_categories_is_not_an_array_of_integers' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'categories' => [$faker->word],
                ]),
            ],
            'request_should_fail_when_locations_is_not_an_array_of_integers' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'locations' => [$faker->word],
                ]),
            ],

            'request_should_fail_when_special_type_is_not_F_or_P' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'type' => $faker->word(),
                    ],
                ]),
            ],
            'request_should_fail_when_special_validity_is_not_forever_period_or_recurring' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'validity' => $faker->word(),
                    ],
                ]),
            ],

            'request_should_fail_when_special_price_is_not_a_float' => [
                'passed' => FALSE,
                'data' => $this->mergeValidationData($faker, [
                    'special' => [
                        'special_price' => $faker->word(),
                    ],
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
            'menu_name' => $faker->word(),
            'menu_price' => $faker->randomFloat(),
            'categories' => [$faker->numberBetween(2, 50)],
            'minimum_qty' => $faker->numberBetween(2, 500),
            'subtract_stock' => $faker->boolean(),
        ];
    }
}
