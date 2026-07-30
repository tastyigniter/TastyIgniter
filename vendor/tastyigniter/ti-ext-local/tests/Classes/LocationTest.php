<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use Carbon\Carbon;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Facades\Cart;
use Igniter\Flame\Geolite\Contracts\AbstractProvider;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Distance;
use Igniter\Flame\Geolite\Model\Location as UserLocation;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\Location;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function(): void {
    $this->location = new Location;
});

afterEach(function(): void {
    $this->location->clearInternalCache();
    $this->location->resetSession();
});

it('returns location slug from resolver callback', function(): void {
    $this->location->locationSlugResolver(fn(): string => 'test-location');

    $result = $this->location->resolveLocationSlug();

    expect($result)->toBe('test-location');
});

it('returns current location when model is already set', function(): void {
    $model = mock(LocationModel::class);
    $this->location->setModel($model);

    $result = $this->location->current();

    expect($result)->toBe($model);
});

it('sets current location by slug', function(): void {
    $model = LocationModel::factory()->create(['permalink_slug' => 'test-slug']);
    $this->location->locationSlugResolver(fn(): string => 'test-slug');

    $result = $this->location->current();

    expect($result->getKey())->toBe($model->getKey());
});

it('sets current location by session id', function(): void {
    $model = LocationModel::factory()->create();
    $this->location->putSession('id', $model->getKey());

    $this->location->current();

    expect($this->location->getName())->toBe($model->location_name);
});

it('sets default location when no current location is set', function(): void {
    config(['igniter-system.locationMode' => 'single']);
    $defaultLocation = LocationModel::getDefault();

    $result = $this->location->current();

    expect($result->getKey())->toBe($defaultLocation->getKey());
});

it('returns default location in currentOrDefault', function(): void {
    $defaultLocation = LocationModel::getDefault();

    $result = $this->location->currentOrDefault();

    expect($result->getKey())->toBe($defaultLocation->getKey());
});

it('returns current location in currentOrDefault', function(): void {
    $model = mock(LocationModel::class)->makePartial();
    $this->location->setModel($model);

    $result = $this->location->currentOrDefault();

    expect($result)->toBe($model);
});

it('returns assigned location ids for non-super user in currentOrAssigned', function(): void {
    $user = mock(User::class)->makePartial();
    $user->shouldReceive('extendableGet')->with('locations')->andReturnSelf();
    $user->shouldReceive('pluck')->andReturnSelf();
    $user->shouldReceive('all')->andReturn([1, 2, 3]);
    AdminAuth::shouldReceive('isSuperUser')->andReturn(false);
    AdminAuth::shouldReceive('user')->andReturn($user);

    $result = $this->location->currentOrAssigned();

    expect($result)->toBe([1, 2, 3]);
});

it('returns empty array for super user in currentOrAssigned', function(): void {
    AdminAuth::shouldReceive('isSuperUser')->andReturn(true);

    $result = $this->location->currentOrAssigned();

    expect($result)->toBe([]);
});

it('returns current location id in currentOrAssigned', function(): void {
    $location = mock(LocationModel::class)->makePartial();
    $location->shouldReceive('getKey')->andReturn(1);
    $this->location->setCurrent($location);

    $result = $this->location->currentOrAssigned();

    expect($result)->toBe([1]);
});

it('updates order type correctly', function(): void {
    $this->location->updateOrderType(LocationModel::DELIVERY);

    expect($this->location->orderType())->toBe(LocationModel::DELIVERY);

    $this->location->updateOrderType(LocationModel::COLLECTION);

    expect($this->location->orderType())->toBe(LocationModel::COLLECTION);
});

it('clears order type', function(): void {
    $this->location->updateOrderType();

    expect($this->location->getSession('orderType'))->toBeNull();
});

it('updates user position correctly', function(): void {
    $userPosition = new UserLocation('google', []);

    $this->location->updateUserPosition($userPosition);

    expect($this->location->userPosition())->toBe($userPosition);
});

it('updates schedule time slot correctly', function(): void {
    Event::fake();

    $this->location->updateScheduleTimeSlot('2022-12-31 12:00:00', false);

    Event::assertDispatched('location.timeslot.updated');
});

