<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Listeners;

use Igniter\Reservation\Listeners\RegistersDashboardCards;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Reservation;

it('returns correct dashboard cards configuration', function(): void {
    $cards = (new RegistersDashboardCards)();

    expect($cards)->toHaveKeys(['reserved_table', 'reserved_guest', 'reservation', 'completed_reservation'])
        ->and($cards['reserved_table']['label'])->toBe('lang:igniter.reservation::default.text_total_reserved_table')
        ->and($cards['reserved_guest']['label'])->toBe('lang:igniter.reservation::default.text_total_reserved_guest')
        ->and($cards['reservation']['label'])->toBe('lang:igniter.reservation::default.text_total_reservation')
        ->and($cards['completed_reservation']['label'])->toBe('lang:igniter.reservation::default.text_total_completed_reservation');
});

it('returns total reserved table sum', function(): void {
    setting()->set(['confirmed_reservation_status' => 1]);

    Reservation::factory()
        ->count(5)
        ->has(DiningTable::factory()->count(5), 'tables')
        ->create([
            'status_id' => 1,
        ]);

    $result = (new RegistersDashboardCards)->getValue('reserved_table', null, null, fn($query) => $query);

    expect($result)->toBe(5);
});

it('returns total reserved guest sum', function(): void {
    setting()->set(['confirmed_reservation_status' => 1]);

    Reservation::factory()->create([
        'status_id' => 1,
        'guest_num' => 20,
    ]);

    $result = (new RegistersDashboardCards)->getValue('reserved_guest', null, null, fn($query) => $query);

    expect($result)->toBe(20);
});

it('returns total reservation sum', function(): void {
    Reservation::factory()->count(10)->create(['status_id' => 1]);

    $result = (new RegistersDashboardCards)->getValue('reservation', null, null, fn($query) => $query);

    expect($result)->toBe(10);
});

it('returns total completed reservation sum', function(): void {
    setting()->set(['confirmed_reservation_status' => 1]);

    Reservation::factory()->count(8)->create(['status_id' => 1]);

    $result = (new RegistersDashboardCards)->getValue('completed_reservation', null, null, fn($query) => $query);

    expect($result)->toBe(8);
});
