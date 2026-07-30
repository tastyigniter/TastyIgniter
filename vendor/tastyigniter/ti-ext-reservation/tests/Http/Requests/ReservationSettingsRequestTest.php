<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\ReservationSettingsRequest;

it('returns correct attribute labels for reservation settings', function(): void {
    $attributes = (new ReservationSettingsRequest)->attributes();

    expect($attributes['default_reservation_status'])->toBe(lang('igniter.reservation::default.label_default_reservation_status'))
        ->and($attributes['confirmed_reservation_status'])->toBe(lang('igniter.reservation::default.label_confirmed_reservation_status'))
        ->and($attributes['canceled_reservation_status'])->toBe(lang('igniter.reservation::default.label_canceled_reservation_status'));
});

it('validates rules correctly for reservation settings', function(): void {
    $rules = (new ReservationSettingsRequest)->rules();

    expect($rules['reservation_email.*'])->toBe(['required', 'alpha'])
        ->and($rules['default_reservation_status'])->toBe(['required', 'integer'])
        ->and($rules['confirmed_reservation_status'])->toBe(['required', 'integer'])
        ->and($rules['canceled_reservation_status'])->toBe(['required', 'integer']);
});
