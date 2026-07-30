<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateCheckoutRequest;
use Square\Models\CreateCheckoutResponse;
use Square\Models\CreatePaymentLinkRequest;
use Square\Models\CreatePaymentLinkResponse;
use Square\Models\DeletePaymentLinkResponse;
use Square\Models\ListPaymentLinksResponse;
use Square\Models\RetrievePaymentLinkResponse;
use Square\Models\UpdatePaymentLinkRequest;
use Square\Models\UpdatePaymentLinkResponse;

class CheckoutApi extends BaseApi
{
    /**
     * Links a `checkoutId` to a `checkout_page_url` that customers are
     * directed to in order to provide their payment information using a
     * payment processing workflow hosted on connect.squareup.com.
     *
     *
     * NOTE: The Checkout API has been updated with new features.
     * For more information, see [Checkout API highlights](https://developer.squareup.com/docs/checkout-
     * api#checkout-api-highlights).
     * We recommend that you use the new [CreatePaymentLink](api-endpoint:Checkout-CreatePaymentLink)
     * endpoint in place of this previously released endpoint.
     *
     * @deprecated
     *
     * @param string $locationId The ID of the business location to associate the checkout with.
     * @param CreateCheckoutRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createCheckout(string $locationId, CreateCheckoutRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/locations/{location_id}/checkouts')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CreateCheckoutResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists all payment links.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for the original query.
     *        If a cursor is not provided, the endpoint returns the first page of the results.
     *        For more  information, see [Pagination](https://developer.squareup.
     *        com/docs/basics/api101/pagination).
     * @param int|null $limit A limit on the number of results to return per page. The limit is
     *        advisory and
     *        the implementation might return more or less results. If the supplied limit is
     *        negative, zero, or
     *        greater than the maximum limit of 1000, it is ignored.
     *
     *        Default value: `100`
     *
     * @return ApiResponse Response from the API call
     */
    public function listPaymentLinks(?string $cursor = null, ?int $limit = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/online-checkout/payment-links')
            ->auth('global')
            ->parameters(QueryParam::init('cursor', $cursor), QueryParam::init('limit', $limit));

        $_resHandler = $this->responseHandler()->type(ListPaymentLinksResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a Square-hosted checkout page. Applications can share the resulting payment link with their
     * buyer to pay for goods and services.
     *
     * @param CreatePaymentLinkRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createPaymentLink(CreatePaymentLinkRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/online-checkout/payment-links')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreatePaymentLinkResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a payment link.
     *
     * @param string $id The ID of the payment link to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deletePaymentLink(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/online-checkout/payment-links/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(DeletePaymentLinkResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a payment link.
     *
     * @param string $id The ID of link to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrievePaymentLink(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/online-checkout/payment-links/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(RetrievePaymentLinkResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a payment link. You can update the `payment_link` fields such as
     * `description`, `checkout_options`, and  `pre_populated_data`.
     * You cannot update other fields such as the `order_id`, `version`, `URL`, or `timestamp` field.
     *
     * @param string $id The ID of the payment link to update.
     * @param UpdatePaymentLinkRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updatePaymentLink(string $id, UpdatePaymentLinkRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/online-checkout/payment-links/{id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('id', $id),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdatePaymentLinkResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
