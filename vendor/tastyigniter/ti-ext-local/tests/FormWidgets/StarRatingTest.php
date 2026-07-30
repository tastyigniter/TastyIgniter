<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\FormWidgets;

use Igniter\Admin\Classes\FormField;
use Igniter\Local\FormWidgets\StarRating;
use Igniter\Local\Http\Controllers\Locations;
use Igniter\Local\Models\Location;
use Igniter\System\Facades\Assets;

beforeEach(function(): void {
    $location = Location::factory()->create();
    $this->controller = resolve(Locations::class);
    //    $this->controller->asExtension(FormController::class)->initForm($this->location);

    $formField = (new FormField('test_field', 'Star rating'))->displayAs('starrating');
    $this->starRatingWidget = new StarRating($this->controller, $formField, [
        'model' => $location,
    ]);
});
it('initializes correctly', function(): void {
    $this->starRatingWidget->initialize();

    expect(StarRating::$hints)->toBeArray();
});

it('prepares variables correctly', function(): void {
    $this->starRatingWidget->prepareVars();

    expect($this->starRatingWidget->vars)
        ->toHaveKey('field')
        ->toHaveKey('name')
        ->toHaveKey('value')
        ->toHaveKey('hints');
});

it('loads assets correctly', function(): void {
    Assets::shouldReceive('addCss')->once()->with('vendor/raty/jquery.raty.css', 'jquery-raty-css');
    Assets::shouldReceive('addCss')->once()->with('css/starrating.css', 'starrating-css');
    Assets::shouldReceive('addJs')->once()->with('vendor/raty/jquery.raty.js', 'jquery-raty-js');
    Assets::shouldReceive('addJs')->once()->with('js/starrating.js', 'starrating-js');

    $this->starRatingWidget->assetPath = [];

    $this->starRatingWidget->loadAssets();
});

it('saves value correctly', function(): void {
    $value = $this->starRatingWidget->getSaveValue('5');

    expect($value)->toBe(5);

    $value = $this->starRatingWidget->getSaveValue(null);

    expect($value)->toBe(0);
});