it('clears schedule time slot', function(): void {
    Event::fake();

    $this->location->updateScheduleTimeSlot(null);

    expect($this->location->getSession($this->location->orderType().'-timeslot'))->toBeNull();
});

it('returns true when location order setting is enabled', function(): void {
    setting()->set('location_order', 1);

    $result = $this->location->requiresUserPosition();

    expect($result)->toBeTrue();
});

it('checks order type correctly', function(): void {
    $this->location->setModel(new LocationModel);

    expect($this->location->checkOrderType(LocationModel::DELIVERY))->toBeTrue();
});

it('gets order type correctly', function(): void {
    $this->location->setModel(new LocationModel);

    expect($this->location->getOrderType(LocationModel::DELIVERY))->toBeInstanceOf(AbstractOrderType::class);

    $this->location->putSession('orderType', LocationModel::COLLECTION);

    expect($this->location->orderTypeIsCollection())->toBeTrue();

    $this->location->putSession('orderType', LocationModel::DELIVERY);

    expect($this->location->orderTypeIsDelivery())->toBeTrue();
});

it('returns true when order type is available and not disabled', function(): void {
    $location = mock(Location::class)->makePartial();
    $orderType = mock(AbstractOrderType::class);
    $orderType->shouldReceive('isDisabled')->andReturn(false);
    $location->shouldReceive('getOrderType')->andReturn($orderType);

    $result = $location->hasOrderType('delivery');

    expect($result)->toBeTrue();
});

it('returns false when order type is not available', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('getOrderType')->andReturn(null);

    $result = $location->hasOrderType('delivery');

    expect($result)->toBeFalse();
});

it('returns active order types when all are enabled', function(): void {
    $model = mock(LocationModel::class)->makePartial();
    $this->location->setModel($model);
    $orderType1 = mock(AbstractOrderType::class);
    $orderType1->shouldReceive('isDisabled')->andReturnFalse();
    $orderType2 = mock(AbstractOrderType::class);
    $orderType2->shouldReceive('isDisabled')->andReturnFalse();
    $model->shouldReceive('availableOrderTypes')->andReturn(collect(['delivery' => $orderType1, 'collection' => $orderType2]));

    $result = $this->location->getActiveOrderTypes();

    expect($result->count())->toBe(2);
});

it('returns opening schedule', function(): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('workingSchedule')->with(LocationModel::OPENING)->andReturn($schedule);

    $result = $location->openingSchedule();

    expect($result)->toBe($schedule);
});

it('returns delivery schedule', function(): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('workingSchedule')->with(LocationModel::DELIVERY)->andReturn($schedule);

    $result = $location->deliverySchedule();

    expect($result)->toBe($schedule);
});

it('returns collection schedule', function(): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('workingSchedule')->with(LocationModel::COLLECTION)->andReturn($schedule);

    $result = $location->collectionSchedule();

    expect($result)->toBe($schedule);
});

it('returns open/close time for given order type and time format', function($method, $scheduleMethod, $type, $format): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('workingSchedule')->with($type)->andReturn($schedule);
    $schedule->shouldReceive($scheduleMethod)->with($format)->andReturn('08:00');

    $result = $location->$method($type, $format);

    expect($result)->toBe('08:00');
})->with([
    ['openTime', 'getOpenTime', 'delivery', 'H:i'],
    ['openTime', 'getOpenTime', 'collection', 'H:i'],
    ['openTime', 'getOpenTime', 'opening', 'H:i'],
    ['closeTime', 'getCloseTime', 'delivery', 'H:i'],
    ['closeTime', 'getCloseTime', 'collection', 'H:i'],
    ['closeTime', 'getCloseTime', 'opening', 'H:i'],
]);

it('returns open/close time for current order type and no time format', function($method, $scheduleMethod, $type): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('orderType')->andReturn($type);
    $location->shouldReceive('workingSchedule')->with($type)->andReturn($schedule);
    $schedule->shouldReceive($scheduleMethod)->andReturn('22:00');

    $result = $location->$method();

    expect($result)->toBe('22:00');
})->with([
    ['openTime', 'getOpenTime', 'delivery'],
    ['openTime', 'getOpenTime', 'collection'],
    ['openTime', 'getOpenTime', 'opening'],
    ['closeTime', 'getCloseTime', 'delivery'],
    ['closeTime', 'getCloseTime', 'collection'],
    ['closeTime', 'getCloseTime', 'opening'],
]);

