<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Notifications;

use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Reservation;
use Igniter\Reservation\Notifications\ReservationCreatedNotification;
use Igniter\User\Models\User;
use Mockery;

it('returns enabled users with location', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $subject = Mockery::mock(Reservation::class)->makePartial();
    $notification = Mockery::mock(ReservationCreatedNotification::class)->makePartial();

    $location->shouldReceive('getKey')->andReturn(1);
    $subject->location = $location;
    $notification->subject($subject);

    User::factory()->count(2)->create(['status' => true]);

    expect(count($notification->getRecipients()))->toBeGreaterThanOrEqual(2);
});

it('returns correct notification title', function(): void {
    $notification = new ReservationCreatedNotification;

    expect($notification->getTitle())->toBe(lang('igniter.reservation::default.notify_reservation_created_title'));
});

it('returns correct notification URL with subject', function(): void {
    $subject = Mockery::mock(Reservation::class);
    $notification = Mockery::mock(ReservationCreatedNotification::class)->makePartial();

    $subject->shouldReceive('getKey')->andReturn(1);
    $notification->subject($subject);

    expect($notification->getUrl())->toBe(admin_url('reservations/edit/1'));
});

it('returns correct notification URL without subject', function(): void {
    $notification = new ReservationCreatedNotification;

    expect($notification->getUrl())->toBe(admin_url('reservations'));
});

it('returns correct notification message', function(): void {
    $subject = Mockery::mock(Reservation::class)->makePartial();
    $notification = Mockery::mock(ReservationCreatedNotification::class)->makePartial();

    $subject->shouldReceive('getAttribute')->with('customer_name')->andReturn('John Doe');
    $notification->subject($subject);

    expect($notification->getMessage())->toBe(sprintf(lang('igniter.reservation::default.notify_reservation_created'), 'John Doe'));
});

it('returns correct notification icon', function(): void {
    $notification = new ReservationCreatedNotification;

    expect($notification->getIcon())->toBe('fa-chair');
});

it('returns correct notification alias', function(): void {
    $notification = new ReservationCreatedNotification;

    expect($notification->getAlias())->toBe('reservation-created');
});
