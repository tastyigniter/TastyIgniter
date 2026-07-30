<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models\Observers;

use Igniter\User\Models\Observers\UserObserver;
use Igniter\User\Models\User;
use Mockery;

it('detaches groups and locations on deleting', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('groups->detach')->once();
    $user->shouldReceive('locations->detach')->once();

    $observer = new UserObserver;
    $observer->deleting($user);
});

it('restores purged values on saved', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('restorePurgedValues')->once();
    $user->exists = true;

    $observer = new UserObserver;
    $observer->saved($user);
});

it('completes activation if status is true and is_activated is null', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->status = true;
    $user->is_activated = null;
    $user->shouldReceive('completeActivation')->with(Mockery::type('string'))->once();
    $user->exists = true;

    $observer = new UserObserver;
    $observer->saved($user);
});
