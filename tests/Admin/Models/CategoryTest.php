<?php

namespace Tests\Admin\Models;

use Admin\Models\Categories_model;
use Admin\Models\Locations_model;

it('can create a category and assign it to a location', function () {
    $location = Locations_model::factory()->create();
    $category = Categories_model::factory()->make();
    $category->locations = [$location->getKey()];
    $categoryModel = $category->create();

    $this->assertTrue($categoryModel->exists());
});

it('shouldnt create a category when no name is provided', function () {
    $category = Categories_model::factory()->make();
    $category->name = NULL;
    $category->save();
    $this->assertFalse($categoryModel->exists());
});


            // 'request_should_fail_when_no_name_is_provided' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'description' => $faker->sentence(),
            //     ],
            // ],
            // 'request_should_fail_when_name_has_more_than_128_characters' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->sentence(129),
            //     ],
            // ],
            // 'request_should_fail_when_description_has_less_than_2_characters' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'description' => $faker->lexify('?'),
            //     ],
            // ],
            // 'request_should_fail_when_permalink_slug_has_non_alpha_dash_characters' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'permalink_slug' => $faker->sentence(),
            //     ],
            // ],
            // 'request_should_fail_when_permalink_slug_has_more_than_255_characters' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'permalink_slug' => $faker->slug(256),
            //     ],
            // ],
            // 'request_should_fail_when_parent_id_is_not_an_integer' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'parent_id' => $faker->word(),
            //     ],
            // ],
            // 'request_should_fail_when_priority_is_not_an_integer' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'priority' => $faker->word(),
            //     ],
            // ],
            // 'request_should_fail_when_locations_is_not_an_array' => [
            //     'passed' => FALSE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'locations' => [$faker->word()],
            //     ],
            // ],
            // 'request_should_pass_when_data_is_provided' => [
            //     'passed' => TRUE,
            //     'data' => [
            //         'name' => $faker->word(),
            //         'description' => $faker->sentence(),
            //         'permalink_slug' => $faker->slug(),
            //         'parent_id' => null,
            //         'priority' => null,
            //         'status' => $faker->boolean(),
            //         'locations' => [$faker->numberBetween(1, 50)],
            //     ],
            // ],
