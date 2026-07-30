<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\OrderStatusRequest;

it('returns correct attribute labels', function(): void {
    $request = new OrderStatusRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveCount(5)
        ->and($attributes)->toHaveKey('status_id', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('comment', lang('igniter::admin.statuses.label_comment'))
        ->and($attributes)->toHaveKey('notify', lang('igniter::admin.statuses.label_notify'))
        ->and($attributes)->toHaveKey('assignee_group_id', lang('igniter::admin.statuses.label_assignee_group'))
        ->and($attributes)->toHaveKey('assignee_id', lang('igniter::admin.statuses.label_assignee'));
});

it('returns correct validation rules', function(): void {
    $request = new OrderStatusRequest;

    $rules = $request->rules();

    expect($rules)->toHaveCount(5)
        ->and($rules)->toHaveKey('status_id')
        ->and($rules)->toHaveKey('comment')
        ->and($rules)->toHaveKey('notify')
        ->and($rules)->toHaveKey('assignee_group_id')
        ->and($rules)->toHaveKey('assignee_id')
        ->and($rules['status_id'])->toContain('sometimes', 'required', 'integer', 'exists:statuses')
        ->and($rules['comment'])->toContain('nullable', 'string', 'max:1500')
        ->and($rules['notify'])->toContain('sometimes', 'required', 'boolean')
        ->and($rules['assignee_group_id'])->toContain('sometimes', 'required', 'integer', 'exists:admin_user_groups,user_group_id')
        ->and($rules['assignee_id'])->toContain('integer', 'exists:admin_users,user_id');
});
