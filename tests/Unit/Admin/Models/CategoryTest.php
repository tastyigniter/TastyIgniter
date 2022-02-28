<?php

namespace Tests\Unit\Admin\Models;

use Admin\Models\Category;
use Admin\Models\Location;

it('can create a category and assign it to a location', function () {
    $location = Location::factory()->create();
    $category = Category::factory()->make();
    $category->locations = [$location->getKey()];
    $categoryModel = $category->create();

    $this->assertTrue($categoryModel->exists());
});

it('shouldnt create a category when no name is provided', function () {
    try {
        $category = Category::factory()->make();
        $category->name = null;
        $category->save();
        $this->assertFalse(TRUE);
    }
    catch (\Exception $e) {
        $this->assertFalse(FALSE);
    }
});
