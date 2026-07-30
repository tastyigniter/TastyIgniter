<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateWebhookSubscriptionRequest;
use Square\Models\CreateWebhookSubscriptionResponse;
use Square\Models\DeleteWebhookSubscriptionResponse;
use Square\Models\ListWebhookEventTypesResponse;
use Square\Models\ListWebhookSubscriptionsResponse;
use Square\Models\RetrieveWebhookSubscriptionResponse;
use Square\Models\TestWebhookSubscriptionRequest;
use Square\Models\TestWebhookSubscriptionResponse;
use Square\Models\UpdateWebhookSubscriptionRequest;
use Square\Models\UpdateWebhookSubscriptionResponse;
use Square\Models\UpdateWebhookSubscriptionSignatureKeyRequest;
use Square\Models\UpdateWebhookSubscriptionSignatureKeyResponse;

class WebhookSubscriptionsApi extends BaseApi
{
    /**
     * Lists all webhook event types that can be subscribed to.
     *
     * @param string|null $apiVersion The API version for which to list event types. Setting this
     *        field overrides the default version used by the application.
     *
     * @return ApiResponse Response from the API call
     */
    public function listWebhookEventTypes(?string $apiVersion = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/webhooks/event-types')
            ->auth('global')
            ->parameters(QueryParam::init('api_version', $apiVersion));

        $_resHandler = $this->responseHandler()->type(ListWebhookEventTypesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists all webhook subscriptions owned by your application.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for your original query.
     *
     *        For more information, see [Pagination](https://developer.squareup.
     *        com/docs/basics/api101/pagination).
     * @param bool|null $includeDisabled Includes disabled
     *        [Subscription](entity:WebhookSubscription)s.
     *        By default, all enabled [Subscription](entity:WebhookSubscription)s are returned.
     * @param string|null $sortOrder Sorts the returned list by when the
     *        [Subscription](entity:WebhookSubscription) was created with the specified order.
     *        This field defaults to ASC.
     * @param int|null $limit The maximum number of results to be returned in a single page. It is
     *        possible to receive fewer results than the specified limit on a given page.
     *        The default value of 100 is also the maximum allowed value.
     *
     *        Default: 100
     *
     * @return ApiResponse Response from the API call
     */
    public function listWebhookSubscriptions(
        ?string $cursor = null,
        ?bool $includeDisabled = false,
        ?string $sortOrder = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/webhooks/subscriptions')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('include_disabled', $includeDisabled),
                QueryParam::init('sort_order', $sortOrder),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListWebhookSubscriptionsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a webhook subscription.
     *
     * @param CreateWebhookSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createWebhookSubscription(CreateWebhookSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/webhooks/subscriptions')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateWebhookSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a webhook subscription.
     *
     * @param string $subscriptionId [REQUIRED] The ID of the
     *        [Subscription](entity:WebhookSubscription) to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteWebhookSubscription(string $subscriptionId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/webhooks/subscriptions/{subscription_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('subscription_id', $subscriptionId));

        $_resHandler = $this->responseHandler()->type(DeleteWebhookSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a webhook subscription identified by its ID.
     *
     * @param string $subscriptionId [REQUIRED] The ID of the
     *        [Subscription](entity:WebhookSubscription) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveWebhookSubscription(string $subscriptionId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/webhooks/subscriptions/{subscription_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('subscription_id', $subscriptionId));

        $_resHandler = $this->responseHandler()->type(RetrieveWebhookSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a webhook subscription.
     *
     * @param string $subscriptionId [REQUIRED] The ID of the
     *        [Subscription](entity:WebhookSubscription) to update.
     * @param UpdateWebhookSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateWebhookSubscription(
        string $subscriptionId,
        UpdateWebhookSubscriptionRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/webhooks/subscriptions/{subscription_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateWebhookSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a webhook subscription by replacing the existing signature key with a new one.
     *
     * @param string $subscriptionId [REQUIRED] The ID of the
     *        [Subscription](entity:WebhookSubscription) to update.
     * @param UpdateWebhookSubscriptionSignatureKeyRequest $body An object containing the fields to
     *        POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateWebhookSubscriptionSignatureKey(
        string $subscriptionId,
        UpdateWebhookSubscriptionSignatureKeyRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/webhooks/subscriptions/{subscription_id}/signature-key'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()
            ->type(UpdateWebhookSubscriptionSignatureKeyResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Tests a webhook subscription by sending a test event to the notification URL.
     *
     * @param string $subscriptionId [REQUIRED] The ID of the
     *        [Subscription](entity:WebhookSubscription) to test.
     * @param TestWebhookSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function testWebhookSubscription(string $subscriptionId, TestWebhookSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/webhooks/subscriptions/{subscription_id}/test'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(TestWebhookSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
