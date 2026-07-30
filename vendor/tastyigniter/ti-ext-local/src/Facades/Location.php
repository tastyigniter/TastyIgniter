<?php

declare(strict_types=1);

namespace Igniter\Local\Facades;

use Carbon\Carbon;
use Closure;
use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Contracts\AreaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static string|null resolveLocationSlug()
 * @method static void locationSlugResolver(Closure $resolver)
 * @method static bool check()
 * @method static \Igniter\Local\Models\Location|null current()
 * @method static \Igniter\Local\Models\Location|null currentOrDefault()
 * @method static array currentOrAssigned()
 * @method static void setCurrent(\Igniter\Local\Models\Location $locationModel)
 * @method static \Igniter\Local\Models\Location|null getModel()
 * @method static \Igniter\Local\Classes\Location setModel(\Igniter\Local\Models\Location $model)
 * @method static int|null getId()
 * @method static string|null getName()
 * @method static \Igniter\Local\Models\Location createLocationModel()
 * @method static void extendLocationQuery(Builder $query)
 * @method static \Igniter\Local\Models\Location|null getById(string | int $identifier)
 * @method static \Igniter\Local\Models\Location|null getBySlug(string $slug)
 * @method static void clearInternalCache()
 * @method static void updateOrderType(void $code = null)
 * @method static string orderType()
 * @method static void checkOrderType(void $code = null)
 * @method static AbstractOrderType getOrderType(void $code = null)
 * @method static Collection getOrderTypes()
 * @method static bool orderTypeIsDelivery()
 * @method static bool orderTypeIsCollection()
 * @method static bool hasOrderType(void $code = null)
 * @method static void getActiveOrderTypes()
 * @method static void updateScheduleTimeSlot(void $dateTime, void $isAsap = null)
 * @method static WorkingSchedule openingSchedule()
 * @method static WorkingSchedule deliverySchedule()
 * @method static WorkingSchedule collectionSchedule()
 * @method static void openTime(void $type = null, void $format = null)
 * @method static void closeTime(void $type = null, void $format = null)
 * @method static void lastOrderTime()
 * @method static bool checkOrderTime(void $timestamp = null, void $orderTypeCode = null)
 * @method static Carbon orderDateTime()
 * @method static bool orderTimeIsAsap()
 * @method static bool hasAsapSchedule()
 * @method static bool isOpened()
 * @method static void asapScheduleTimeslot()
 * @method static bool isClosed()
 * @method static void firstScheduleTimeslot()
 * @method static void scheduleTimeslot(void $orderType = null)
 * @method static void orderLeadTime()
 * @method static void orderTimeInterval()
 * @method static bool checkNoOrderTypeAvailable()
 * @method static void hasLaterSchedule()
 * @method static WorkingSchedule workingSchedule(string $type, array | int | null $days = null)
 * @method static void updateNearbyArea(AreaInterface $area)
 * @method static void setCoveredArea(CoveredArea $coveredArea)
 * @method static void updateUserPosition(\Igniter\Flame\Geolite\Model\Location $position)
 * @method static void clearCoveredArea()
 * @method static bool requiresUserPosition()
 * @method static bool isCurrentAreaId(void $areaId)
 * @method static null|int getAreaId()
 * @method static CoveredArea coveredArea()
 * @method static null|\Igniter\Flame\Geolite\Model\Location userPosition()
 * @method static Collection deliveryAreas()
 * @method static float|int deliveryAmount(void $cartTotal)
 * @method static float|int minimumOrderTotal(void $orderType = null)
 * @method static Collection getDeliveryChargeConditions()
 * @method static bool checkMinimumOrderTotal(void $cartTotal, void $orderType = null)
 * @method static float|int checkDistance()
 * @method static void checkDeliveryCoverage(\Igniter\Flame\Geolite\Model\Location|null $userPosition = null)
 * @method static Collection searchByCoordinates(CoordinatesInterface $coordinates, int $limit = 20)
 * @method static \Igniter\Local\Classes\Location bindEvent(string $event, callable $callback, int $priority = 0)
 * @method static \Igniter\Local\Classes\Location bindEventOnce(string $event, callable $callback)
 * @method static \Igniter\Local\Classes\Location unbindEvent(string|null $event = null)
 * @method static mixed fireEvent(string $event, array $params = [], bool $halt = false)
 * @method static mixed fireSystemEvent(string $event, array $params = [], bool $halt = true)
 * @method static mixed getSession(string|null $key = null, mixed $default = null)
 * @method static void putSession(string $key, mixed $value)
 * @method static bool hasSession(string $key)
 * @method static void flashSession(string $key, mixed $value)
 * @method static void forgetSession(string $key)
 * @method static void resetSession()
 * @method static \Igniter\Local\Classes\Location setSessionKey(string $key)
 *
 * @see \Igniter\Local\Classes\Location
 */
class Location extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'location';
    }
}