it('returns last order time', function(): void {
    $location = mock(Location::class)->makePartial();
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('getOrderType->getSchedule')->andReturn($schedule);
    $schedule->shouldReceive('getCloseTime')->andReturn('22:00');

    $result = $location->lastOrderTime();

    expect($result->toTimeString())->toBe('22:00:00');
});

it('gets minimum order total correctly', function(): void {
    $this->location->setModel(new LocationModel);

    LocationFacade::shouldReceive('coveredArea->minimumOrderTotal')->andReturn(10.0);

    expect($this->location->minimumOrderTotal(LocationModel::DELIVERY))->toBeNumeric();
});

it('checks minimum order total correctly', function(): void {
    $this->location->setModel(new LocationModel);

    LocationFacade::shouldReceive('coveredArea->minimumOrderTotal')->andReturn(10.0);

    expect($this->location->checkMinimumOrder(100, LocationModel::DELIVERY))->toBeBool();
});

it('checks order time correctly', function(): void {
    $this->location->setModel(new LocationModel(['location_id' => 1]));

    expect($this->location->checkOrderTime())->toBeBool();
});

it('checks order time returns false when current time is after order time', function(): void {
    $this->location->setModel(new LocationModel(['location_id' => 1]));

    expect($this->location->checkOrderTime(now()->subMinutes(10), LocationModel::DELIVERY))->toBeFalse();
});

it('checks order time returns false when no future days and location is closed', function(): void {
    $location = mock(Location::class)->makePartial();
    $orderType = mock(AbstractOrderType::class);
    $location->shouldReceive('getOrderType')->andReturn($orderType);
    $location->shouldReceive('isClosed')->andReturnTrue();
    $orderType->shouldReceive('getFutureDays')->andReturnFalse();

    expect($location->checkOrderTime(now()->toDateTimeString()))->toBeFalse();
});

it('checks order time returns false when location is closed in future dates', function(): void {
    $location = mock(Location::class)->makePartial();
    $orderType = mock(AbstractOrderType::class);
    $location->shouldReceive('getOrderType')->andReturn($orderType);
    $location->shouldReceive('isClosed')->andReturnFalse();
    $orderType->shouldReceive('getMinimumFutureDays')->andReturn(5);
    $orderType->shouldReceive('getFutureDays')->andReturn(10);

    expect($location->checkOrderTime(now()->addDay()))->toBeFalse();
});

it('orderTimeIsAsap returns first schedule timeslot when session date time is in the past', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('orderType')->andReturn('delivery');
    $location->shouldReceive('getSession')->with('delivery-timeslot.dateTime')->andReturn('2023-10-10 10:00:00');
    $location->shouldReceive('orderTimeIsAsap')->andReturn(false);
    $location->shouldReceive('hasAsapSchedule')->andReturn(false);
    $location->shouldReceive('firstScheduleTimeslot')->andReturn('2023-10-10 12:00:00');

    $result = $location->orderDateTime();

    expect($result->toDateTimeString())->toBe('2023-10-10 12:00:00');
});

it('orderTimeIsAsap returns false when order time is not ASAP and no ASAP schedule', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('hasAsapSchedule')->andReturn(false);

    $result = $location->orderTimeIsAsap();

    expect($result)->toBeFalse();
});

it('orderTimeIsAsap returns false when order time is not ASAP', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('hasAsapSchedule')->andReturnFalse();

    $result = $location->orderTimeIsAsap();

    expect($result)->toBeFalse();
});

it('orderTimeIsAsap returns false when order time is not ASAP and location is closed', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('hasAsapSchedule')->andReturn(true);
    $location->shouldReceive('orderType')->andReturn('delivery');
    $location->shouldReceive('getSession')->with('delivery-timeslot.dateTime')->andReturn('2023-10-10 10:00:00');
    $location->shouldReceive('getSession')->with('delivery-timeslot.isAsap', true)->andReturn(false);
    $location->shouldReceive('isOpened')->andReturnFalse()->once();

    $result = $location->orderTimeIsAsap();

    expect($result)->toBeFalse();
});

