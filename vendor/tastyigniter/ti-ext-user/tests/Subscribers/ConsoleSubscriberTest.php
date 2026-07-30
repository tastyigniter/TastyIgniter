<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Subscribers;

use Igniter\User\Subscribers\ConsoleSubscriber;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Mockery;

it('subscribes to console.schedule event', function(): void {
    $subscriber = new ConsoleSubscriber;
    $events = Mockery::mock(Dispatcher::class);

    $result = $subscriber->subscribe($events);

    expect($result)->toBe(['console.schedule' => 'defineSchedule']);
});

it('defines schedule for assignables allocation and clearing user state', function(): void {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('command')->with('igniter:assignable-allocate')->andReturnSelf()->once();
    $schedule->shouldReceive('name')->with('Assignables Allocator')->andReturnSelf()->once();
    $schedule->shouldReceive('withoutOverlapping')->with(5)->andReturnSelf();
    $schedule->shouldReceive('runInBackground')->andReturnSelf();
    $schedule->shouldReceive('everyMinute')->andReturnSelf();
    $schedule->shouldReceive('command')->with('igniter:user-state-clear')->andReturnSelf()->once();
    $schedule->shouldReceive('name')->with('Clear user custom away status')->andReturnSelf()->once();
    $schedule->shouldReceive('withoutOverlapping')->with(5)->andReturnSelf();
    $schedule->shouldReceive('runInBackground')->andReturnSelf();
    $schedule->shouldReceive('everyMinute')->andReturnSelf();

    $subscriber = new ConsoleSubscriber;
    $subscriber->defineSchedule($schedule);
});
