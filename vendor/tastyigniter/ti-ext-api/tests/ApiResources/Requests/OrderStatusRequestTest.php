<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\StatusRequest;

it('returns correct attribute labels', function(): void {
    $request = new StatusRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('comment', lang('igniter::admin.statuses.label_comment'))
        ->and($attributes)->toHaveKey('notify', lang('igniter::admin.statuses.label_notify_customer'));
});

it('returns correct validation rules', function(): void {
    $request = new StatusRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('status_id')
        ->and($rules)->toHaveKey('comment')
        ->and($rules)->toHaveKey('notify')
        ->and($rules['status_id'])->toContain('required', 'integer', 'exists:statuses,status_id')
        ->and($rules['comment'])->toContain('nullable', 'string', 'max:500')
        ->and($rules['notify'])->toContain('nullable', 'boolean');
});
