<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\ListCashDrawerShiftEventsResponse;
use Square\Models\ListCashDrawerShiftsResponse;
use Square\Models\RetrieveCashDrawerShiftResponse;

class CashDrawersApi extends BaseApi
{
    /**
     * Provides the details for all of the cash drawer shifts for a location
     * in a date range.
     *
     * @param string $locationId The ID of the location to query for a list of cash drawer shifts.
     * @param string|null $sortOrder The order in which cash drawer shifts are listed in the
     *        response,
     *        based on their opened_at field. Default value: ASC
     * @param string|null $beginTime The inclusive start time of the query on opened_at, in ISO 8601
     *        format.
     * @param string|null $endTime The exclusive end date of the query on opened_at, in ISO 8601
     *        format.
     * @param int|null $limit Number of cash drawer shift events in a page of results (200 by
     *        default, 1000 max).
     * @param string|null $cursor Opaque cursor for fetching the next page of results.
     *
     * @return ApiResponse Response from the API call
     */
    public function listCashDrawerShifts(
        string $locationId,
        ?string $sortOrder = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/cash-drawers/shifts')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListCashDrawerShiftsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides the summary details for a single cash drawer shift. See
     * [ListCashDrawerShiftEvents]($e/CashDrawers/ListCashDrawerShiftEvents) for a list of cash drawer
     * shift events.
     *
     * @param string $locationId The ID of the location to retrieve cash drawer shifts from.
     * @param string $shiftId The shift ID.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveCashDrawerShift(string $locationId, string $shiftId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/cash-drawers/shifts/{shift_id}')
            ->auth('global')
            ->parameters(QueryParam::init('location_id', $locationId), TemplateParam::init('shift_id', $shiftId));

        $_resHandler = $this->responseHandler()->type(RetrieveCashDrawerShiftResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides a paginated list of events for a single cash drawer shift.
     *
     * @param string $locationId The ID of the location to list cash drawer shifts for.
     * @param string $shiftId The shift ID.
     * @param int|null $limit Number of resources to be returned in a page of results (200 by
     *        default, 1000 max).
     * @param string|null $cursor Opaque cursor for fetching the next page of results.
     *
     * @return ApiResponse Response from the API call
     */
    public function listCashDrawerShiftEvents(
        string $locationId,
        string $shiftId,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/cash-drawers/shifts/{shift_id}/events')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                TemplateParam::init('shift_id', $shiftId),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListCashDrawerShiftEventsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
