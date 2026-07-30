<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\ListCustomerSegmentsResponse;
use Square\Models\RetrieveCustomerSegmentResponse;

class CustomerSegmentsApi extends BaseApi
{
    /**
     * Retrieves the list of customer segments of a business.
     *
     * @param string|null $cursor A pagination cursor returned by previous calls to
     *        `ListCustomerSegments`.
     *        This cursor is used to retrieve the next set of query results.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param int|null $limit The maximum number of results to return in a single page. This limit
     *        is advisory. The response might contain more or fewer results.
     *        If the specified limit is less than 1 or greater than 50, Square returns a `400
     *        VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 50.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *
     * @return ApiResponse Response from the API call
     */
    public function listCustomerSegments(?string $cursor = null, ?int $limit = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/customers/segments')
            ->auth('global')
            ->parameters(QueryParam::init('cursor', $cursor), QueryParam::init('limit', $limit));

        $_resHandler = $this->responseHandler()->type(ListCustomerSegmentsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a specific customer segment as identified by the `segment_id` value.
     *
     * @param string $segmentId The Square-issued ID of the customer segment.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveCustomerSegment(string $segmentId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/customers/segments/{segment_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('segment_id', $segmentId));

        $_resHandler = $this->responseHandler()->type(RetrieveCustomerSegmentResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
