<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use Carbon\Carbon;
use Closure;
use DateTime;
use DateTimeInterface;
use Deprecated;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Model\Location as UserLocation;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\System\Traits\SessionMaker;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Location Class
 */
class Location
{
    use EventEmitter;
    use SessionMaker;

    public const string CLOSED = 'closed';

    public const string OPEN = 'open';

    public const string OPENING = 'opening';

    protected string $sessionKey = 'local_info';

    protected ?LocationModel $model = null;

    protected string $locationModel = LocationModel::class;

    protected ?CoveredArea $coveredArea = null;

    protected ?Collection $orderTypes = null;

    protected array $scheduleTimeslotCache = [];

    protected static array $schedulesCache = [];

    /**
     * The route parameter resolver callback.
     */
    protected static ?Closure $locationSlugResolver = null;

    /**
     * Resolve the location from route parameter.
     */
    public function resolveLocationSlug(): ?string
    {
        if (isset(static::$locationSlugResolver)) {
            return call_user_func(static::$locationSlugResolver);
        }

        return request()->route('location');
    }

    /**
     * Set the location route parameter resolver callback.
     */
    public function locationSlugResolver(Closure $resolver): void
    {
        static::$locationSlugResolver = $resolver;
    }

    public function check(): bool
    {
        return !is_null($this->current());
    }

    public function current(): ?LocationModel
    {
        if (!is_null($this->model)) {
            return $this->model;
        }

        $slug = $this->resolveLocationSlug();
        if ($slug && $model = $this->getBySlug($slug)) {
            $this->setCurrent($model);
        } else {
            $id = $this->getSession('id');
            if ($id && $model = $this->getById($id)) {
                $this->setModel($model);
            }
        }

        if (is_null($this->model) && is_single_location() && $defaultLocation = $this->locationModel::getDefault()) {
            $this->setCurrent($defaultLocation);
        }

        return $this->model;
    }

    public function currentOrDefault(): ?LocationModel
    {
        if (($model = $this->current()) instanceof LocationModel) {
            return $model;
        }

        if ($defaultLocation = $this->locationModel::getDefault()) {
            $this->setCurrent($defaultLocation);
        }

        return $defaultLocation;
    }

    public function currentOrAssigned(): array
    {
        if ($this->check()) {
            return [$this->getId()];
        }

        if (AdminAuth::isSuperUser()) {
            return [];
        }

        return AdminAuth::user()?->locations?->pluck('location_id')->all() ?? [];
    }

    public function setCurrent(LocationModel $locationModel): void
    {
        $this->setModel($locationModel);

        $this->putSession('id', $locationModel->getKey());

        $this->fireSystemEvent('location.current.updated', [$locationModel]);
    }

    public function getModel(): ?LocationModel
    {
        return $this->model;
    }

    public function setModel(LocationModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->current()?->getKey();
    }

    public function getName(): ?string
    {
        return $this->model?->getName();
    }

    public function createLocationModel(): LocationModel
    {
        $class = '\\'.ltrim($this->locationModel, '\\');

        return new $class;
    }

    protected function createLocationModelQuery(): Builder
    {
        $model = $this->createLocationModel();
        $query = $model->newQuery();
        $this->extendLocationQuery($query);

        return $query;
    }

    public function extendLocationQuery(Builder $query): void
    {
        if (!optional(AdminAuth::getUser())->hasPermission('Admin.Locations')) {
            $query->IsEnabled();
        }
    }

    public function getById(string|int $identifier): ?LocationModel
    {
        $query = $this->createLocationModelQuery();

        /** @var ?LocationModel $location */
        $location = $query->find($identifier);

        return $location ?: null;
    }

    public function getBySlug(string $slug): ?LocationModel
    {
        $model = $this->createLocationModel();
        $query = $this->createLocationModelQuery();

        /** @var ?LocationModel $location */
        $location = $query->where($model->getSlugKeyName(), $slug)->first();

        return $location ?: null;
    }

