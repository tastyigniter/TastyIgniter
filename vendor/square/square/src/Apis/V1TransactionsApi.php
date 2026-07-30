<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\V1CreateRefundRequest;
use Square\Models\V1Order;
use Square\Models\V1Payment;
use Square\Models\V1Refund;
use Square\Models\V1Settlement;
use Square\Models\V1UpdateOrderRequest;

class V1TransactionsApi extends BaseApi
{
    /**
     * Provides summary information for a merchant's online store orders.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the location to list online store orders for.
     * @param string|null $order The order in which payments are listed in the response.
     * @param int|null $limit The maximum number of payments to return in a single response. This
     *        value cannot exceed 200.
     * @param string|null $batchToken A pagination cursor to retrieve the next set of results for
     *        your
     *        original query to the endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1ListOrders(
        string $locationId,
        ?string $order = null,
        ?int $limit = null,
        ?string $batchToken = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/orders')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('order', $order),
                QueryParam::init('limit', $limit),
                QueryParam::init('batch_token', $batchToken)
            );

        $_resHandler = $this->responseHandler()->type(V1Order::class, 1)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides comprehensive information for a single online store order, including the order's history.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the order's associated location.
     * @param string $orderId The order's Square-issued ID. You obtain this value from Order objects
     *        returned by the List Orders endpoint
     *
     * @return ApiResponse Response from the API call
     */
    public function v1RetrieveOrder(string $locationId, string $orderId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/orders/{order_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('order_id', $orderId)
            );

        $_resHandler = $this->responseHandler()->type(V1Order::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates the details of an online store order. Every update you perform on an order corresponds to
     * one of three actions:
     *
     * @deprecated
     *
     * @param string $locationId The ID of the order's associated location.
     * @param string $orderId The order's Square-issued ID. You obtain this value from Order objects
     *        returned by the List Orders endpoint
     * @param V1UpdateOrderRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1UpdateOrder(string $locationId, string $orderId, V1UpdateOrderRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v1/{location_id}/orders/{order_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('order_id', $orderId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(V1Order::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides summary information for all payments taken for a given
     * Square account during a date range. Date ranges cannot exceed 1 year in
     * length. See Date ranges for details of inclusive and exclusive dates.
     *
     * *Note**: Details for payments processed with Square Point of Sale while
     * in offline mode may not be transmitted to Square for up to 72 hours.
     * Offline payments have a `created_at` value that reflects the time the
     * payment was originally processed, not the time it was subsequently
     * transmitted to Square. Consequently, the ListPayments endpoint might
     * list an offline payment chronologically between online payments that
     * were seen in a previous request.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the location to list payments for. If you specify me,
     *        this endpoint returns payments aggregated from all of the business's locations.
     * @param string|null $order The order in which payments are listed in the response.
     * @param string|null $beginTime The beginning of the requested reporting period, in ISO 8601
     *        format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this
     *        endpoint returns an error. Default value: The current time minus one year.
     * @param string|null $endTime The end of the requested reporting period, in ISO 8601 format. If
     *        this value is more than one year greater than begin_time, this endpoint returns an
     *        error. Default value: The current time.
     * @param int|null $limit The maximum number of payments to return in a single response. This
     *        value cannot exceed 200.
     * @param string|null $batchToken A pagination cursor to retrieve the next set of results for
     *        your
     *        original query to the endpoint.
     * @param bool|null $includePartial Indicates whether or not to include partial payments in the
     *        response. Partial payments will have the tenders collected so far, but the
     *        itemizations will be empty until the payment is completed.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1ListPayments(
        string $locationId,
        ?string $order = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?int $limit = null,
        ?string $batchToken = null,
        ?bool $includePartial = false
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/payments')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('order', $order),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('limit', $limit),
                QueryParam::init('batch_token', $batchToken),
                QueryParam::init('include_partial', $includePartial)
            );

        $_resHandler = $this->responseHandler()->type(V1Payment::class, 1)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides comprehensive information for a single payment.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the payment's associated location.
     * @param string $paymentId The Square-issued payment ID. payment_id comes from Payment objects
     *        returned by the List Payments endpoint, Settlement objects returned by the List
     *        Settlements endpoint, or Refund objects returned by the List Refunds endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1RetrievePayment(string $locationId, string $paymentId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/payments/{payment_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('payment_id', $paymentId)
            );

        $_resHandler = $this->responseHandler()->type(V1Payment::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides the details for all refunds initiated by a merchant or any of the merchant's mobile staff
     * during a date range. Date ranges cannot exceed one year in length.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the location to list refunds for.
     * @param string|null $order The order in which payments are listed in the response.
     * @param string|null $beginTime The beginning of the requested reporting period, in ISO 8601
     *        format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this
     *        endpoint returns an error. Default value: The current time minus one year.
     * @param string|null $endTime The end of the requested reporting period, in ISO 8601 format. If
     *        this value is more than one year greater than begin_time, this endpoint returns an
     *        error. Default value: The current time.
     * @param int|null $limit The approximate number of refunds to return in a single response.
     *        Default: 100. Max: 200. Response may contain more results than the prescribed limit
     *        when refunds are made simultaneously to multiple tenders in a payment or when
     *        refunds are generated in an exchange to account for the value of returned goods.
     * @param string|null $batchToken A pagination cursor to retrieve the next set of results for
     *        your
     *        original query to the endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1ListRefunds(
        string $locationId,
        ?string $order = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?int $limit = null,
        ?string $batchToken = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/refunds')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('order', $order),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('limit', $limit),
                QueryParam::init('batch_token', $batchToken)
            );

        $_resHandler = $this->responseHandler()->type(V1Refund::class, 1)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Issues a refund for a previously processed payment. You must issue
     * a refund within 60 days of the associated payment.
     *
     * You cannot issue a partial refund for a split tender payment. You must
     * instead issue a full or partial refund for a particular tender, by
     * providing the applicable tender id to the V1CreateRefund endpoint.
     * Issuing a full refund for a split tender payment refunds all tenders
     * associated with the payment.
     *
     * Issuing a refund for a card payment is not reversible. For development
     * purposes, you can create fake cash payments in Square Point of Sale and
     * refund them.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the original payment's associated location.
     * @param V1CreateRefundRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1CreateRefund(string $locationId, V1CreateRefundRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v1/{location_id}/refunds')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(V1Refund::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides summary information for all deposits and withdrawals
     * initiated by Square to a linked bank account during a date range. Date
     * ranges cannot exceed one year in length.
     *
     * *Note**: the ListSettlements endpoint does not provide entry
     * information.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the location to list settlements for. If you specify me,
     *        this endpoint returns settlements aggregated from all of the business's locations.
     * @param string|null $order The order in which settlements are listed in the response.
     * @param string|null $beginTime The beginning of the requested reporting period, in ISO 8601
     *        format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this
     *        endpoint returns an error. Default value: The current time minus one year.
     * @param string|null $endTime The end of the requested reporting period, in ISO 8601 format. If
     *        this value is more than one year greater than begin_time, this endpoint returns an
     *        error. Default value: The current time.
     * @param int|null $limit The maximum number of settlements to return in a single response. This
     *        value cannot exceed 200.
     * @param string|null $status Provide this parameter to retrieve only settlements with a
     *        particular status (SENT or FAILED).
     * @param string|null $batchToken A pagination cursor to retrieve the next set of results for
     *        your
     *        original query to the endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1ListSettlements(
        string $locationId,
        ?string $order = null,
        ?string $beginTime = null,
        ?string $endTime = null,
        ?int $limit = null,
        ?string $status = null,
        ?string $batchToken = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/settlements')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('order', $order),
                QueryParam::init('begin_time', $beginTime),
                QueryParam::init('end_time', $endTime),
                QueryParam::init('limit', $limit),
                QueryParam::init('status', $status),
                QueryParam::init('batch_token', $batchToken)
            );

        $_resHandler = $this->responseHandler()->type(V1Settlement::class, 1)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Provides comprehensive information for a single settlement.
     *
     * The returned `Settlement` objects include an `entries` field that lists
     * the transactions that contribute to the settlement total. Most
     * settlement entries correspond to a payment payout, but settlement
     * entries are also generated for less common events, like refunds, manual
     * adjustments, or chargeback holds.
     *
     * Square initiates its regular deposits as indicated in the
     * [Deposit Options with Square](https://squareup.com/help/us/en/article/3807)
     * help article. Details for a regular deposit are usually not available
     * from Connect API endpoints before 10 p.m. PST the same day.
     *
     * Square does not know when an initiated settlement **completes**, only
     * whether it has failed. A completed settlement is typically reflected in
     * a bank account within 3 business days, but in exceptional cases it may
     * take longer.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the settlements's associated location.
     * @param string $settlementId The settlement's Square-issued ID. You obtain this value from
     *        Settlement objects returned by the List Settlements endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function v1RetrieveSettlement(string $locationId, string $settlementId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v1/{location_id}/settlements/{settlement_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('settlement_id', $settlementId)
            );

        $_resHandler = $this->responseHandler()->type(V1Settlement::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
