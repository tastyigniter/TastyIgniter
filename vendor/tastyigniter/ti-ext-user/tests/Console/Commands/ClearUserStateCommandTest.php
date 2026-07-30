<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Console\Commands;

use Igniter\User\Classes\UserState;
use Igniter\User\Models\UserPreference;

it('clears expired custom away status', function(): void {
    $preference = UserPreference::create([
        'item' => UserState::USER_PREFERENCE_KEY,
        'value' => [
            'status' => UserState::CUSTOM_STATUS,
            'clearAfterMinutes' => 10,
            'updatedAt' => now()->subMinutes(15)->toDateTimeString(),
        ],
    ]);

    $this->artisan('igniter:user-state-clear');
    $preference->refresh();

    expect($preference->value)->toBe([
        'status' => UserState::ONLINE_STATUS,
        'awayMessage' => null,
        'updatedAt' => null,
        'clearAfterMinutes' => 0,
    ]);
});

it('does not clear non-expired custom away status', function(): void {
    $preference = UserPreference::create([
        'item' => UserState::USER_PREFERENCE_KEY,
        'value' => [
            'status' => UserState::CUSTOM_STATUS,
            'clearAfterMinutes' => 10,
            'updatedAt' => now()->subMinutes(5)->toDateTimeString(),
        ],
    ]);

    $this->artisan('igniter:user-state-clear');

    $preference->refresh();
    expect($preference->value)->not->toBe([
        'status' => 1,
        'awayMessage' => null,
        'updatedAt' => null,
        'clearAfterMinutes' => 0,
    ]);
});

it('does not clear status with clearAfterMinutes set to zero', function(): void {
    $preference = UserPreference::create([
        'item' => UserState::USER_PREFERENCE_KEY,
        'value' => [
            'status' => UserState::CUSTOM_STATUS,
            'clearAfterMinutes' => 0,
            'updatedAt' => null,
        ],
    ]);

    $this->artisan('igniter:user-state-clear');

    $preference->refresh();
    expect($preference->value)->not->toBe([
        'status' => 1,
        'awayMessage' => null,
        'updatedAt' => null,
        'clearAfterMinutes' => 0,
    ]);
});