    public function clearInternalCache(): void
    {
        $this->model = null;
        $this->orderTypes = null;
        $this->coveredArea = null;
        $this->scheduleTimeslotCache = [];
        static::$locationSlugResolver = null;
    }

    //
    // Order Types
    //

    public function updateOrderType(?string $code = null): void
    {
        $oldOrderType = $this->getSession('orderType');

        if (is_null($code)) {
            $this->forgetSession('orderType');
        }

        if (!is_null($code)) {
            $this->putSession('orderType', $code);
            $this->fireSystemEvent('location.orderType.updated', [$code, $oldOrderType]);
        }
    }

    public function orderType(): mixed
    {
        return $this->getSession('orderType', LocationModel::DELIVERY);
    }

    public function checkOrderType(?string $code = null): bool
    {
        return !$this->getOrderType($code)->isDisabled();
    }

    /**
     * @return ?AbstractOrderType
     */
    public function getOrderType($code = null)
    {
        $code ??= $this->orderType();

        return $this->getOrderTypes()->get($code);
    }

    public function getOrderTypes()
    {
        if ($this->orderTypes instanceof Collection) {
            return $this->orderTypes;
        }

        return $this->orderTypes = $this->getModel()?->availableOrderTypes();
    }

    public function orderTypeIsDelivery(): bool
    {
        return $this->orderType() === LocationModel::DELIVERY;
    }

    public function orderTypeIsCollection(): bool
    {
        return $this->orderType() === LocationModel::COLLECTION;
    }

    public function hasOrderType($code = null)
    {
        if (!$orderType = $this->getOrderType($code)) {
            return false;
        }

        return !$orderType->isDisabled();
    }

    public function getActiveOrderTypes()
    {
        return collect($this->getOrderTypes() ?? [])->filter(fn($orderType): bool => !$orderType->isDisabled());
    }

    //
    // Timeslot
    //

    public function updateScheduleTimeSlot($dateTime, $isAsap = null): void
    {
        $orderType = $this->orderType();
        $oldSlot = $this->getSession($orderType.'-timeslot');

        $slot['dateTime'] = (!$isAsap && !is_null($dateTime)) ? make_carbon($dateTime) : null;
        $slot['isAsap'] = $isAsap;

        if (!array_filter($slot)) {
            $this->forgetSession($orderType.'-timeslot');
        } else {
            $this->putSession($orderType.'-timeslot', $slot);
        }

        $this->fireSystemEvent('location.timeslot.updated', [$slot, $oldSlot]);
    }

    public function openingSchedule(): WorkingSchedule
    {
        return $this->workingSchedule(Location::OPENING);
    }

    public function deliverySchedule(): WorkingSchedule
    {
        return $this->workingSchedule(LocationModel::DELIVERY);
    }

    public function collectionSchedule(): WorkingSchedule
    {
        return $this->workingSchedule(LocationModel::COLLECTION);
    }

    public function openTime(?string $type = null, ?string $format = null): null|string|DateTimeInterface
    {
        if (is_null($type)) {
            $type = $this->orderType();
        }

        return $this->workingSchedule($type)->getOpenTime($format);
    }

    public function closeTime(?string $type = null, ?string $format = null): null|string|DateTimeInterface
    {
        if (is_null($type)) {
            $type = $this->orderType();
        }

        return $this->workingSchedule($type)->getCloseTime($format);
    }

    public function lastOrderTime(): Carbon
    {
        return Carbon::parse($this->getOrderType()->getSchedule()->getCloseTime());
    }

    public function checkOrderTime($timestamp = null, $orderTypeCode = null)
    {
        if (is_null($timestamp)) {
            $timestamp = $this->orderDateTime();
        }

        if (!$timestamp instanceof DateTime) {
            $timestamp = new DateTime($timestamp);
        }

        if (Carbon::now()->subMinute()->gte($timestamp)) {
            return false;
        }

        $orderType = $this->getOrderType($orderTypeCode);

        if (!$orderType->getFutureDays() && $this->isClosed()) {
            return false;
        }

        $minFutureDays = Carbon::now()->startOfDay()->addDays($orderType->getMinimumFutureDays());
        $maxFutureDays = Carbon::now()->endOfDay()->addDays($orderType->getFutureDays());
        if (!$timestamp->between($minFutureDays, $maxFutureDays)) {
            return false;
        }

        return $orderType->getSchedule()->isOpenAt($timestamp);
    }

