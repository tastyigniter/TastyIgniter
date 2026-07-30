<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\AddGroupToCustomerResponse;
use Square\Models\CreateCustomerCardRequest;
use Square\Models\CreateCustomerCardResponse;
use Square\Models\CreateCustomerRequest;
use Square\Models\CreateCustomerResponse;
use Square\Models\DeleteCustomerCardResponse;
use Square\Models\DeleteCustomerResponse;
use Square\Models\ListCustomersResponse;
use Square\Models\RemoveGroupFromCustomerResponse;
use Square\Models\RetrieveCustomerResponse;
use Square\Models\SearchCustomersRequest;
use Square\Models\SearchCustomersResponse;
use Square\Models\UpdateCustomerRequest;
use Square\Models\UpdateCustomerResponse;

class CustomersApi extends BaseApi
{
    /**
     * Lists customer profiles associated with a Square account.
     *
     * Under normal operating conditions, newly created or updated customer profiles become available
     * for the listing operation in well under 30 seconds. Occasionally, propagation of the new or updated
     * profiles can take closer to one minute or longer, especially during network incidents and outages.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this cursor to retrieve the next set of results for your original query.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param int|null $limit The maximum number of results to return in a single page. This limit
     *        is advisory. The response might contain more or fewer results.
     *        If the specified limit is less than 1 or greater than 100, Square returns a `400
     *        VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 100.
     *
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param string|null $sortField Indicates how customers should be sorted. The default value is
     *        `DEFAULT`.
     * @param string|null $sortOrder Indicates whether customers should be sorted in ascending
     *        (`ASC`) or
     *        descending (`DESC`) order.
     *
     *        The default value is `ASC`.
     *
     * @return ApiResponse Response from the API call
     */
    public function listCustomers(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $sortField = null,
        ?string $sortOrder = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/customers')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit),
                QueryParam::init('sort_field', $sortField),
                QueryParam::init('sort_order', $sortOrder)
            );

        $_resHandler = $this->responseHandler()->type(ListCustomersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a new customer for a business.
     *
     * You must provide at least one of the following values in your request to this
     * endpoint:
     *
     * - `given_name`
     * - `family_name`
     * - `company_name`
     * - `email_address`
     * - `phone_number`
     *
     * @param CreateCustomerRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createCustomer(CreateCustomerRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/customers')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches the customer profiles associated with a Square account using one or more supported query
     * filters.
     *
     * Calling `SearchCustomers` without any explicit query filter returns all
     * customer profiles ordered alphabetically based on `given_name` and
     * `family_name`.
     *
     * Under normal operating conditions, newly created or updated customer profiles become available
     * for the search operation in well under 30 seconds. Occasionally, propagation of the new or updated
     * profiles can take closer to one minute or longer, especially during network incidents and outages.
     *
     * @param SearchCustomersRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchCustomers(SearchCustomersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/customers/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchCustomersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a customer profile from a business. This operation also unlinks any associated cards on file.
     *
     *
     * As a best practice, include the `version` field in the request to enable [optimistic
     * concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-
     * concurrency) control.
     * If included, the value must be set to the current version of the customer profile.
     *
     * To delete a customer profile that was created by merging existing profiles, you must use the ID of
     * the newly created profile.
     *
     * @param string $customerId The ID of the customer to delete.
     * @param int|null $version The current version of the customer profile. As a best practice, you
     *        should include this parameter to enable [optimistic concurrency](https://developer.
     *        squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control.
     *        For more information, see [Delete a customer profile](https://developer.squareup.
     *        com/docs/customers-api/use-the-api/keep-records#delete-customer-profile).
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteCustomer(string $customerId, ?int $version = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/customers/{customer_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('customer_id', $customerId), QueryParam::init('version', $version));

        $_resHandler = $this->responseHandler()->type(DeleteCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns details for a single customer.
     *
     * @param string $customerId The ID of the customer to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveCustomer(string $customerId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/customers/{customer_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('customer_id', $customerId));

        $_resHandler = $this->responseHandler()->type(RetrieveCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a customer profile. This endpoint supports sparse updates, so only new or changed fields are
     * required in the request.
     * To add or update a field, specify the new value. To remove a field, specify `null` and include the
     * `X-Clear-Null` header set to `true`
     * (recommended) or specify an empty string (string fields only).
     *
     * As a best practice, include the `version` field in the request to enable [optimistic
     * concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-
     * concurrency) control.
     * If included, the value must be set to the current version of the customer profile.
     *
     * To update a customer profile that was created by merging existing profiles, you must use the ID of
     * the newly created profile.
     *
     * You cannot use this endpoint to change cards on file. To make changes, use the [Cards API]($e/Cards)
     * or [Gift Cards API]($e/GiftCards).
     *
     * @param string $customerId The ID of the customer to update.
     * @param UpdateCustomerRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateCustomer(string $customerId, UpdateCustomerRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/customers/{customer_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('customer_id', $customerId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Adds a card on file to an existing customer.
     *
     * As with charges, calls to `CreateCustomerCard` are idempotent. Multiple
     * calls with the same card nonce return the same card record that was created
     * with the provided nonce during the _first_ call.
     *
     * @deprecated
     *
     * @param string $customerId The Square ID of the customer profile the card is linked to.
     * @param CreateCustomerCardRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createCustomerCard(string $customerId, CreateCustomerCardRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/customers/{customer_id}/cards')
            ->auth('global')
            ->parameters(
                TemplateParam::init('customer_id', $customerId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(CreateCustomerCardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Removes a card on file from a customer.
     *
     * @deprecated
     *
     * @param string $customerId The ID of the customer that the card on file belongs to.
     * @param string $cardId The ID of the card on file to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteCustomerCard(string $customerId, string $cardId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/customers/{customer_id}/cards/{card_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('customer_id', $customerId), TemplateParam::init('card_id', $cardId));

        $_resHandler = $this->responseHandler()->type(DeleteCustomerCardResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Removes a group membership from a customer.
     *
     * The customer is identified by the `customer_id` value
     * and the customer group is identified by the `group_id` value.
     *
     * @param string $customerId The ID of the customer to remove from the group.
     * @param string $groupId The ID of the customer group to remove the customer from.
     *
     * @return ApiResponse Response from the API call
     */
    public function removeGroupFromCustomer(string $customerId, string $groupId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/customers/{customer_id}/groups/{group_id}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('customer_id', $customerId),
                TemplateParam::init('group_id', $groupId)
            );

        $_resHandler = $this->responseHandler()->type(RemoveGroupFromCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Adds a group membership to a customer.
     *
     * The customer is identified by the `customer_id` value
     * and the customer group is identified by the `group_id` value.
     *
     * @param string $customerId The ID of the customer to add to a group.
     * @param string $groupId The ID of the customer group to add the customer to.
     *
     * @return ApiResponse Response from the API call
     */
    public function addGroupToCustomer(string $customerId, string $groupId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/customers/{customer_id}/groups/{group_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('customer_id', $customerId),
                TemplateParam::init('group_id', $groupId)
            );

        $_resHandler = $this->responseHandler()->type(AddGroupToCustomerResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
