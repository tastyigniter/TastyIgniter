<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Socialite\Models\Provider;
use Igniter\User\Models\User;
use Mockery;

it('applies user correctly', function(): void {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('getMorphClass')->andReturn('UserClass');

    $provider = new Provider;
    $provider->applyUser($user);

    expect($provider->user_id)->toBe(1)
        ->and($provider->user_type)->toBe('UserClass');
});

it('scopes query by user correctly', function(): void {
    $user = Mockery::mock('User');
    $user->shouldReceive('getKey')->andReturn(1)->once();
    $user->shouldReceive('getMorphClass')->andReturn('UserClass')->once();

    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('where')->with('user_id', 1)->andReturnSelf()->once();
    $query->shouldReceive('where')->with('user_type', 'UserClass')->andReturnSelf()->once();

    $provider = new Provider;
    $provider->scopeWhereUser($query, $user);
});

it('configures provider model correctly', function(): void {
    $provider = new Provider;

    expect($provider->table)->toBe('igniter_socialite_providers')
        ->and($provider->getFillable())->toBe(['user_type', 'user_id', 'provider', 'provider_id', 'token'])
        ->and($provider->relation)->toBe(['morphTo' => ['user' => []]]);
});
