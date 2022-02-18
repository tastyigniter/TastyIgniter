<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Requests\Category;
use Faker\Factory;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use \Tests\Unit\System\Requests\ValidateRequest;

    protected $requestClass = Category::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => FALSE,
                'data' => [
                    'description' => $faker->sentence(),
                ],
            ],
            'request_should_fail_when_name_has_more_than_128_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->sentence(129),
                ],
            ],
            'request_should_fail_when_description_has_less_than_2_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'description' => $faker->lexify('?'),
                ],
            ],
            'request_should_fail_when_permalink_slug_has_non_alpha_dash_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'permalink_slug' => $faker->sentence(),
                ],
            ],
            'request_should_fail_when_permalink_slug_has_more_than_255_characters' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'permalink_slug' => $faker->slug(256),
                ],
            ],
            'request_should_fail_when_parent_id_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'parent_id' => $faker->word(),
                ],
            ],
            'request_should_fail_when_priority_is_not_an_integer' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'priority' => $faker->word(),
                ],
            ],
            'request_should_fail_when_locations_is_not_an_array' => [
                'passed' => FALSE,
                'data' => [
                    'name' => $faker->word(),
                    'locations' => [$faker->word()],
                ],
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => TRUE,
                'data' => [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(),
                    'permalink_slug' => $faker->slug(),
                    'parent_id' => null,
                    'priority' => null,
                    'status' => $faker->boolean(),
                    'locations' => [$faker->numberBetween(1, 50)],
                ],
            ],
        ];
    }
}
