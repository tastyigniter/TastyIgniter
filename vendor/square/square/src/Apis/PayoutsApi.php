<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\GetPayoutResponse;
use Square\Models\ListPayoutEntriesResponse;
use Square\Models\ListPayoutsResponse;

class PayoutsApi extends BaseApi
{
    /**
     * Retrieves a list of all payouts for the default location.
     * You can filter payouts by location ID, status, time range, and order them in ascending or descending
     * order.
     * To call this endpoint, set `PAYOUTS_READ` for the OAuth scope.
     *
     * @param string|null $locationId The ID of the location for which to list the payouts. By
     *        default, payouts are returned for the default (main) location associated with the
     *        seller.
     * @param string|null $status If provided, only payouts with the given status are returned.
     * @param string|null $beginTime The timestamp for the beginning of the payout creation time, in
     *        RFC 3339 format.
     *        Inclusive. Default: The current time minus one year.
     * @param string|null $endTime The timestamp for the end of the payout creation time, in RFC
     *        3339 format.
     *        Default: The current time.
     * @param string|null $sortOrder The order in which payouts are listed.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *        If request parameters change between requests, subsequent results may contain
     *        duplicates or missing records.
     * @param int|null $limit The maximum number of results to be returned in a single page. It is
     *        possible to receive fewer results than the specified limit on a given page.
     *        The default value of 100 is also the maximum allowed value. If the provided value
     *        is
     *        greater than 100, it is ignored and the default value is used instead.
     *        Default: `100`
     *
     * @return ApiResponse Response from the API call
     */
    public function listPayouts(
        ?string $locationId = null,
        ?string $status = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?string $sortOrder = null,
        ?string $cursor = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/payouts')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                QueryParam::init('status', $status),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListPayoutsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves details of a specific payout identified by a payout ID.
     * To call this endpoint, set `PAYOUTS_READ` for the OAuth scope.
     *
     * @param string $payoutId The ID of the payout to retrieve the information for.
     *
     * @return ApiResponse Response from the API call
     */
    public function getPayout(string $payoutId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/payouts/{payout_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('payout_id', $payoutId));

        $_resHandler = $this->responseHandler()->type(GetPayoutResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a list of all payout entries for a specific payout.
     * To call this endpoint, set `PAYOUTS_READ` for the OAuth scope.
     *
     * @param string $payoutId The ID of the payout to retrieve the information for.
     * @param string|null $sortOrder The order in which payout entries are listed.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *        If request parameters change between requests, subsequent results may contain
     *        duplicates or missing records.
     * @param int|null $limit The maximum number of results to be returned in a single page. It is
     *        possible to receive fewer results than the specified limit on a given page.
     *        The default value of 100 is also the maximum allowed value. If the provided value
     *        is
     *        greater than 100, it is ignored and the default value is used instead.
     *        Default: `100`
     *
     * @return ApiResponse Response from the API call
     */
    public function listPayoutEntries(
        string $payoutId,
        ?string $sortOrder = null,
        ?string $cursor = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/payouts/{payout_id}/payout-entries')
            ->auth('global')
            ->parameters(
                TemplateParam::init('payout_id', $payoutId),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListPayoutEntriesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
