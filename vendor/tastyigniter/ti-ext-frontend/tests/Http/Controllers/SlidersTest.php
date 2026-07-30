<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Http\Controllers;

use Igniter\Frontend\Models\Slider;

it('loads sliders page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.frontend.sliders'))
        ->assertOk();
});

it('loads create slider page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.frontend.sliders', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit slider page', function(): void {
    $slider = Slider::create();

    actingAsSuperUser()
        ->get(route('igniter.frontend.sliders', ['slug' => 'edit/'.$slider->getKey()]))
        ->assertOk();
});

it('loads slider preview page', function(): void {
    $slider = Slider::create();

    actingAsSuperUser()
        ->get(route('igniter.frontend.sliders', ['slug' => 'preview/'.$slider->getKey()]))
        ->assertOk();
});

it('creates slider', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.frontend.sliders', ['slug' => 'create']), [
            'Slider' => [
                'name' => 'Created Slider',
                'code' => 'slider-code',
                'images' => [
                    'path/to/image.jpg',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Slider::where('name', 'Created Slider')->exists())->toBeTrue();
});

it('updates slider', function(): void {
    $slider = Slider::create();

    actingAsSuperUser()
        ->post(route('igniter.frontend.sliders', ['slug' => 'edit/'.$slider->getKey()]), [
            'Slider' => [
                'name' => 'Updated Slider',
                'code' => 'slider-code',
                'images' => [
                    'path/to/image.jpg',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Slider::where('name', 'Updated Slider')->exists())->toBeTrue();
});

it('deletes slider', function(): void {
    $slider = Slider::create();

    actingAsSuperUser()
        ->post(route('igniter.frontend.sliders', ['slug' => 'edit/'.$slider->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Slider::find($slider->getKey()))->toBeNull();
});
