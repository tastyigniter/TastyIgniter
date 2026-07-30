<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\Flame\Exception\SystemException;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Igniter\User\Models\UserPreference;
use Mockery;
use ReflectionClass;

function setCachePropertyValue(UserPreference $userPreference, array $value): void
{
    $reflection = new ReflectionClass($userPreference);
    $property = $reflection->getProperty('cache');
    $property->setValue($userPreference, $value);
}

function getCachePropertyValue(UserPreference $userPreference): array
{
    $reflection = new ReflectionClass($userPreference);
    $property = $reflection->getProperty('cache');

    return $property->getValue($userPreference);
}

it('returns default value if user is not set', function(): void {
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = null;

    $result = $userPreference->get('theme', 'default');

    expect($result)->toBe('default');
});

it('returns cached value if available', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->user_id = 1;
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = $user;
    setCachePropertyValue($userPreference, ['1-theme' => 'dark']);

    $result = $userPreference->get('theme', 'default');

    expect($result)->toBe('dark');
});

it('returns value from database if not cached', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->user_id = 1;
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = $user;
    $userPreference->shouldReceive('findRecord')->with('theme', $user)->andReturn((object)['value' => 'dark']);
    setCachePropertyValue($userPreference, []);

    $result = $userPreference->get('theme', 'default');

    expect($result)->toBe('dark');
});

it('sets returns default when no user', function(): void {
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = null;

    expect($userPreference->set('theme', 'dark'))->toBeFalse();
});

it('sets and caches the value', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->user_id = 1;
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = $user;
    $userPreference->shouldReceive('findRecord')->with('theme', $user)->andReturnSelf();
    $userPreference->shouldReceive('save')->andReturnTrue();

    $result = $userPreference->set('theme', 'dark');
    $userPreferenceCache = getCachePropertyValue($userPreference);

    expect($result)->toBeTrue()->and($userPreferenceCache['1-theme'])->toBe('dark');
});

it('resets returns false when no user', function(): void {
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = null;

    expect($userPreference->reset('theme'))->toBeFalse();
});

it('resets returns false when no record', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->user_id = 1;
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = $user;
    $userPreference->shouldReceive('findRecord')->with('theme', $user)->andReturnNull();

    expect($userPreference->reset('theme'))->toBeFalse();
});

it('resets the value and removes from cache', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->user_id = 1;
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();
    $userPreference->userContext = $user;
    $userPreference->shouldReceive('findRecord')->with('theme', $user)->andReturnSelf();
    setCachePropertyValue($userPreference, ['1-theme' => 'dark']);

    $result = $userPreference->reset('theme');
    $userPreferenceCache = getCachePropertyValue($userPreference);

    expect($result)->toBeTrue()
        ->and(array_key_exists('1-theme', $userPreferenceCache))->toBeFalse();
});

it('returns user if logged in', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    AdminAuth::shouldReceive('getUser')->andReturn($user);
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();

    $result = $userPreference->resolveUser();

    expect($result)->toBe($user);
});

it('throws exception if user is not logged in', function(): void {
    AdminAuth::shouldReceive('getUser')->andReturn(null);
    $userPreference = Mockery::mock(UserPreference::class)->makePartial();

    $this->expectException(SystemException::class);
    $this->expectExceptionMessage('User is not logged in');

    $userPreference->resolveUser();
});
