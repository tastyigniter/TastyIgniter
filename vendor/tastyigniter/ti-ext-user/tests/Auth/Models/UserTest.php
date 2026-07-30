<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Auth\Models;

use Carbon\Carbon;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Relations\MorphMany;
use Igniter\Flame\Exception\SystemException;
use Igniter\User\Models\Notification;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery;

it('calls beforeLogin without errors', function(): void {
    $user = new User;
    expect($user->beforeLogin())->toBeNull();
});

it('calls afterLogin without errors', function(): void {
    $user = new User;
    expect($user->afterLogin())->toBeNull();
});

it('extends user query without errors', function(): void {
    $user = new User;
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('with')->andReturnSelf();
    $query->shouldReceive('whereIsEnabled')->andReturnSelf();
    expect($user->extendUserQuery($query))->toBeNull();
});

it('returns correct remember token name', function(): void {
    $user = new User;
    expect($user->getRememberTokenName())->toBe('remember_token');
});

it('updates remember token correctly', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('setRememberToken')->with('new_token')->once();
    $user->shouldReceive('save')->once();

    $user->updateRememberToken('new_token');
});

it('returns false when checking remember token with null token', function(): void {
    $user = new User;
    $user->remember_token = null;

    expect($user->checkRememberToken(null))->toBeFalse();
});

it('returns false when checking remember token with incorrect token', function(): void {
    $user = new User;
    $user->remember_token = 'correct_token';

    expect($user->checkRememberToken('incorrect_token'))->toBeFalse();
});

it('returns true when checking remember token with correct token', function(): void {
    $user = new User;
    $user->remember_token = 'correct_token';

    expect($user->checkRememberToken('correct_token'))->toBeTrue();
});

it('updates last seen correctly', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('newQuery->whereKey->update')->with(['last_seen' => '2023-10-10 00:00:00'])->once();

    $user->updateLastSeen('2023-10-10 00:00:00');
});

it('generates a unique reset code and sets reset time', function(): void {
    $user = Mockery::mock(User::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $user->shouldReceive('generateResetCode')->andReturn('new_reset_code');
    $user->shouldReceive('save')->once();

    $resetCode = $user->resetPassword();

    expect($resetCode)->toBe('new_reset_code')
        ->and($user->reset_code)->not->toBeNull()
        ->and($user->reset_time)->not->toBeNull();
});

it('handles reset code collision by generating a new one', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('newQuery->where->count')->andReturn(1, 1, 0);
    $user->shouldReceive('save')->once();

    $resetCode = $user->resetPassword();

    expect($resetCode)->not->toBeNull()
        ->and($user->reset_code)->toBe($resetCode);
});

it('clears reset password code and time', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->reset_code = 'some_code';
    $user->reset_time = Carbon::now();
    $user->shouldReceive('save')->once();

    $user->clearResetPasswordCode();

    expect($user->reset_code)->toBeNull()
        ->and($user->reset_time)->toBeNull();
});

it('completes reset password successfully with valid code', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('checkResetPasswordCode')->with('valid_code')->andReturn(true);
    $user->shouldReceive('save')->andReturnTrue()->once();

    $result = $user->completeResetPassword('valid_code', 'new_password');

    expect($result)->toBeTrue()
        ->and(Hash::check('new_password', $user->password))->toBeTrue()
        ->and($user->reset_code)->toBeNull()
        ->and($user->reset_time)->toBeNull();
});

it('fails to complete reset password with invalid code', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('checkResetPasswordCode')->with('invalid_code')->andReturn(false);

    $result = $user->completeResetPassword('invalid_code', 'new_password');

    expect($result)->toBeFalse();
});

it('returns true when reset code is valid and not expired', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->reset_code = 'valid_code';
    $user->reset_time = Carbon::now()->subMinutes(10);

    $result = $user->checkResetPasswordCode('valid_code');

    expect($result)->toBeTrue();
});

it('returns false when reset code is invalid', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->reset_code = 'valid_code';

    $result = $user->checkResetPasswordCode('invalid_code');

    expect($result)->toBeFalse();
});

it('returns false when reset code is expired', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->reset_code = 'valid_code';
    $user->reset_time = Carbon::now()->subMinutes(1500);
    $user->shouldReceive('clearResetPasswordCode')->once();

    $result = $user->checkResetPasswordCode('valid_code');

    expect($result)->toBeFalse();
});

it('generates a new activation code and sets activated_at to null', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('newQuery->where->count')->andReturn(0);
    $user->shouldReceive('updateQuietly')->once();

    $activationCode = $user->getActivationCode();

    expect($activationCode)->toBe($user->activation_code)
        ->and($user->activated_at)->toBeNull();
});

it('handles activation code collision by generating a new one', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('newQuery->where->count')->andReturn(1, 1, 0);
    $user->shouldReceive('updateQuietly')->once();

    $activationCode = $user->getActivationCode();

    expect($activationCode)->not->toBeNull()
        ->and($user->activation_code)->toBe($activationCode);
});

it('throws SystemException when user is already active', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->is_activated = true;

    expect(fn() => $user->completeActivation('some_code'))->toThrow(SystemException::class, 'User is already active!');
});

it('returns true when activation code is correct and user is not active', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->is_activated = false;
    $user->activation_code = 'valid_code';
    $user->shouldReceive('newQuery->update')->andReturn(true);

    $result = $user->completeActivation('valid_code');

    expect($result)->toBeTrue();
});

it('returns false when activation code is incorrect and user is not active', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->is_activated = false;
    $user->activation_code = 'valid_code';

    $result = $user->completeActivation('invalid_code');

    expect($result)->toBeFalse();
});

it('returns latest notifications', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $query = Mockery::mock(MorphMany::class);
    $query->shouldReceive('latest')->andReturnSelf();
    $user->shouldReceive('morphMany')->with(Notification::class, 'notifiable')->andReturn($query);

    $result = $user->notifications();

    expect($result)->toBe($query);
});