it('hasAsapSchedule returns false when order type has minimum future days', function(): void {
    $orderType = mock(AbstractOrderType::class);
    $orderType->shouldReceive('getMinimumFutureDays')->andReturn(1);
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('getOrderType')->andReturn($orderType);

    $result = $location->hasAsapSchedule();

    expect($result)->toBeFalse();
});

it('isOpened returns true when location is open', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('getOrderType->getSchedule->isOpen')->andReturnTrue();

    $result = $location->isOpened();

    expect($result)->toBeTrue();
});

it('returns first schedule timeslot when location is closed', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('isClosed')->andReturn(true);
    $location->shouldReceive('firstScheduleTimeslot')->andReturn(make_carbon('2023-10-10 12:00:00'));

    $result = $location->asapScheduleTimeslot();

    expect($result->toDateTimeString())->toBe('2023-10-10 12:00:00');
});

it('returns first schedule timeslot when limit orders is enabled', function(): void {
    $location = mock(Location::class)->makePartial();
    $location->shouldReceive('isClosed')->andReturn(false);
    $location->shouldReceive('getModel->getSettings')->with('checkout.limit_orders')->andReturn(true);
    $location->shouldReceive('firstScheduleTimeslot')->andReturn(make_carbon('2023-10-10 12:00:00'));

    $result = $location->asapScheduleTimeslot();

    expect($result->toDateTimeString())->toBe('2023-10-10 12:00:00');
});

it('returns first schedule timeslot when available', function(): void {
    $location = mock(Location::class)->makePartial();
    $timeslot = Carbon::parse('2023-10-10 12:00:00');
    $location->shouldReceive('scheduleTimeslot')->andReturn(collect([[$timeslot]]));

    $result = $location->firstScheduleTimeslot();

    expect($result->toDateTimeString())->toBe('2023-10-10 12:00:00');
});

it('returns schedule timeslot when available and cached', function(): void {
    $location = mock(Location::class)->makePartial();
    $orderType = mock(AbstractOrderType::class);
    $schedule = mock(WorkingSchedule::class);
    $location->shouldReceive('orderType')->andReturn('delivery');
    $location->shouldReceive('getOrderType')->andReturn($orderType);
    $orderType->shouldReceive('getLeadTime')->andReturn(10);
    $orderType->shouldReceive('getInterval')->andReturn(15);
    $orderType->shouldReceive('getSchedule')->andReturn($schedule);
    $schedule->shouldReceive('getTimeslot')->with(15, null, 10)->andReturn(collect(['timeslot']));
    $model = mock(LocationModel::class)->makePartial();
    $model->shouldReceive('shouldAddLeadTime')->andReturnTrue();
    $location->setModel($model);

    $result = $location->scheduleTimeslot();

    expect($result->all())->toBe(['timeslot']);

    // Call again to test cache
    $result = $location->scheduleTimeslot();

    expect($result->all())->toBe(['timeslot']);
});

it('returns false when at least one order type is available', function(): void {
    $this->location->setModel(new LocationModel);
    $result = $this->location->checkNoOrderTypeAvailable();

    expect($result)->toBeFalse();
});

it('returns true when order type has later schedule', function(): void {
    $this->location->setModel(new LocationModel);

    $result = $this->location->hasLaterSchedule();

    expect($result)->toBeTrue();
});

it('returns working schedule', function(): void {
    $location = LocationModel::factory()->create();
    $this->location->setModel($location);

    $result = $this->location->workingSchedule('delivery');

    expect($result->getType())->toBe('delivery')
        ->and(array_keys($result->getPeriods()))->toBe([
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        ]);

    // Call again to test cache
    $this->location->workingSchedule('delivery');
});

it('updates nearby area correctly', function(): void {
    $area = LocationArea::factory()->create(['location_id' => LocationModel::factory()->create()->getKey()]);

    $this->location->updateNearbyArea($area);

    expect($this->location->coveredArea())->toBeInstanceOf(CoveredArea::class)
        ->and($this->location->isCurrentAreaId($area->getKey()))->toBeTrue()
        ->and($this->location->getAreaId())->toBe($area->getKey());
});

it('coveredArea returns covered area by session area id', function(): void {
    $location = LocationModel::factory()->create();
    $area = LocationArea::factory()->create(['location_id' => $location->getKey()]);
    $this->location->putSession('area', $area->getKey());
    $this->location->setModel($location);

    $result = $this->location->coveredArea();

    expect($result->getKey())->toBe($area->getKey());
});