    public function orderDateTime(): Carbon
    {
        $dateTime = $this->getSession($this->orderType().'-timeslot.dateTime');
        if ($this->orderTimeIsAsap()) {
            $dateTime = $this->asapScheduleTimeslot();
        }

        if (!$dateTime || now()->isAfter($dateTime)) {
            $dateTime = $this->hasAsapSchedule() ? $this->asapScheduleTimeslot() : $this->firstScheduleTimeslot();
        }

        return make_carbon($dateTime);
    }

    public function orderTimeIsAsap()
    {
        if (!$this->hasAsapSchedule()) {
            return false;
        }

        $orderType = $this->orderType();
        $dateTime = $this->getSession($orderType.'-timeslot.dateTime');
        $orderTimeIsAsap = (bool)$this->getSession($orderType.'-timeslot.isAsap', true);

        if (!$this->isOpened()) {
            return false;
        }

        return $orderTimeIsAsap || ($dateTime && now()->isAfter($dateTime));
    }

    public function hasAsapSchedule()
    {
        if ($this->getOrderType()->getMinimumFutureDays()) {
            return false;
        }

        return $this->getOrderType()->getScheduleRestriction() !== AbstractOrderType::LATER_ONLY;
    }

    public function isOpened(): bool
    {
        return $this->getOrderType()->getSchedule()->isOpen();
    }

    public function asapScheduleTimeslot()
    {
        if ($this->isClosed() || (bool)$this->getModel()->getSettings('checkout.limit_orders')) {
            return $this->firstScheduleTimeslot();
        }

        return Carbon::now();
    }

    public function isClosed(): bool
    {
        return $this->getOrderType()->getSchedule()->isClosed();
    }

    public function firstScheduleTimeslot()
    {
        return $this->scheduleTimeslot()->collapse()->first();
    }

    public function scheduleTimeslot($orderType = null)
    {
        if (is_null($orderType)) {
            $orderType = $this->orderType();
        }

        if (array_key_exists($orderType, $this->scheduleTimeslotCache)) {
            return $this->scheduleTimeslotCache[$orderType];
        }

        $leadMinutes = $this->model->shouldAddLeadTime($orderType)
            ? $this->orderLeadTime() : 0;

        $result = $this->getOrderType($orderType)->getSchedule()->getTimeslot(
            $this->orderTimeInterval(), null, $leadMinutes,
        );

        return $this->scheduleTimeslotCache[$orderType] = $result;
    }

    public function orderLeadTime()
    {
        return $this->getOrderType()->getLeadTime();
    }

    public function orderTimeInterval()
    {
        return $this->getOrderType()->getInterval();
    }

    public function checkNoOrderTypeAvailable()
    {
        return $this->getOrderTypes()->filter(fn($orderType): bool => !$orderType->isDisabled())->isEmpty();
    }

    public function hasLaterSchedule(): bool
    {
        return $this->getOrderType()->getScheduleRestriction() !== AbstractOrderType::ASAP_ONLY;
    }

    public function workingSchedule(string $type, null|int|array $days = null): WorkingSchedule
    {
        $cacheKey = sprintf('%s.%s', $this->getModel()->getKey(), $type);

        if (isset(self::$schedulesCache[$cacheKey])) {
            return self::$schedulesCache[$cacheKey];
        }

        $schedule = $this->getModel()->newWorkingSchedule($type, $days);

        self::$schedulesCache[$cacheKey] = $schedule;

        return $schedule;
    }

    //
    // DELIVERY AREA
    //

