<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\FormParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BatchDeleteCatalogObjectsRequest;
use Square\Models\BatchDeleteCatalogObjectsResponse;
use Square\Models\BatchRetrieveCatalogObjectsRequest;
use Square\Models\BatchRetrieveCatalogObjectsResponse;
use Square\Models\BatchUpsertCatalogObjectsRequest;
use Square\Models\BatchUpsertCatalogObjectsResponse;
use Square\Models\CatalogInfoResponse;
use Square\Models\CreateCatalogImageRequest;
use Square\Models\CreateCatalogImageResponse;
use Square\Models\DeleteCatalogObjectResponse;
use Square\Models\ListCatalogResponse;
use Square\Models\RetrieveCatalogObjectResponse;
use Square\Models\SearchCatalogItemsRequest;
use Square\Models\SearchCatalogItemsResponse;
use Square\Models\SearchCatalogObjectsRequest;
use Square\Models\SearchCatalogObjectsResponse;
use Square\Models\UpdateCatalogImageRequest;
use Square\Models\UpdateCatalogImageResponse;
use Square\Models\UpdateItemModifierListsRequest;
use Square\Models\UpdateItemModifierListsResponse;
use Square\Models\UpdateItemTaxesRequest;
use Square\Models\UpdateItemTaxesResponse;
use Square\Models\UpsertCatalogObjectRequest;
use Square\Models\UpsertCatalogObjectResponse;
use Square\Utils\FileWrapper;

