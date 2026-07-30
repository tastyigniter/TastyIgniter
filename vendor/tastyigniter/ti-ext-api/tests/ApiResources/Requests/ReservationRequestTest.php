<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\ReservationRequest;

it('returns correct attribute labels', function(): void {
    $request = new ReservationRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('table_id', lang('igniter.reservation::default.column_table'))
        ->and($attributes)->toHaveKey('location_id', lang('igniter.reservation::default.label_location'))
        ->and($attributes)->toHaveKey('guest_num', lang('igniter.reservation::default.label_guest_num'))
        ->and($attributes)->toHaveKey('reserve_date', lang('igniter.reservation::default.label_date'))
        ->and($attributes)->toHaveKey('reserve_time', lang('igniter.reservation::default.label_time'))
        ->and($attributes)->toHaveKey('first_name', lang('igniter.reservation::default.label_first_name'))
        ->and($attributes)->toHaveKey('last_name', lang('igniter.reservation::default.label_last_name'))
        ->and($attributes)->toHaveKey('email', lang('igniter.reservation::default.label_email'))
        ->and($attributes)->toHaveKey('telephone', lang('igniter.reservation::default.label_telephone'))
        ->and($attributes)->toHaveKey('comment', lang('igniter.reservation::default.label_comment'));
});

it('returns correct validation rules', function(): void {
    $request = new ReservationRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('table_id')
        ->and($rules)->toHaveKey('location_id')
        ->and($rules)->toHaveKey('guest_num')
        ->and($rules)->toHaveKey('reserve_date')
        ->and($rules)->toHaveKey('reserve_time')
        ->and($rules)->toHaveKey('first_name')
        ->and($rules)->toHaveKey('last_name')
        ->and($rules)->toHaveKey('email')
        ->and($rules)->toHaveKey('telephone')
        ->and($rules)->toHaveKey('comment')
        ->and($rules['table_id'])->toContain('sometimes', 'required', 'integer')
        ->and($rules['location_id'])->toContain('required', 'integer')
        ->and($rules['guest_num'])->toContain('required', 'integer')
        ->and($rules['reserve_date'])->toContain('required', 'date_format:Y-m-d')
        ->and($rules['reserve_time'])->toContain('required', 'date_format:H:i')
        ->and($rules['first_name'])->toContain('required', 'between:1,48')
        ->and($rules['last_name'])->toContain('required', 'between:1,48')
        ->and($rules['email'])->toContain('required', 'email:filter', 'max:96')
        ->and($rules['telephone'])->toContain('required')
        ->and($rules['comment'])->toContain('max:520');
});
