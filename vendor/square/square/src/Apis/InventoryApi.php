<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BatchChangeInventoryRequest;
use Square\Models\BatchChangeInventoryResponse;
use Square\Models\BatchRetrieveInventoryChangesRequest;
use Square\Models\BatchRetrieveInventoryChangesResponse;
use Square\Models\BatchRetrieveInventoryCountsRequest;
use Square\Models\BatchRetrieveInventoryCountsResponse;
use Square\Models\RetrieveInventoryAdjustmentResponse;
use Square\Models\RetrieveInventoryChangesResponse;
use Square\Models\RetrieveInventoryCountResponse;
use Square\Models\RetrieveInventoryPhysicalCountResponse;
use Square\Models\RetrieveInventoryTransferResponse;

class InventoryApi extends BaseApi
{
    /**
     * Deprecated version of [RetrieveInventoryAdjustment](api-endpoint:Inventory-
     * RetrieveInventoryAdjustment) after the endpoint URL
     * is updated to conform to the standard convention.
     *
     * @deprecated
     *
     * @param string $adjustmentId ID of the [InventoryAdjustment](entity:InventoryAdjustment) to
     *        retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function deprecatedRetrieveInventoryAdjustment(string $adjustmentId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/inventory/adjustment/{adjustment_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('adjustment_id', $adjustmentId));

        $_resHandler = $this->responseHandler()->type(RetrieveInventoryAdjustmentResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns the [InventoryAdjustment]($m/InventoryAdjustment) object
     * with the provided `adjustment_id`.
     *
     * @param string $adjustmentId ID of the [InventoryAdjustment](entity:InventoryAdjustment) to
     *        retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveInventoryAdjustment(string $adjustmentId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/inventory/adjustments/{adjustment_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('adjustment_id', $adjustmentId));

        $_resHandler = $this->responseHandler()->type(RetrieveInventoryAdjustmentResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deprecated version of [BatchChangeInventory](api-endpoint:Inventory-BatchChangeInventory) after the
     * endpoint URL
     * is updated to conform to the standard convention.
     *
     * @deprecated
     *
     * @param BatchChangeInventoryRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function deprecatedBatchChangeInventory(BatchChangeInventoryRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/batch-change')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchChangeInventoryResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deprecated version of [BatchRetrieveInventoryChanges](api-endpoint:Inventory-
     * BatchRetrieveInventoryChanges) after the endpoint URL
     * is updated to conform to the standard convention.
     *
     * @deprecated
     *
     * @param BatchRetrieveInventoryChangesRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function deprecatedBatchRetrieveInventoryChanges(BatchRetrieveInventoryChangesRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/batch-retrieve-changes')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BatchRetrieveInventoryChangesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deprecated version of [BatchRetrieveInventoryCounts](api-endpoint:Inventory-
     * BatchRetrieveInventoryCounts) after the endpoint URL
     * is updated to conform to the standard convention.
     *
     * @deprecated
     *
     * @param BatchRetrieveInventoryCountsRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function deprecatedBatchRetrieveInventoryCounts(BatchRetrieveInventoryCountsRequest $body): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/batch-retrieve-counts')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BatchRetrieveInventoryCountsResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Applies adjustments and counts to the provided item quantities.
     *
     * On success: returns the current calculated counts for all objects
     * referenced in the request.
     * On failure: returns a list of related errors.
     *
     * @param BatchChangeInventoryRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchChangeInventory(BatchChangeInventoryRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/changes/batch-create')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchChangeInventoryResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns historical physical counts and adjustments based on the
     * provided filter criteria.
     *
     * Results are paginated and sorted in ascending order according their
     * `occurred_at` timestamp (oldest first).
     *
     * BatchRetrieveInventoryChanges is a catch-all query endpoint for queries
     * that cannot be handled by other, simpler endpoints.
     *
     * @param BatchRetrieveInventoryChangesRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchRetrieveInventoryChanges(BatchRetrieveInventoryChangesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/changes/batch-retrieve')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BatchRetrieveInventoryChangesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns current counts for the provided
     * [CatalogObject]($m/CatalogObject)s at the requested
     * [Location]($m/Location)s.
     *
     * Results are paginated and sorted in descending order according to their
     * `calculated_at` timestamp (newest first).
     *
     * When `updated_after` is specified, only counts that have changed since that
     * time (based on the server timestamp for the most recent change) are
     * returned. This allows clients to perform a "sync" operation, for example
     * in response to receiving a Webhook notification.
     *
     * @param BatchRetrieveInventoryCountsRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchRetrieveInventoryCounts(BatchRetrieveInventoryCountsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/inventory/counts/batch-retrieve')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BatchRetrieveInventoryCountsResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deprecated version of [RetrieveInventoryPhysicalCount](api-endpoint:Inventory-
     * RetrieveInventoryPhysicalCount) after the endpoint URL
     * is updated to conform to the standard convention.
     *
     * @deprecated
     *
     * @param string $physicalCountId ID of the
     *        [InventoryPhysicalCount](entity:InventoryPhysicalCount) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function deprecatedRetrieveInventoryPhysicalCount(string $physicalCountId): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/inventory/physical-count/{physical_count_id}'
        )->auth('global')->parameters(TemplateParam::init('physical_count_id', $physicalCountId));

        $_resHandler = $this->responseHandler()
            ->type(RetrieveInventoryPhysicalCountResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns the [InventoryPhysicalCount]($m/InventoryPhysicalCount)
     * object with the provided `physical_count_id`.
     *
     * @param string $physicalCountId ID of the
     *        [InventoryPhysicalCount](entity:InventoryPhysicalCount) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveInventoryPhysicalCount(string $physicalCountId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/inventory/physical-counts/{physical_count_id}'
        )->auth('global')->parameters(TemplateParam::init('physical_count_id', $physicalCountId));

        $_resHandler = $this->responseHandler()
            ->type(RetrieveInventoryPhysicalCountResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns the [InventoryTransfer]($m/InventoryTransfer) object
     * with the provided `transfer_id`.
     *
     * @param string $transferId ID of the [InventoryTransfer](entity:InventoryTransfer) to
     *        retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveInventoryTransfer(string $transferId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/inventory/transfers/{transfer_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('transfer_id', $transferId));

        $_resHandler = $this->responseHandler()->type(RetrieveInventoryTransferResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves the current calculated stock count for a given
     * [CatalogObject]($m/CatalogObject) at a given set of
     * [Location]($m/Location)s. Responses are paginated and unsorted.
     * For more sophisticated queries, use a batch endpoint.
     *
     * @param string $catalogObjectId ID of the [CatalogObject](entity:CatalogObject) to retrieve.
     * @param string|null $locationIds The [Location](entity:Location) IDs to look up as a
     *        comma-separated
     *        list. An empty list queries all locations.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for the original query.
     *
     *        See the [Pagination](https://developer.squareup.com/docs/working-with-
     *        apis/pagination) guide for more information.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveInventoryCount(
        string $catalogObjectId,
        ?string $locationIds = null,
        ?string $cursor = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/inventory/{catalog_object_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('catalog_object_id', $catalogObjectId),
                QueryParam::init('location_ids', $locationIds),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveInventoryCountResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a set of physical counts and inventory adjustments for the
     * provided [CatalogObject](entity:CatalogObject) at the requested
     * [Location](entity:Location)s.
     *
     * You can achieve the same result by calling [BatchRetrieveInventoryChanges](api-endpoint:Inventory-
     * BatchRetrieveInventoryChanges)
     * and having the `catalog_object_ids` list contain a single element of the `CatalogObject` ID.
     *
     * Results are paginated and sorted in descending order according to their
     * `occurred_at` timestamp (newest first).
     *
     * There are no limits on how far back the caller can page. This endpoint can be
     * used to display recent changes for a specific item. For more
     * sophisticated queries, use a batch endpoint.
     *
     * @deprecated
     *
     * @param string $catalogObjectId ID of the [CatalogObject](entity:CatalogObject) to retrieve.
     * @param string|null $locationIds The [Location](entity:Location) IDs to look up as a
     *        comma-separated
     *        list. An empty list queries all locations.
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for the original query.
     *
     *        See the [Pagination](https://developer.squareup.com/docs/working-with-
     *        apis/pagination) guide for more information.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveInventoryChanges(
        string $catalogObjectId,
        ?string $locationIds = null,
        ?string $cursor = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/inventory/{catalog_object_id}/changes')
            ->auth('global')
            ->parameters(
                TemplateParam::init('catalog_object_id', $catalogObjectId),
                QueryParam::init('location_ids', $locationIds),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveInventoryChangesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
