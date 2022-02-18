<?php

namespace Tests\Unit\Admin\Models;

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
    try {
        $category = Categories_model::factory()->make();
        $category->name = null;
        $category->save();
        $this->assertFalse(TRUE);
    }
    catch (\Exception $e) {
        $this->assertFalse(FALSE);
    }
});
