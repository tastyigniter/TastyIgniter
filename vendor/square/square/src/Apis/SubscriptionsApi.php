<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CancelSubscriptionResponse;
use Square\Models\CreateSubscriptionRequest;
use Square\Models\CreateSubscriptionResponse;
use Square\Models\DeleteSubscriptionActionResponse;
use Square\Models\ListSubscriptionEventsResponse;
use Square\Models\PauseSubscriptionRequest;
use Square\Models\PauseSubscriptionResponse;
use Square\Models\ResumeSubscriptionRequest;
use Square\Models\ResumeSubscriptionResponse;
use Square\Models\RetrieveSubscriptionResponse;
use Square\Models\SearchSubscriptionsRequest;
use Square\Models\SearchSubscriptionsResponse;
use Square\Models\SwapPlanRequest;
use Square\Models\SwapPlanResponse;
use Square\Models\UpdateSubscriptionRequest;
use Square\Models\UpdateSubscriptionResponse;

class SubscriptionsApi extends BaseApi
{
    /**
     * Creates a subscription to a subscription plan by a customer.
     *
     * If you provide a card on file in the request, Square charges the card for
     * the subscription. Otherwise, Square bills an invoice to the customer's email
     * address. The subscription starts immediately, unless the request includes
     * the optional `start_date`. Each individual subscription is associated with a particular location.
     *
     * @param CreateSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createSubscription(CreateSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for subscriptions.
     *
     * Results are ordered chronologically by subscription creation date. If
     * the request specifies more than one location ID,
     * the endpoint orders the result
     * by location ID, and then by creation date within each location. If no locations are given
     * in the query, all locations are searched.
     *
     * You can also optionally specify `customer_ids` to search by customer.
     * If left unset, all customers
     * associated with the specified locations are returned.
     * If the request specifies customer IDs, the endpoint orders results
     * first by location, within location by customer ID, and within
     * customer by subscription creation date.
     *
     * For more information, see
     * [Retrieve subscriptions](https://developer.squareup.com/docs/subscriptions-api/overview#retrieve-
     * subscriptions).
     *
     * @param SearchSubscriptionsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchSubscriptions(SearchSubscriptionsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchSubscriptionsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a subscription.
     *
     * @param string $subscriptionId The ID of the subscription to retrieve.
     * @param string|null $mInclude A query parameter to specify related information to be included
     *        in the response.
     *
     *        The supported query parameter values are:
     *
     *        - `actions`: to include scheduled actions on the targeted subscription.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveSubscription(string $subscriptionId, ?string $mInclude = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/subscriptions/{subscription_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                QueryParam::init('include', $mInclude)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a subscription. You can set, modify, and clear the
     * `subscription` field values.
     *
     * @param string $subscriptionId The ID of the subscription to update.
     * @param UpdateSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateSubscription(string $subscriptionId, UpdateSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/subscriptions/{subscription_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a scheduled action for a subscription.
     *
     * @param string $subscriptionId The ID of the subscription the targeted action is to act upon.
     * @param string $actionId The ID of the targeted action to be deleted.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteSubscriptionAction(string $subscriptionId, string $actionId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/subscriptions/{subscription_id}/actions/{action_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                TemplateParam::init('action_id', $actionId)
            );

        $_resHandler = $this->responseHandler()->type(DeleteSubscriptionActionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Schedules a `CANCEL` action to cancel an active subscription
     * by setting the `canceled_date` field to the end of the active billing period
     * and changing the subscription status from ACTIVE to CANCELED after this date.
     *
     * @param string $subscriptionId The ID of the subscription to cancel.
     *
     * @return ApiResponse Response from the API call
     */
    public function cancelSubscription(string $subscriptionId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions/{subscription_id}/cancel')
            ->auth('global')
            ->parameters(TemplateParam::init('subscription_id', $subscriptionId));

        $_resHandler = $this->responseHandler()->type(CancelSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists all events for a specific subscription.
     *
     * @param string $subscriptionId The ID of the subscription to retrieve the events for.
     * @param string|null $cursor When the total number of resulting subscription events exceeds the
     *        limit of a paged response,
     *        specify the cursor returned from a preceding response here to fetch the next set of
     *        results.
     *        If the cursor is unset, the response contains the last page of the results.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/working-
     *        with-apis/pagination).
     * @param int|null $limit The upper limit on the number of subscription events to return in a
     *        paged response.
     *
     * @return ApiResponse Response from the API call
     */
    public function listSubscriptionEvents(
        string $subscriptionId,
        ?string $cursor = null,
        ?int $limit = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/subscriptions/{subscription_id}/events')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit)
            );

        $_resHandler = $this->responseHandler()->type(ListSubscriptionEventsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Schedules a `PAUSE` action to pause an active subscription.
     *
     * @param string $subscriptionId The ID of the subscription to pause.
     * @param PauseSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function pauseSubscription(string $subscriptionId, PauseSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions/{subscription_id}/pause')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(PauseSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Schedules a `RESUME` action to resume a paused or a deactivated subscription.
     *
     * @param string $subscriptionId The ID of the subscription to resume.
     * @param ResumeSubscriptionRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function resumeSubscription(string $subscriptionId, ResumeSubscriptionRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions/{subscription_id}/resume')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(ResumeSubscriptionResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Schedules a `SWAP_PLAN` action to swap a subscription plan in an existing subscription.
     *
     * @param string $subscriptionId The ID of the subscription to swap the subscription plan for.
     * @param SwapPlanRequest $body An object containing the fields to POST for the request. See the
     *        corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function swapPlan(string $subscriptionId, SwapPlanRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/subscriptions/{subscription_id}/swap-plan')
            ->auth('global')
            ->parameters(
                TemplateParam::init('subscription_id', $subscriptionId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(SwapPlanResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
