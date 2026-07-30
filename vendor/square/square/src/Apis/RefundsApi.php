<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\GetPaymentRefundResponse;
use Square\Models\ListPaymentRefundsResponse;
use Square\Models\RefundPaymentRequest;
use Square\Models\RefundPaymentResponse;

class RefundsApi extends BaseApi
{
    /**
     * Retrieves a list of refunds for the account making the request.
     *
     * Results are eventually consistent, and new refunds or changes to refunds might take several
     * seconds to appear.
     *
     * The maximum results per page is 100.
     *
     * @param string|null $beginTime Indicates the start of the time range to retrieve each
     *        PaymentRefund` for, in RFC 3339
     *        format.  The range is determined using the `created_at` field for each
     *        `PaymentRefund`.
     *
     *        Default: The current time minus one year.
     * @param string|null $endTime Indicates the end of the time range to retrieve each
     *        `PaymentRefund` for, in RFC 3339
     *        format.  The range is determined using the `created_at` field for each
     *        `PaymentRefund`.
     *
     *        Default: The current time.
     * @param string|null $sortOrder The order in which results are listed by
     *        `PaymentRefund.created_at`:
     *        - `ASC` - Oldest to newest.
     *        - `DESC` - Newest to oldest (default).
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param string|null $locationId Limit results to the location supplied. By default, results
     *        are returned
     *        for all locations associated with the seller.
     * @param string|null $status If provided, only refunds with the given status are returned. For
     *        a list of refund status values, see [PaymentRefund](entity:PaymentRefund).
     *
     *        Default: If omitted, refunds are returned regardless of their status.
     * @param string|null $sourceType If provided, only returns refunds whose payments have the
     *        indicated source type.
     *        Current values include `CARD`, `BANK_ACCOUNT`, `WALLET`, `CASH`, and `EXTERNAL`.
     *        For information about these payment source types, see
     *        [Take Payments](https://developer.squareup.com/docs/payments-api/take-payments).
     *
     *        Default: If omitted, refunds are returned regardless of the source type.
     * @param int|null $limit The maximum number of results to be returned in a single page. It is
     *        possible to receive fewer results than the specified limit on a given page.
     *
     *        If the supplied value is greater than 100, no more than 100 results are returned.
     *
     *        Default: 100
     *
     * @return ApiResponse Response from the API call
     */
    public function listPaymentRefunds(
        ?string $beginTime = null,
        ?string $endTime = null,
        ?string $sortOrder = null,
        ?string $cursor = null,
        ?string $locationId = null,
        ?string $status = null,
        ?string $sourceType = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/refunds')
            ->auth('global')
            ->parameters(
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('location_id', $locationId),
                QueryParam::init('status', $status),
                QueryParam::init('source_type', $sourceType),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListPaymentRefundsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Refunds a payment. You can refund the entire payment amount or a
     * portion of it. You can use this endpoint to refund a card payment or record a
     * refund of a cash or external payment. For more information, see
     * [Refund Payment](https://developer.squareup.com/docs/payments-api/refund-payments).
     *
     * @param RefundPaymentRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function refundPayment(RefundPaymentRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/refunds')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(RefundPaymentResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a specific refund using the `refund_id`.
     *
     * @param string $refundId The unique ID for the desired `PaymentRefund`.
     *
     * @return ApiResponse Response from the API call
     */
    public function getPaymentRefund(string $refundId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/refunds/{refund_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('refund_id', $refundId));

        $_resHandler = $this->responseHandler()->type(GetPaymentRefundResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
