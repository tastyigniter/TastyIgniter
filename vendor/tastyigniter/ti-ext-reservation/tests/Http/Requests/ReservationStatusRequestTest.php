<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\ReservationStatusRequest;

it('returns correct attribute labels for reservation status', function(): void {
    $attributes = (new ReservationStatusRequest)->attributes();

    expect($attributes['status_id'])->toBe(lang('igniter::admin.label_status'))
        ->and($attributes['comment'])->toBe(lang('igniter::admin.statuses.label_comment'))
        ->and($attributes['notify'])->toBe(lang('igniter::admin.statuses.label_notify'))
        ->and($attributes['assignee_group_id'])->toBe(lang('igniter::admin.statuses.label_assignee_group'))
        ->and($attributes['assignee_id'])->toBe(lang('igniter::admin.statuses.label_assignee'));
});

it('validates rules correctly for reservation status', function(): void {
    $rules = (new ReservationStatusRequest)->rules();

    expect($rules['status_id'])->toBe(['sometimes', 'required', 'integer', 'exists:statuses'])
        ->and($rules['comment'])->toBe(['string', 'max:1500'])
        ->and($rules['notify'])->toBe(['sometimes', 'required', 'boolean'])
        ->and($rules['assignee_group_id'])->toBe(['sometimes', 'required', 'integer', 'exists:admin_user_groups,user_group_id'])
        ->and($rules['assignee_id'])->toBe(['integer', 'exists:admin_users,user_id']);
});
