<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Carbon\Carbon;
use Igniter\Cart\Models\MenuSpecial;

it('returns all days of the week for recurring options', function(): void {
    $result = MenuSpecial::getRecurringEveryOptions();

    expect($result)->toBeArray()
        ->and($result)->toContain('Sun')
        ->and($result)->toContain('Mon')
        ->and($result)->toContain('Tue')
        ->and($result)->toContain('Wed')
        ->and($result)->toContain('Thu')
        ->and($result)->toContain('Fri')
        ->and($result)->toContain('Sat');
});

it('returns null for pretty end date when special is recurring', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'recurring',
    ]);

    $result = $menuSpecial->getPrettyEndDateAttribute();

    expect($result)->toBeNull();
});

it('returns null for pretty end date when end date is not set', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'period',
    ]);

    $result = $menuSpecial->getPrettyEndDateAttribute();

    expect($result)->toBeNull();
});

it('returns formatted pretty end date when special is not recurring and end date is set', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'period',
        'end_date' => Carbon::parse('2023-12-31 23:59:59'),
    ]);

    $result = $menuSpecial->getPrettyEndDateAttribute();

    expect($result)->toBe('31 Dec 2023 23:59');
});

it('returns provided value when type attribute is not empty', function(): void {
    $menuSpecial1 = MenuSpecial::factory()->create([
        'type' => '',
    ]);
    $menuSpecial2 = MenuSpecial::factory()->create([
        'type' => 'P',
    ]);

    expect($menuSpecial1->type)->toBe('F')
        ->and($menuSpecial2->type)->toBe('P');
});

it('returns provided value when validity attribute is not empty', function(): void {
    $menuSpecial1 = MenuSpecial::factory()->create([
        'validity' => '',
    ]);
    $menuSpecial2 = MenuSpecial::factory()->create([
        'validity' => 'period',
    ]);

    expect($menuSpecial1->validity)->toBe('forever')
        ->and($menuSpecial2->validity)->toBe('period');
});

it('checks if menu special is active', function(): void {
    $menuSpecial = MenuSpecial::factory()->create();

    expect($menuSpecial->active())->toBeTrue();
});

it('checks if menu special is not active', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'special_status' => 0,
    ]);

    expect($menuSpecial->active())->toBeFalse();
});

it('checks if menu special is recurring', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'recurring',
    ]);

    expect($menuSpecial->isRecurring())->toBeTrue();
});

it('checks if menu special is not recurring', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'forever',
    ]);

    expect($menuSpecial->isRecurring())->toBeFalse();
});

it('checks if period menu special is expired', function(): void {
    $this->travelTo(now()->setTimeFromTimeString('09:00'));
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'period',
        'start_date' => now()->subDays(4),
        'end_date' => now()->subDay(),
    ]);

    expect($menuSpecial->isExpired())->toBeTrue();

    $this->travelTo(now()->subDay()->setTimeFromTimeString('09:00'));

    expect($menuSpecial->isExpired())->toBeFalse();
});

it('checks if recurring menu special is expired', function(): void {
    $this->travelTo(now()->weekday(2)->setTimeFromTimeString('09:00'));

    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'recurring',
        'recurring_every' => [0, 1, 2, 3, 6],
        'recurring_from' => '10:00',
        'recurring_to' => '20:00',
    ]);

    expect($menuSpecial->isExpired())->toBeTrue();

    $this->travelTo(now()->weekday(5)->setTimeFromTimeString('11:00'));

    expect($menuSpecial->isExpired())->toBeTrue();
});

it('checks if menu special price is fixed amount', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'type' => 'F',
    ]);

    expect($menuSpecial->isFixed())->toBeTrue();
});

it('checks if menu special price is percentage', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'type' => 'P',
    ]);

    expect($menuSpecial->isFixed())->toBeFalse();
});

it('checks if menu special price is calculated correctly for fixed type', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'type' => 'F',
        'special_price' => 10.00,
    ]);

    expect($menuSpecial->getMenuPrice(20.00))->toBe(10.00);
});

it('checks if menu special price is calculated correctly for percentage type', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'type' => 'P',
        'special_price' => 10.00,
    ]);

    expect($menuSpecial->getMenuPrice(20.00))->toBe(18.00);
});

it('checks if days remaining for menu special is calculated correctly', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'period',
        'start_date' => now()->subDays(4),
        'end_date' => now()->addDays(5),
    ]);

    expect($menuSpecial->daysRemaining())->toContain('4 days');
});

it('checks if days remaining for menu special is zero when expired', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'period',
        'start_date' => now()->subDays(4),
        'end_date' => now()->subDay(),
    ]);

    expect($menuSpecial->daysRemaining())->toBe(0);
});

it('checks if days remaining for menu special is zero when validity is not period', function(): void {
    $menuSpecial = MenuSpecial::factory()->create([
        'validity' => 'forever',
    ]);

    expect($menuSpecial->daysRemaining())->toBe(0);
});

it('configures menu special model correctly', function(): void {
    $menuSpecial = new MenuSpecial;

    expect($menuSpecial->getTable())->toBe('menus_specials')
        ->and($menuSpecial->getKeyName())->toBe('special_id')
        ->and($menuSpecial->getFillable())->toEqual([
            'menu_id', 'start_date',
            'end_date', 'special_price', 'type',
            'validity', 'recurring_every',
            'recurring_from', 'recurring_to',
        ])
        ->and($menuSpecial->getMorphClass())->toBe('menus_specials');
});
