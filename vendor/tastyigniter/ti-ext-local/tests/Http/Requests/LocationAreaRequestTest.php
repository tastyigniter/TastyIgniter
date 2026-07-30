<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Requests;

use Igniter\Local\Http\Requests\LocationAreaRequest;

it('returns correct attribute labels', function(): void {
    $attributes = (new LocationAreaRequest)->attributes();

    expect($attributes)->toHaveKey('type', lang('igniter.local::default.label_area_type'))
        ->and($attributes)->toHaveKey('name', lang('igniter.local::default.label_area_name'))
        ->and($attributes)->toHaveKey('is_default', lang('igniter.local::default.label_area_default'))
        ->and($attributes)->toHaveKey('area_id', lang('igniter.local::default.label_area_id'))
        ->and($attributes)->toHaveKey('boundaries.components', lang('igniter.local::default.label_address_component'))
        ->and($attributes)->toHaveKey('boundaries.components.*.type', lang('igniter.local::default.label_address_component_type'))
        ->and($attributes)->toHaveKey('boundaries.components.*.value', lang('igniter.local::default.label_address_component_value'))
        ->and($attributes)->toHaveKey('boundaries.polygon', lang('igniter.local::default.label_area_shape'))
        ->and($attributes)->toHaveKey('boundaries.circle', lang('igniter.local::default.label_area_circle'))
        ->and($attributes)->toHaveKey('boundaries.vertices', lang('igniter.local::default.label_area_vertices'))
        ->and($attributes)->toHaveKey('boundaries.distance.*.type', lang('igniter.local::default.label_area_distance'))
        ->and($attributes)->toHaveKey('boundaries.distance.*.distance', lang('igniter.local::default.label_area_distance'))
        ->and($attributes)->toHaveKey('boundaries.distance.*.charge', lang('igniter.local::default.label_area_charge'))
        ->and($attributes)->toHaveKey('conditions', lang('igniter.local::default.label_delivery_condition'))
        ->and($attributes)->toHaveKey('conditions.*.amount', lang('igniter.local::default.label_area_charge'))
        ->and($attributes)->toHaveKey('conditions.*.type', lang('igniter.local::default.label_charge_condition'))
        ->and($attributes)->toHaveKey('conditions.*.total', lang('igniter.local::default.label_area_min_amount'));
});

it('returns correct validation rules', function(): void {
    $rules = (new LocationAreaRequest)->rules();

    expect($rules)->toHaveKey('type', ['sometimes', 'required', 'string'])
        ->and($rules)->toHaveKey('name', ['sometimes', 'required', 'string'])
        ->and($rules)->toHaveKey('is_default', ['sometimes', 'required', 'boolean'])
        ->and($rules)->toHaveKey('area_id', ['integer'])
        ->and($rules)->toHaveKey('color', ['sometimes', 'nullable', 'string'])
        ->and($rules)->toHaveKey('boundaries.components', ['sometimes', 'required_if:type,address', 'array'])
        ->and($rules)->toHaveKey('boundaries.components.*.type', ['sometimes', 'required', 'string'])
        ->and($rules)->toHaveKey('boundaries.components.*.value', ['sometimes', 'required', 'string'])
        ->and($rules)->toHaveKey('boundaries.polygon', ['sometimes', 'required_if:type,polygon'])
        ->and($rules)->toHaveKey('boundaries.circle', ['nullable', 'required_if:type,circle', 'json'])
        ->and($rules)->toHaveKey('boundaries.vertices', ['nullable', 'required_unless:type,address', 'json'])
        ->and($rules)->toHaveKey('boundaries.distance.*.type', ['sometimes', 'required', 'string'])
        ->and($rules)->toHaveKey('boundaries.distance.*.distance', ['sometimes', 'required', 'numeric'])
        ->and($rules)->toHaveKey('boundaries.distance.*.charge', ['sometimes', 'required', 'numeric'])
        ->and($rules)->toHaveKey('conditions', ['sometimes', 'array'])
        ->and($rules)->toHaveKey('conditions.*.amount', ['sometimes', 'required', 'numeric'])
        ->and($rules)->toHaveKey('conditions.*.type', ['sometimes', 'required', 'alpha_dash'])
        ->and($rules)->toHaveKey('conditions.*.total', ['sometimes', 'required', 'numeric']);
});