class CatalogApi extends BaseApi
{
    /**
     * Deletes a set of [CatalogItem]($m/CatalogItem)s based on the
     * provided list of target IDs and returns a set of successfully deleted IDs in
     * the response. Deletion is a cascading event such that all children of the
     * targeted object are also deleted. For example, deleting a CatalogItem will
     * also delete all of its [CatalogItemVariation]($m/CatalogItemVariation)
     * children.
     *
     * `BatchDeleteCatalogObjects` succeeds even if only a portion of the targeted
     * IDs can be deleted. The response will only include IDs that were
     * actually deleted.
     *
     * To ensure consistency, only one delete request is processed at a time per seller account.
     * While one (batch or non-batch) delete request is being processed, other (batched and non-batched)
     * delete requests are rejected with the `429` error code.
     *
     * @param BatchDeleteCatalogObjectsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchDeleteCatalogObjects(BatchDeleteCatalogObjectsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/batch-delete')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchDeleteCatalogObjectsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a set of objects based on the provided ID.
     * Each [CatalogItem]($m/CatalogItem) returned in the set includes all of its
     * child information including: all of its
     * [CatalogItemVariation]($m/CatalogItemVariation) objects, references to
     * its [CatalogModifierList]($m/CatalogModifierList) objects, and the ids of
     * any [CatalogTax]($m/CatalogTax) objects that apply to it.
     *
     * @param BatchRetrieveCatalogObjectsRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchRetrieveCatalogObjects(BatchRetrieveCatalogObjectsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/batch-retrieve')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchRetrieveCatalogObjectsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates or updates up to 10,000 target objects based on the provided
     * list of objects. The target objects are grouped into batches and each batch is
     * inserted/updated in an all-or-nothing manner. If an object within a batch is
     * malformed in some way, or violates a database constraint, the entire batch
     * containing that item will be disregarded. However, other batches in the same
     * request may still succeed. Each batch may contain up to 1,000 objects, and
     * batches will be processed in order as long as the total object count for the
     * request (items, variations, modifier lists, discounts, and taxes) is no more
     * than 10,000.
     *
     * To ensure consistency, only one update request is processed at a time per seller account.
     * While one (batch or non-batch) update request is being processed, other (batched and non-batched)
     * update requests are rejected with the `429` error code.
     *
     * @param BatchUpsertCatalogObjectsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function batchUpsertCatalogObjects(BatchUpsertCatalogObjectsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/batch-upsert')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BatchUpsertCatalogObjectsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Uploads an image file to be represented by a [CatalogImage]($m/CatalogImage) object that can be
     * linked to an existing
     * [CatalogObject]($m/CatalogObject) instance. The resulting `CatalogImage` is unattached to any
     * `CatalogObject` if the `object_id`
     * is not specified.
     *
     * This `CreateCatalogImage` endpoint accepts HTTP multipart/form-data requests with a JSON part and an
     * image file part in
     * JPEG, PJPEG, PNG, or GIF format. The maximum file size is 15MB.
     *
     * @param CreateCatalogImageRequest|null $request
     * @param FileWrapper|null $imageFile
     *
     * @return ApiResponse Response from the API call
     */
    public function createCatalogImage(
        ?CreateCatalogImageRequest $request = null,
        ?FileWrapper $imageFile = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/images')
            ->auth('global')
            ->parameters(
                FormParam::init('request', $request)
                    ->encodingHeader('Content-Type', 'application/json; charset=utf-8'),
                FormParam::init('image_file', $imageFile)->encodingHeader('Content-Type', 'image/jpeg')
            );

        $_resHandler = $this->responseHandler()->type(CreateCatalogImageResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Uploads a new image file to replace the existing one in the specified
     * [CatalogImage]($m/CatalogImage) object.
     *
     * This `UpdateCatalogImage` endpoint accepts HTTP multipart/form-data requests with a JSON part and an
     * image file part in
     * JPEG, PJPEG, PNG, or GIF format. The maximum file size is 15MB.
     *
     * @param string $imageId The ID of the `CatalogImage` object to update the encapsulated image
     *        file.
     * @param UpdateCatalogImageRequest|null $request
     * @param FileWrapper|null $imageFile
     *
     * @return ApiResponse Response from the API call
     */
    public function updateCatalogImage(
        string $imageId,
        ?UpdateCatalogImageRequest $request = null,
        ?FileWrapper $imageFile = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/catalog/images/{image_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('image_id', $imageId),
                FormParam::init('request', $request)
                    ->encodingHeader('Content-Type', 'application/json; charset=utf-8'),
                FormParam::init('image_file', $imageFile)->encodingHeader('Content-Type', 'image/jpeg')
            );

        $_resHandler = $this->responseHandler()->type(UpdateCatalogImageResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves information about the Square Catalog API, such as batch size
     * limits that can be used by the `BatchUpsertCatalogObjects` endpoint.
     *
     * @return ApiResponse Response from the API call
     */
    public function catalogInfo(): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/catalog/info')->auth('global');

        $_resHandler = $this->responseHandler()->type(CatalogInfoResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a list of all [CatalogObject]($m/CatalogObject)s of the specified types in the catalog.
     *
     * The `types` parameter is specified as a comma-separated list of the
     * [CatalogObjectType]($m/CatalogObjectType) values,
     * for example, "`ITEM`, `ITEM_VARIATION`, `MODIFIER`, `MODIFIER_LIST`, `CATEGORY`, `DISCOUNT`, `TAX`,
     * `IMAGE`".
     *
     * __Important:__ ListCatalog does not return deleted catalog items. To retrieve
     * deleted catalog items, use [SearchCatalogObjects]($e/Catalog/SearchCatalogObjects)
     * and set the `include_deleted_objects` attribute value to `true`.
     *
     * @param string|null $cursor The pagination cursor returned in the previous response. Leave
     *        unset for an initial request.
     *        The page size is currently set to be 100.
     *        See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-
     *        patterns/pagination) for more information.
     * @param string|null $types An optional case-insensitive, comma-separated list of object types
     *        to retrieve.
     *
     *        The valid values are defined in the [CatalogObjectType](entity:CatalogObjectType)
     *        enum, for example,
     *        `ITEM`, `ITEM_VARIATION`, `CATEGORY`, `DISCOUNT`, `TAX`,
     *        `MODIFIER`, `MODIFIER_LIST`, `IMAGE`, etc.
     *
     *        If this is unspecified, the operation returns objects of all the top level types at
     *        the version
     *        of the Square API used to make the request. Object types that are nested onto other
     *        object types
     *        are not included in the defaults.
     *
     *        At the current API version the default object types are:
     *        ITEM, CATEGORY, TAX, DISCOUNT, MODIFIER_LIST,
     *        PRICING_RULE, PRODUCT_SET, TIME_PERIOD, MEASUREMENT_UNIT,
     *        SUBSCRIPTION_PLAN, ITEM_OPTION, CUSTOM_ATTRIBUTE_DEFINITION, QUICK_AMOUNT_SETTINGS.
     * @param int|null $catalogVersion The specific version of the catalog objects to be included in
     *        the response.
     *        This allows you to retrieve historical versions of objects. The specified version
     *        value is matched against
     *        the [CatalogObject]($m/CatalogObject)s' `version` attribute.  If not included,
     *        results will be from the
     *        current version of the catalog.
     *
     * @return ApiResponse Response from the API call
     */
    public function listCatalog(
        ?string $cursor = null,
        ?string $types = null,
        ?int $catalogVersion = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/catalog/list')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('types', $types),
                QueryParam::init('catalog_version', $catalogVersion)
            );

        $_resHandler = $this->responseHandler()->type(ListCatalogResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a new or updates the specified [CatalogObject]($m/CatalogObject).
     *
     * To ensure consistency, only one update request is processed at a time per seller account.
     * While one (batch or non-batch) update request is being processed, other (batched and non-batched)
     * update requests are rejected with the `429` error code.
     *
     * @param UpsertCatalogObjectRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function upsertCatalogObject(UpsertCatalogObjectRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/object')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(UpsertCatalogObjectResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a single [CatalogObject]($m/CatalogObject) based on the
     * provided ID and returns the set of successfully deleted IDs in the response.
     * Deletion is a cascading event such that all children of the targeted object
     * are also deleted. For example, deleting a [CatalogItem]($m/CatalogItem)
     * will also delete all of its
     * [CatalogItemVariation]($m/CatalogItemVariation) children.
     *
     * To ensure consistency, only one delete request is processed at a time per seller account.
     * While one (batch or non-batch) delete request is being processed, other (batched and non-batched)
     * delete requests are rejected with the `429` error code.
     *
     * @param string $objectId The ID of the catalog object to be deleted. When an object is
     *        deleted, other
     *        objects in the graph that depend on that object will be deleted as well (for example,
     *        deleting a
     *        catalog item will delete its catalog item variations).
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteCatalogObject(string $objectId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/catalog/object/{object_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('object_id', $objectId));

        $_resHandler = $this->responseHandler()->type(DeleteCatalogObjectResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a single [CatalogItem]($m/CatalogItem) as a
     * [CatalogObject]($m/CatalogObject) based on the provided ID. The returned
     * object includes all of the relevant [CatalogItem]($m/CatalogItem)
     * information including: [CatalogItemVariation]($m/CatalogItemVariation)
     * children, references to its
     * [CatalogModifierList]($m/CatalogModifierList) objects, and the ids of
     * any [CatalogTax]($m/CatalogTax) objects that apply to it.
     *
     * @param string $objectId The object ID of any type of catalog objects to be retrieved.
     * @param bool|null $includeRelatedObjects If `true`, the response will include additional
     *        objects that are related to the
     *        requested objects. Related objects are defined as any objects referenced by ID by
     *        the results in the `objects` field
     *        of the response. These objects are put in the `related_objects` field. Setting this
     *        to `true` is
     *        helpful when the objects are needed for immediate display to a user.
     *        This process only goes one level deep. Objects referenced by the related objects
     *        will not be included. For example,
     *
     *        if the `objects` field of the response contains a CatalogItem, its associated
     *        CatalogCategory objects, CatalogTax objects, CatalogImage objects and
     *        CatalogModifierLists will be returned in the `related_objects` field of the
     *        response. If the `objects` field of the response contains a CatalogItemVariation,
     *        its parent CatalogItem will be returned in the `related_objects` field of
     *        the response.
     *
     *        Default value: `false`
     * @param int|null $catalogVersion Requests objects as of a specific version of the catalog.
     *        This allows you to retrieve historical
     *        versions of objects. The value to retrieve a specific version of an object can be
     *        found
     *        in the version field of [CatalogObject]($m/CatalogObject)s. If not included, results
     *        will
     *        be from the current version of the catalog.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveCatalogObject(
        string $objectId,
        ?bool $includeRelatedObjects = false,
        ?int $catalogVersion = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/catalog/object/{object_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('object_id', $objectId),
                QueryParam::init('include_related_objects', $includeRelatedObjects),
                QueryParam::init('catalog_version', $catalogVersion)
            );

        $_resHandler = $this->responseHandler()->type(RetrieveCatalogObjectResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for [CatalogObject]($m/CatalogObject) of any type by matching supported search attribute
     * values,
     * excluding custom attribute values on items or item variations, against one or more of the specified
     * query filters.
     *
     * This (`SearchCatalogObjects`) endpoint differs from the
     * [SearchCatalogItems]($e/Catalog/SearchCatalogItems)
     * endpoint in the following aspects:
     *
     * - `SearchCatalogItems` can only search for items or item variations, whereas `SearchCatalogObjects`
     * can search for any type of catalog objects.
     * - `SearchCatalogItems` supports the custom attribute query filters to return items or item
     * variations that contain custom attribute values, where `SearchCatalogObjects` does not.
     * - `SearchCatalogItems` does not support the `include_deleted_objects` filter to search for deleted
     * items or item variations, whereas `SearchCatalogObjects` does.
     * - The both endpoints have different call conventions, including the query filter formats.
     *
     * @param SearchCatalogObjectsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchCatalogObjects(SearchCatalogObjectsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchCatalogObjectsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for catalog items or item variations by matching supported search attribute values,
     * including
     * custom attribute values, against one or more of the specified query filters.
     *
     * This (`SearchCatalogItems`) endpoint differs from the
     * [SearchCatalogObjects]($e/Catalog/SearchCatalogObjects)
     * endpoint in the following aspects:
     *
     * - `SearchCatalogItems` can only search for items or item variations, whereas `SearchCatalogObjects`
     * can search for any type of catalog objects.
     * - `SearchCatalogItems` supports the custom attribute query filters to return items or item
     * variations that contain custom attribute values, where `SearchCatalogObjects` does not.
     * - `SearchCatalogItems` does not support the `include_deleted_objects` filter to search for deleted
     * items or item variations, whereas `SearchCatalogObjects` does.
     * - The both endpoints use different call conventions, including the query filter formats.
     *
     * @param SearchCatalogItemsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchCatalogItems(SearchCatalogItemsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/search-catalog-items')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchCatalogItemsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates the [CatalogModifierList]($m/CatalogModifierList) objects
     * that apply to the targeted [CatalogItem]($m/CatalogItem) without having
     * to perform an upsert on the entire item.
     *
     * @param UpdateItemModifierListsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateItemModifierLists(UpdateItemModifierListsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/update-item-modifier-lists')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(UpdateItemModifierListsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates the [CatalogTax]($m/CatalogTax) objects that apply to the
     * targeted [CatalogItem]($m/CatalogItem) without having to perform an
     * upsert on the entire item.
     *
     * @param UpdateItemTaxesRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateItemTaxes(UpdateItemTaxesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/catalog/update-item-taxes')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(UpdateItemTaxesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
