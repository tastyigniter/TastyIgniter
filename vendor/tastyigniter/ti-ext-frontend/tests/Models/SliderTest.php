<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\Validation;
use Igniter\Frontend\Models\Slider;

it('configures slider model correctly', function(): void {
    $slider = new Slider;

    expect(class_uses_recursive($slider))
        ->toContain(HasMedia::class)
        ->toContain(Validation::class)
        ->and($slider->getTable())->toBe('igniter_frontend_sliders')
        ->and($slider->getGuarded())->toBe([])
        ->and($slider->timestamps)->toBeTrue()
        ->and($slider->rules)->toBe([
            ['name', 'admin::lang.label_name', 'required|string'],
            ['code', 'igniter.frontend::default.slider.label_code', 'required|alpha_dash'],
        ])
        ->and($slider->mediable)->toBe([
            'images' => ['multiple' => true],
        ])
        ->and($slider->getMorphClass())->toBe('sliders');
});
