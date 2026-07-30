<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Classes;

use Carbon\Carbon;
use Igniter\User\Classes\UserState;
use Igniter\User\Models\User;

use function Pest\Laravel\actingAs;

it('returns true when user is away', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::AWAY_STATUS, '', 0);

    expect($userState->isAway())->toBeTrue()
        ->and($userState->isOnline())->toBeFalse()
        ->and($userState->isIdle())->toBeFalse();
});

it('returns false when user is online', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::ONLINE_STATUS, '', 0);

    expect($userState->isAway())->toBeFalse()
        ->and($userState->isOnline())->toBeTrue()
        ->and($userState->isIdle())->toBeFalse();
});

it('returns true when user is idle', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::BACK_SOON_STATUS, '', 0);

    expect($userState->isOnline())->toBeFalse()
        ->and($userState->isIdle())->toBeTrue();
});

it('returns true when user has custom status', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::CUSTOM_STATUS, '', 0);

    expect($userState->isAway())->toBeTrue();
});

it('returns false when user has custom status', function(): void {
    $userState = UserState::forUser();

    expect($userState->isAway())->toBeFalse();
});

it('returns correct status name for custom status', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::CUSTOM_STATUS, 'Busy', 0);

    expect($userState->getStatusName())->toBe('Busy');
});

it('returns correct status name for predefined status', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::BACK_SOON_STATUS, '', 0);

    expect($userState->getStatusName())->toBe('igniter.user::default.staff_status.text_back_soon');
});

it('returns correct clear after time for custom status', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $this->travelTo('2021-01-01 12:00:00');
    $userState = UserState::forUser();
    $userState->updateState(UserState::CUSTOM_STATUS, 'Busy', 30);

    $clearAfterAt = $userState->getClearAfterAt();

    expect($clearAfterAt)->not->toBeNull()
        ->and((int)now()->diffInMinutes($clearAfterAt))->toBe(30);
});

it('returns null clear after time for non-custom status', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::ONLINE_STATUS, '', 30);

    expect($userState->getClearAfterAt())->toBeNull();
});

it('returns updated at time when set', function(): void {
    actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $userState = UserState::forUser();
    $userState->updateState(UserState::ONLINE_STATUS, '', 0);

    $updatedAt = $userState->getUpdatedAt();

    expect($updatedAt)->not->toBeNull()
        ->and($updatedAt)->toBeInstanceOf(Carbon::class);
});

it('returns null when updated at time is not set', function(): void {
    $userState = UserState::forUser();

    $updatedAt = $userState->getUpdatedAt();

    expect($updatedAt)->toBeNull();
});

it('returns correct clear after minutes dropdown options', function(): void {
    $options = UserState::getClearAfterMinutesDropdownOptions();

    expect($options)->toBe([
        1440 => 'igniter.user::default.staff_status.text_clear_tomorrow',
        240 => 'igniter.user::default.staff_status.text_clear_hours',
        30 => 'igniter.user::default.staff_status.text_clear_minutes',
        0 => 'igniter.user::default.staff_status.text_dont_clear',
    ]);
});
