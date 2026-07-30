<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BatchRetrieveOrdersRequest;
use Square\Models\BatchRetrieveOrdersResponse;
use Square\Models\CalculateOrderRequest;
use Square\Models\CalculateOrderResponse;
use Square\Models\CloneOrderRequest;
use Square\Models\CloneOrderResponse;
use Square\Models\CreateOrderRequest;
use Square\Models\CreateOrderResponse;
use Square\Models\PayOrderRequest;
use Square\Models\PayOrderResponse;
use Square\Models\RetrieveOrderResponse;
use Square\Models\SearchOrdersRequest;
use Square\Models\SearchOrdersResponse;
use Square\Models\UpdateOrderRequest;
use Square\Models\UpdateOrderResponse;

class OrdersApi extends BaseApi
{
    /**
     * Creates a new [order]($m/Order) that can include information about products for
     * purchase and settings to apply to the purchase.
     *
     * To pay for a created order, see
     * [Pay for Orders](https://developer.squareup.com/docs/orders-api/pay-for-orders).
     *
     * You can modify open orders using the [UpdateOrder]($e/Orders/UpdateOrder) endpoint.
     *
     * @param CreateOrderRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createOrder(CreateOrderRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a set of [orders]($m/Order) by their IDs.
     *
     * If a given order ID does not exist, the ID is ignored instead of generating an error.
     *
     * @param BatchRetrieveOrdersRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchRetrieveOrders(BatchRetrieveOrdersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders/batch-retrieve')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchRetrieveOrdersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Enables applications to preview order pricing without creating an order.
     *
     * @param CalculateOrderRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function calculateOrder(CalculateOrderRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders/calculate')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CalculateOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a new order, in the `DRAFT` state, by duplicating an existing order. The newly created order
     * has
     * only the core fields (such as line items, taxes, and discounts) copied from the original order.
     *
     * @param CloneOrderRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function cloneOrder(CloneOrderRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders/clone')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CloneOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Search all orders for one or more locations. Orders include all sales,
     * returns, and exchanges regardless of how or when they entered the Square
     * ecosystem (such as Point of Sale, Invoices, and Connect APIs).
     *
     * `SearchOrders` requests need to specify which locations to search and define a
     * [SearchOrdersQuery]($m/SearchOrdersQuery) object that controls
     * how to sort or filter the results. Your `SearchOrdersQuery` can:
     *
     * Set filter criteria.
     * Set the sort order.
     * Determine whether to return results as complete `Order` objects or as
     * [OrderEntry]($m/OrderEntry) objects.
     *
     * Note that details for orders processed with Square Point of Sale while in
     * offline mode might not be transmitted to Square for up to 72 hours. Offline
     * orders have a `created_at` value that reflects the time the order was created,
     * not the time it was subsequently transmitted to Square.
     *
     * @param SearchOrdersRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchOrders(SearchOrdersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchOrdersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves an [Order]($m/Order) by ID.
     *
     * @param string $orderId The ID of the order to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveOrder(string $orderId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/orders/{order_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('order_id', $orderId));

        $_resHandler = $this->responseHandler()->type(RetrieveOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates an open [order]($m/Order) by adding, replacing, or deleting
     * fields. Orders with a `COMPLETED` or `CANCELED` state cannot be updated.
     *
     * An `UpdateOrder` request requires the following:
     *
     * - The `order_id` in the endpoint path, identifying the order to update.
     * - The latest `version` of the order to update.
     * - The [sparse order](https://developer.squareup.com/docs/orders-api/manage-orders/update-
     * orders#sparse-order-objects)
     * containing only the fields to update and the version to which the update is
     * being applied.
     * - If deleting fields, the [dot notation paths](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders#identifying-fields-to-delete)
     * identifying the fields to clear.
     *
     * To pay for an order, see
     * [Pay for Orders](https://developer.squareup.com/docs/orders-api/pay-for-orders).
     *
     * @param string $orderId The ID of the order to update.
     * @param UpdateOrderRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateOrder(string $orderId, UpdateOrderRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/orders/{order_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('order_id', $orderId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Pay for an [order]($m/Order) using one or more approved [payments]($m/Payment)
     * or settle an order with a total of `0`.
     *
     * The total of the `payment_ids` listed in the request must be equal to the order
     * total. Orders with a total amount of `0` can be marked as paid by specifying an empty
     * array of `payment_ids` in the request.
     *
     * To be used with `PayOrder`, a payment must:
     *
     * - Reference the order by specifying the `order_id` when [creating the
     * payment]($e/Payments/CreatePayment).
     * Any approved payments that reference the same `order_id` not specified in the
     * `payment_ids` is canceled.
     * - Be approved with [delayed capture](https://developer.squareup.com/docs/payments-api/take-
     * payments/card-payments/delayed-capture).
     * Using a delayed capture payment with `PayOrder` completes the approved payment.
     *
     * @param string $orderId The ID of the order being paid.
     * @param PayOrderRequest $body An object containing the fields to POST for the request. See the
     *        corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function payOrder(string $orderId, PayOrderRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/orders/{order_id}/pay')
            ->auth('global')
            ->parameters(
                TemplateParam::init('order_id', $orderId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(PayOrderResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