it('coveredArea returns new covered area when session area id does not match location id', function(): void {
    $location = LocationModel::factory()->create();
    $location2 = LocationModel::factory()->create();
    $area = LocationArea::factory()->create(['location_id' => $location->getKey()]);
    $this->location->putSession('area', $area->getKey());
    $this->location->setModel($location2);

    $result = $this->location->coveredArea();

    expect($result->getKey())->toBeNull();
});

it('returns delivery areas from the model', function(): void {
    $location = LocationModel::factory()->create();
    $location->delivery_areas()->saveMany([
        LocationArea::factory()->make(['location_id' => $location->getKey()]),
        LocationArea::factory()->make(['location_id' => $location->getKey()]),
    ]);
    $this->location->setModel($location);

    $result = $this->location->deliveryAreas();

    expect($result)->toHaveCount(2);
});

it('returns delivery amount from covered area', function(): void {
    $location = LocationModel::factory()->create();
    $area = LocationArea::factory()->create([
        'location_id' => $location->getKey(),
        'conditions' => [
            ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ],
    ]);
    $this->location->putSession('area', $area->getKey());
    $this->location->setModel($location);

    $result = $this->location->deliveryAmount(100);

    expect($result)->toBe(10.0);
});

it('returns minimum order total', function(): void {
    $location = LocationModel::factory()->create();
    $area = LocationArea::factory()->create([
        'location_id' => $location->getKey(),
        'conditions' => [
            ['type' => 'above', 'amount' => 50, 'total' => 100, 'priority' => 1],
        ],
    ]);
    $this->location->putSession('area', $area->getKey());
    $this->location->setModel($location);
    LocationFacade::shouldReceive('coveredArea')->andReturn(new CoveredArea($area));
    Cart::shouldReceive('subtotal')->andReturn(200);

    $result = $this->location->minimumOrder(200);

    expect($result)->toBe(100.0);
});

it('returns delivery charge conditions from covered area', function(): void {
    $location = LocationModel::factory()->create();
    $area = LocationArea::factory()->create([
        'location_id' => $location->getKey(),
        'conditions' => [
            ['type' => 'above', 'amount' => 50, 'total' => 100, 'priority' => 1],
            ['type' => 'below', 'amount' => 50, 'total' => 100, 'priority' => 1],
        ],
    ]);
    $this->location->putSession('area', $area->getKey());
    $this->location->setModel($location);

    $result = $this->location->getDeliveryChargeConditions();

    expect($result)->toHaveCount(2);
});

it('returns formatted distance when distance is an instance of Distance', function(): void {
    $location = LocationModel::factory()->create([
        'location_lat' => 51.0,
        'location_lng' => -0.0,
    ]);
    $location->distanceUnit = 'km';
    $this->location->setModel($location);
    $userPosition = new UserLocation('google', [
        'latitude' => 40.0,
        'longitude' => -74.0,
    ]);
    $this->location->putSession('position', $userPosition);
    Geocoder::shouldReceive('driver')->andReturn(mock(AbstractProvider::class, function($mock): void {
        $mock->shouldReceive('distance')->andReturn(new Distance(2129.6443 * 1000, 0));
    }));

    expect($this->location->checkDistance())->toBe(2129.6443);
});

it('returns locations ordered by distance', function(): void {
    $location = LocationModel::factory()->create();
    $location->update(['location_lat' => 1.01, 'location_lng' => 0.01]);
    $this->location->setModel($location);

    $userPosition = new UserLocation('google', [
        'latitude' => 0.01,
        'longitude' => 0.01,
    ]);
    $this->location->putSession('position', $userPosition);

    $result = $this->location->searchByCoordinates($userPosition->getCoordinates());

    expect($result)->toBeCollection();
});

it('checks delivery coverage correctly', function(): void {
    $this->location->setModel(new LocationModel);
    $userPosition = new UserLocation('google', [
        'latitude' => 0.01,
        'longitude' => 0.01,
    ]);
    $this->location->putSession('position', $userPosition);

    expect($this->location->checkDeliveryCoverage())->toBeBool();
});
