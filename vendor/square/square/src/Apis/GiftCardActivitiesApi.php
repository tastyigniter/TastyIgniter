<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateGiftCardActivityRequest;
use Square\Models\CreateGiftCardActivityResponse;
use Square\Models\ListGiftCardActivitiesResponse;

class GiftCardActivitiesApi extends BaseApi
{
    /**
     * Lists gift card activities. By default, you get gift card activities for all
     * gift cards in the seller's account. You can optionally specify query parameters to
     * filter the list. For example, you can get a list of gift card activities for a gift card,
     * for all gift cards in a specific region, or for activities within a time window.
     *
     * @param string|null $giftCardId If a gift card ID is provided, the endpoint returns activities
     *        related
     *        to the specified gift card. Otherwise, the endpoint returns all gift card activities
     *        for
     *        the seller.
     * @param string|null $type If a [type](entity:GiftCardActivityType) is provided, the endpoint
     *        returns gift card activities of the specified type.
     *        Otherwise, the endpoint returns all types of gift card activities.
     * @param string|null $locationId If a location ID is provided, the endpoint returns gift card
     *        activities for the specified location.
     *        Otherwise, the endpoint returns gift card activities for all locations.
     * @param string|null $beginTime The timestamp for the beginning of the reporting period, in RFC
     *        3339 format.
     *        This start time is inclusive. The default value is the current time minus one year.
     * @param string|null $endTime The timestamp for the end of the reporting period, in RFC 3339
     *        format.
     *        This end time is inclusive. The default value is the current time.
     * @param int|null $limit If a limit is provided, the endpoint returns the specified number of
     *        results (or fewer) per page. The maximum value is 100. The default value is 50.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/working-
     *        with-apis/pagination).
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        If a cursor is not provided, the endpoint returns the first page of the results.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/working-
     *        with-apis/pagination).
     * @param string|null $sortOrder The order in which the endpoint returns the activities, based
     *        on `created_at`.
     *        - `ASC` - Oldest to newest.
     *        - `DESC` - Newest to oldest (default).
     *
     * @return ApiResponse Response from the API call
     */
    public function listGiftCardActivities(
        ?string $giftCardId = null,
        ?string $type = null,
        ?string $locationId = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?string $sortOrder = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/gift-cards/activities')
            ->auth('global')
            ->parameters(
                QueryParam::init('gift_card_id', $giftCardId),
                QueryParam::init('type', $type),
                QueryParam::init('location_id', $locationId),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('sort_order', $sortOrder)
            );

        $_resHandler = $this->responseHandler()->type(ListGiftCardActivitiesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a gift card activity to manage the balance or state of a [gift card]($m/GiftCard).
     * For example, you create an `ACTIVATE` activity to activate a gift card with an initial balance
     * before the gift card can be used.
     *
     * @param CreateGiftCardActivityRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createGiftCardActivity(CreateGiftCardActivityRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/gift-cards/activities')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateGiftCardActivityResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
