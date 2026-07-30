<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\ReservationRequest;

it('returns correct attribute labels for reservation', function(): void {
    $attributes = (new ReservationRequest)->attributes();

    expect($attributes['location_id'])->toBe(lang('igniter.reservation::default.text_restaurant'))
        ->and($attributes['first_name'])->toBe(lang('igniter.reservation::default.label_first_name'))
        ->and($attributes['last_name'])->toBe(lang('igniter.reservation::default.label_last_name'))
        ->and($attributes['email'])->toBe(lang('igniter::admin.label_email'))
        ->and($attributes['telephone'])->toBe(lang('igniter.reservation::default.label_customer_telephone'))
        ->and($attributes['reserve_date'])->toBe(lang('igniter.reservation::default.label_reservation_date'))
        ->and($attributes['reserve_time'])->toBe(lang('igniter.reservation::default.label_reservation_time'))
        ->and($attributes['guest_num'])->toBe(lang('igniter.reservation::default.label_guest'))
        ->and($attributes['comment'])->toBe(lang('igniter.reservation::default.column_comment'));
});

it('validates rules correctly for reservation', function(): void {
    $rules = (new ReservationRequest)->rules();

    expect($rules['location_id'])->toBe(['sometimes', 'required', 'integer'])
        ->and($rules['customer_id'])->toBe(['nullable', 'integer'])
        ->and($rules['first_name'])->toBe(['required_without:customer_id', 'nullable', 'string', 'between:1,48'])
        ->and($rules['last_name'])->toBe(['required_without:customer_id', 'nullable', 'string', 'between:1,48'])
        ->and($rules['email'])->toBe(['required_without:customer_id', 'nullable', 'email:filter', 'max:96'])
        ->and($rules['telephone'])->toBe(['required_without:customer_id', 'nullable', 'sometimes', 'string'])
        ->and($rules['reserve_date'])->toBe(['required', 'date_format:Y-m-d'])
        ->and($rules['reserve_time'])->toBe(['required', 'date_format:H:i'])
        ->and($rules['guest_num'])->toBe(['required', 'integer'])
        ->and($rules['duration'])->toBe(['nullable', 'integer', 'min:0'])
        ->and($rules['tables'])->toBe(['nullable', 'array'])
        ->and($rules['comment'])->toBe(['nullable', 'string']);
});
