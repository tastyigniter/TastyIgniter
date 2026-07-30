<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Http\Requests;

use Igniter\Api\Http\Requests\ResourceRequest;

it('returns correct attribute labels', function(): void {
    $request = new ResourceRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('name', lang('igniter.api::default.label_name'))
        ->and($attributes)->toHaveKey('description', lang('igniter.api::default.label_description'))
        ->and($attributes)->toHaveKey('endpoint', lang('igniter.api::default.label_endpoint'))
        ->and($attributes)->toHaveKey('meta.actions', lang('igniter.api::default.label_actions'))
        ->and($attributes)->toHaveKey('meta.authorization', lang('igniter.api::default.label_authorization'));
});

it('returns correct validation rules', function(): void {
    $request = new ResourceRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('name')
        ->and($rules)->toHaveKey('description')
        ->and($rules)->toHaveKey('endpoint')
        ->and($rules)->toHaveKey('meta')
        ->and($rules)->toHaveKey('meta.actions.*')
        ->and($rules)->toHaveKey('meta.authorization.*')
        ->and($rules['name'])->toContain('required', 'min:2', 'max:128', 'string')
        ->and($rules['description'])->toContain('required', 'min:2', 'max:255')
        ->and($rules['endpoint'])->toContain('max:255', 'regex:/^[a-z0-9\-_\/]+$/i', 'unique:igniter_api_resources,endpoint,')
        ->and($rules['meta'])->toContain('array')
        ->and($rules['meta.actions.*'])->toContain('alpha')
        ->and($rules['meta.authorization.*'])->toContain('alpha');
});