    public function updateNearbyArea(LocationArea $area): void
    {
        $this->setCurrent($area->location);

        $this->setCoveredArea(new CoveredArea($area));
    }

    public function setCoveredArea(CoveredArea $coveredArea): static
    {
        $this->coveredArea = $coveredArea;

        $areaId = $this->getSession('area');
        if ($areaId !== $coveredArea->getKey()) {
            $this->putSession('area', $coveredArea->getKey());
            $this->fireSystemEvent('location.area.updated', [$coveredArea]);
        }

        return $this;
    }

    public function updateUserPosition(UserLocation $position): void
    {
        $oldPosition = $this->getSession('position');

        $this->putSession('position', $position);

        $this->clearCoveredArea();

        $this->fireSystemEvent('location.position.updated', [$position, $oldPosition]);
    }

    public function clearCoveredArea(): void
    {
        $this->coveredArea = null;
        $this->forgetSession('area');
    }

    public function requiresUserPosition(): bool
    {
        return setting('location_order') == 1;
    }

    public function isCurrentAreaId($areaId): bool
    {
        return $this->getAreaId() == $areaId;
    }

    public function getAreaId()
    {
        return $this->coveredArea()->getKey();
    }

    public function coveredArea(): CoveredArea
    {
        if (!is_null($this->coveredArea)) {
            return $this->coveredArea;
        }

        $area = null;
        if (($areaId = (int)$this->getSession('area')) !== 0) {
            $area = $this->getModel()->findDeliveryArea($areaId);
        }

        if (is_null($area)) {
            $area = $this->getModel()->searchOrDefaultDeliveryArea(
                $this->userPosition()->getCoordinates(),
            );
        }

        if (!$area instanceof LocationArea) {
            return new CoveredArea(new LocationArea);
        }

        $coveredArea = new CoveredArea($area);
        $this->setCoveredArea($coveredArea);

        return $coveredArea;
    }

    public function userPosition(): ?UserLocation
    {
        return $this->getSession('position', UserLocation::createFromArray([]));
    }

    public function deliveryAreas()
    {
        return $this->getModel()->listDeliveryAreas();
    }

    public function deliveryAmount($cartTotal): float|int
    {
        return $this->coveredArea()->deliveryAmount($cartTotal);
    }

    #[Deprecated(message: 'remove after v4, use minimumOrderTotal() instead')]
    public function minimumOrder($cartTotal)
    {
        return $this->minimumOrderTotal();
    }

    public function minimumOrderTotal($orderType = null)
    {
        return $this->getOrderType($orderType)->getMinimumOrderTotal();
    }

    public function getDeliveryChargeConditions(): Collection
    {
        return $this->coveredArea()->listConditions();
    }

    #[Deprecated(message: 'remove after v4, use checkMinimumOrderTotal() instead')]
    public function checkMinimumOrder($cartTotal): bool
    {
        return $this->checkMinimumOrderTotal($cartTotal);
    }

    public function checkMinimumOrderTotal($cartTotal, $orderType = null): bool
    {
        return $cartTotal >= $this->minimumOrderTotal($orderType);
    }

    public function checkDistance(): ?float
    {
        return $this->getModel()
            ->calculateDistance($this->userPosition()->getCoordinates())
            ?->formatDistance($this->getModel()->getDistanceUnit());
    }

    public function checkDeliveryCoverage(?UserLocation $userPosition = null)
    {
        if (is_null($userPosition)) {
            $userPosition = $this->userPosition();
        }

        return $this->coveredArea()->checkBoundary($userPosition->getCoordinates());
    }

    public function searchByCoordinates(CoordinatesInterface $coordinates, int $limit = 20): Collection
    {
        $query = $this->createLocationModelQuery();
        // @phpstan-ignore method.notFound
        $query->select('*')->selectDistance(
            $coordinates->getLatitude(),
            $coordinates->getLongitude(),
        );

        return $query->with('delivery_areas')->orderBy('distance')->limit($limit)->get();
    }
}
