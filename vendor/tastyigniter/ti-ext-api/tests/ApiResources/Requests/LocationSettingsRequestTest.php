<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\LocationSettingsRequest;

it('returns correct attribute labels', function(): void {
    $request = new LocationSettingsRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('location_id', lang('igniter.local::default.label_location_id'));
});

it('returns correct validation rules', function(): void {
    $request = new LocationSettingsRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('location_id')
        ->and($rules)->toHaveKey('item')
        ->and($rules)->toHaveKey('data')
        ->and($rules['location_id'])->toContain('required', 'integer')
        ->and($rules['item'])->toContain('required', 'string')
        ->and($rules['data'])->toContain('required', 'array');
});

it('validates location_id is required', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['location_id'])->toContain('required');
});

it('validates location_id is integer', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['location_id'])->toContain('integer');
});

it('validates item is required', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['item'])->toContain('required');
});

it('validates item is string', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['item'])->toContain('string');
});

it('validates data is required', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['data'])->toContain('required');
});

it('validates data is array', function(): void {
    $request = new LocationSettingsRequest;
    $request->setMethod('POST');

    $rules = $request->rules();

    expect($rules['data'])->toContain('array');
});
