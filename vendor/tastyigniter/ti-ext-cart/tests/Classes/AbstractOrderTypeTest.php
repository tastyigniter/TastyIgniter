<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Classes;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Models\Location;
use Mockery;

beforeEach(function(): void {
    $this->location = Mockery::mock(Location::class)->makePartial();
    $this->orderType = new class($this->location, ['code' => 'test', 'name' => 'Test']) extends AbstractOrderType
    {
        public function getOpenDescription(): string
        {
            // TODO: Implement getOpenDescription() method.
        }

        public function getOpeningDescription(string $format): string
        {
            // TODO: Implement getOpeningDescription() method.
        }

        public function getClosedDescription(): string
        {
            // TODO: Implement getClosedDescription() method.
        }

        public function getDisabledDescription(): string
        {
            // TODO: Implement getDisabledDescription() method.
        }

        public function isActive(): bool
        {
            // TODO: Implement isActive() method.
        }

        public function isDisabled(): bool
        {
            // TODO: Implement isDisabled() method.
        }
    };
});

it('gets code', function(): void {
    expect($this->orderType->getCode())->toBe('test');
});

it('gets label', function(): void {
    expect($this->orderType->getLabel())->toBe('Test');
});

it('gets interval', function(): void {
    $this->location->shouldReceive('getOrderTimeInterval')->with('test')->andReturn(15);

    expect($this->orderType->getInterval())->toBe(15);
});

it('gets lead time', function(): void {
    $this->location->shouldReceive('getOrderLeadTime')->with('test')->andReturn(15);

    expect($this->orderType->getLeadTime())->toBe(15);
});

it('gets future days', function(): void {
    $this->location->shouldReceive('hasFutureOrder')->with('test')->andReturn(false, true);

    expect($this->orderType->getFutureDays())->toBe(0);

    $this->location->shouldReceive('futureOrderDays')->with('test')->andReturn(15);

    expect($this->orderType->getFutureDays())->toBe(15);
});

it('gets minimum future days', function(): void {
    $this->location->shouldReceive('hasFutureOrder')->with('test')->andReturn(false, true);
    expect($this->orderType->getMinimumFutureDays())->toBe(0);

    $this->location->shouldReceive('minimumFutureOrderDays')->with('test')->andReturn(15);

    expect($this->orderType->getMinimumFutureDays())->toBe(15);
});

it('gets minimum order total', function(): void {
    $this->location->shouldReceive('getMinimumOrderTotal')->with('test')->andReturn(15.0);

    expect($this->orderType->getMinimumOrderTotal())->toBe(15.0);
});

it('gets schedule', function(): void {
    $this->location->shouldReceive('hasFutureOrder')->with('test')->andReturn(true);
    $this->location->shouldReceive('minimumFutureOrderDays')->with('test')->andReturn(3);
    $this->location->shouldReceive('futureOrderDays')->with('test')->andReturn(30);
    $this->location->shouldReceive('newWorkingSchedule')->with('test', [3, 30])->andReturn(new WorkingSchedule);

    expect($this->orderType->getSchedule())->toBeInstanceOf(WorkingSchedule::class);
});

it('gets schedule restriction', function(): void {
    $this->location->shouldReceive('getSettings')->with('checkout.limit_orders')->andReturn(true, false, false);
    expect($this->orderType->getScheduleRestriction())->toBe(AbstractOrderType::LATER_ONLY);

    $this->location->shouldReceive('hasFutureOrder')->with('test')->andReturn(true, false);
    expect($this->orderType->getScheduleRestriction())->toBe(0);

    $this->location->shouldReceive('getOrderTimeRestriction')->with('test')->andReturn(60);
    expect($this->orderType->getScheduleRestriction())->toBe(60);
});
