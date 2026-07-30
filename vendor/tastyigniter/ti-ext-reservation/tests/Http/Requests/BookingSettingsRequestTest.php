<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\BookingSettingsRequest;

it('returns correct attribute labels', function(): void {
    $attributes = (new BookingSettingsRequest)->attributes();

    expect($attributes['is_enabled'])->toBe(lang('igniter.reservation::default.offer_reservation'))
        ->and($attributes['limit_guests'])->toBe(lang('igniter.reservation::default.label_limit_guests'))
        ->and($attributes['limit_guests_count'])->toBe(lang('igniter.reservation::default.label_limit_guests_count'))
        ->and($attributes['time_interval'])->toBe(lang('igniter.reservation::default.label_reservation_time_interval'))
        ->and($attributes['stay_time'])->toBe(lang('igniter.reservation::default.reservation_stay_time'))
        ->and($attributes['auto_allocate_table'])->toBe(lang('igniter.reservation::default.label_auto_allocate_table'))
        ->and($attributes['min_guest_count'])->toBe(lang('igniter.reservation::default.label_min_reservation_guest_num'))
        ->and($attributes['max_guest_count'])->toBe(lang('igniter.reservation::default.label_max_reservation_guest_num'))
        ->and($attributes['min_advance_time'])->toBe(lang('igniter.reservation::default.label_min_reservation_advance_time'))
        ->and($attributes['max_advance_time'])->toBe(lang('igniter.reservation::default.label_max_reservation_advance_time'))
        ->and($attributes['cancellation_timeout'])->toBe(lang('igniter.reservation::default.label_reservation_cancellation_timeout'));
});

it('validates rules correctly', function(): void {
    $rules = (new BookingSettingsRequest)->rules();

    expect($rules['is_enabled'])->toBe(['boolean'])
        ->and($rules['limit_guests'])->toBe(['boolean'])
        ->and($rules['limit_guests_count'])->toBe(['integer', 'min:1', 'max:999'])
        ->and($rules['time_interval'])->toBe(['min:5', 'integer'])
        ->and($rules['stay_time'])->toBe(['min:5', 'integer'])
        ->and($rules['auto_allocate_table'])->toBe(['integer'])
        ->and($rules['min_guest_count'])->toBe(['nullable', 'integer', 'min:0', 'max:999'])
        ->and($rules['max_guest_count'])->toBe(['nullable', 'integer', 'min:0', 'max:999'])
        ->and($rules['min_advance_time'])->toBe(['nullable', 'integer', 'min:0', 'max:999'])
        ->and($rules['max_advance_time'])->toBe(['nullable', 'integer', 'min:0', 'max:999'])
        ->and($rules['cancellation_timeout'])->toBe(['nullable', 'integer', 'min:0', 'max:999']);
});
