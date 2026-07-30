<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BulkDeleteLocationCustomAttributesRequest;
use Square\Models\BulkDeleteLocationCustomAttributesResponse;
use Square\Models\BulkUpsertLocationCustomAttributesRequest;
use Square\Models\BulkUpsertLocationCustomAttributesResponse;
use Square\Models\CreateLocationCustomAttributeDefinitionRequest;
use Square\Models\CreateLocationCustomAttributeDefinitionResponse;
use Square\Models\DeleteLocationCustomAttributeDefinitionResponse;
use Square\Models\DeleteLocationCustomAttributeResponse;
use Square\Models\ListLocationCustomAttributeDefinitionsResponse;
use Square\Models\ListLocationCustomAttributesResponse;
use Square\Models\RetrieveLocationCustomAttributeDefinitionResponse;
use Square\Models\RetrieveLocationCustomAttributeResponse;
use Square\Models\UpdateLocationCustomAttributeDefinitionRequest;
use Square\Models\UpdateLocationCustomAttributeDefinitionResponse;
use Square\Models\UpsertLocationCustomAttributeRequest;
use Square\Models\UpsertLocationCustomAttributeResponse;

class LocationCustomAttributesApi extends BaseApi
{
    /**
     * Lists the location-related [custom attribute definitions]($m/CustomAttributeDefinition) that belong
     * to a Square seller account.
     * When all response pages are retrieved, the results include all custom attribute definitions
     * that are visible to the requesting application, including those that are created by other
     * applications and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string|null $visibilityFilter Filters the `CustomAttributeDefinition` results by their
     *        `visibility` values.
     * @param int|null $limit The maximum number of results to return in a single paged response.
     *        This limit is advisory.
     *        The response might contain more or fewer results. The minimum value is 1 and the
     *        maximum value is 100.
     *        The default value is 20. For more information, see [Pagination](https://developer.
     *        squareup.com/docs/build-basics/common-api-patterns/pagination).
     * @param string|null $cursor The cursor returned in the paged response from the previous call
     *        to this endpoint.
     *        Provide this cursor to retrieve the next page of results for your original request.
     *        For more information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     *
     * @return ApiResponse Response from the API call
     */
    public function listLocationCustomAttributeDefinitions(
        ?string $visibilityFilter = null,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/locations/custom-attribute-definitions')
            ->auth('global')
            ->parameters(
                QueryParam::init('visibility_filter', $visibilityFilter),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()
            ->type(ListLocationCustomAttributeDefinitionsResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a location-related [custom attribute definition]($m/CustomAttributeDefinition) for a Square
     * seller account.
     * Use this endpoint to define a custom attribute that can be associated with locations.
     * A custom attribute definition specifies the `key`, `visibility`, `schema`, and other properties
     * for a custom attribute. After the definition is created, you can call
     * [UpsertLocationCustomAttribute]($e/LocationCustomAttributes/UpsertLocationCustomAttribute) or
     * [BulkUpsertLocationCustomAttributes]($e/LocationCustomAttributes/BulkUpsertLocationCustomAttributes)
     * to set the custom attribute for locations.
     *
     * @param CreateLocationCustomAttributeDefinitionRequest $body An object containing the fields
     *        to POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createLocationCustomAttributeDefinition(
        CreateLocationCustomAttributeDefinitionRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/locations/custom-attribute-definitions')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(CreateLocationCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a location-related [custom attribute definition]($m/CustomAttributeDefinition) from a Square
     * seller account.
     * Deleting a custom attribute definition also deletes the corresponding custom attribute from
     * all locations.
     * Only the definition owner can delete a custom attribute definition.
     *
     * @param string $key The key of the custom attribute definition to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteLocationCustomAttributeDefinition(string $key): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/locations/custom-attribute-definitions/{key}'
        )->auth('global')->parameters(TemplateParam::init('key', $key));

        $_resHandler = $this->responseHandler()
            ->type(DeleteLocationCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a location-related [custom attribute definition]($m/CustomAttributeDefinition) from a
     * Square seller account.
     * To retrieve a custom attribute definition created by another application, the `visibility`
     * setting must be `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string $key The key of the custom attribute definition to retrieve. If the requesting
     *        application
     *        is not the definition owner, you must use the qualified key.
     * @param int|null $version The current version of the custom attribute definition, which is
     *        used for strongly consistent
     *        reads to guarantee that you receive the most up-to-date data. When included in the
     *        request,
     *        Square returns the specified version or a higher version if one exists. If the
     *        specified version
     *        is higher than the current version, Square returns a `BAD_REQUEST` error.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLocationCustomAttributeDefinition(string $key, ?int $version = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/locations/custom-attribute-definitions/{key}'
        )->auth('global')->parameters(TemplateParam::init('key', $key), QueryParam::init('version', $version));

        $_resHandler = $this->responseHandler()
            ->type(RetrieveLocationCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a location-related [custom attribute definition]($m/CustomAttributeDefinition) for a Square
     * seller account.
     * Use this endpoint to update the following fields: `name`, `description`, `visibility`, or the
     * `schema` for a `Selection` data type.
     * Only the definition owner can update a custom attribute definition.
     *
     * @param string $key The key of the custom attribute definition to update.
     * @param UpdateLocationCustomAttributeDefinitionRequest $body An object containing the fields
     *        to POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateLocationCustomAttributeDefinition(
        string $key,
        UpdateLocationCustomAttributeDefinitionRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::PUT,
            '/v2/locations/custom-attribute-definitions/{key}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('key', $key),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()
            ->type(UpdateLocationCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes [custom attributes]($m/CustomAttribute) for locations as a bulk operation.
     * To delete a custom attribute owned by another application, the `visibility` setting must be
     * `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param BulkDeleteLocationCustomAttributesRequest $body An object containing the fields to
     *        POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkDeleteLocationCustomAttributes(BulkDeleteLocationCustomAttributesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/locations/custom-attributes/bulk-delete')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BulkDeleteLocationCustomAttributesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates or updates [custom attributes]($m/CustomAttribute) for locations as a bulk operation.
     * Use this endpoint to set the value of one or more custom attributes for one or more locations.
     * A custom attribute is based on a custom attribute definition in a Square seller account, which is
     * created using the
     * [CreateLocationCustomAttributeDefinition]($e/LocationCustomAttributes/CreateLocationCustomAttributeD
     * efinition) endpoint.
     * This `BulkUpsertLocationCustomAttributes` endpoint accepts a map of 1 to 25 individual upsert
     * requests and returns a map of individual upsert responses. Each upsert request has a unique ID
     * and provides a location ID and custom attribute. Each upsert response is returned with the ID
     * of the corresponding request.
     * To create or update a custom attribute owned by another application, the `visibility` setting
     * must be `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param BulkUpsertLocationCustomAttributesRequest $body An object containing the fields to
     *        POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkUpsertLocationCustomAttributes(BulkUpsertLocationCustomAttributesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/locations/custom-attributes/bulk-upsert')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BulkUpsertLocationCustomAttributesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists the [custom attributes]($m/CustomAttribute) associated with a location.
     * You can use the `with_definitions` query parameter to also retrieve custom attribute definitions
     * in the same call.
     * When all response pages are retrieved, the results include all custom attributes that are
     * visible to the requesting application, including those that are owned by other applications
     * and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string $locationId The ID of the target [location](entity:Location).
     * @param string|null $visibilityFilter Filters the `CustomAttributeDefinition` results by their
     *        `visibility` values.
     * @param int|null $limit The maximum number of results to return in a single paged response.
     *        This limit is advisory.
     *        The response might contain more or fewer results. The minimum value is 1 and the
     *        maximum value is 100.
     *        The default value is 20. For more information, see [Pagination](https://developer.
     *        squareup.com/docs/build-basics/common-api-patterns/pagination).
     * @param string|null $cursor The cursor returned in the paged response from the previous call
     *        to this endpoint.
     *        Provide this cursor to retrieve the next page of results for your original request.
     *        For more
     *        information, see [Pagination](https://developer.squareup.com/docs/build-
     *        basics/common-api-patterns/pagination).
     * @param bool|null $withDefinitions Indicates whether to return the [custom attribute
     *        definition](entity:CustomAttributeDefinition) in the `definition` field of each
     *        custom attribute. Set this parameter to `true` to get the name and description of
     *        each custom
     *        attribute, information about the data type, or other definition details. The default
     *        value is `false`.
     *
     * @return ApiResponse Response from the API call
     */
    public function listLocationCustomAttributes(
        string $locationId,
        ?string $visibilityFilter = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?bool $withDefinitions = false
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/locations/{location_id}/custom-attributes')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                QueryParam::init('visibility_filter', $visibilityFilter),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('with_definitions', $withDefinitions)
            );

        $_resHandler = $this->responseHandler()
            ->type(ListLocationCustomAttributesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a [custom attribute]($m/CustomAttribute) associated with a location.
     * To delete a custom attribute owned by another application, the `visibility` setting must be
     * `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string $locationId The ID of the target [location](entity:Location).
     * @param string $key The key of the custom attribute to delete. This key must match the `key`
     *        of a custom
     *        attribute definition in the Square seller account. If the requesting application is
     *        not the
     *        definition owner, you must use the qualified key.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteLocationCustomAttribute(string $locationId, string $key): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/locations/{location_id}/custom-attributes/{key}'
        )
            ->auth('global')
            ->parameters(TemplateParam::init('location_id', $locationId), TemplateParam::init('key', $key));

        $_resHandler = $this->responseHandler()
            ->type(DeleteLocationCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a [custom attribute]($m/CustomAttribute) associated with a location.
     * You can use the `with_definition` query parameter to also retrieve the custom attribute definition
     * in the same call.
     * To retrieve a custom attribute owned by another application, the `visibility` setting must be
     * `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string $locationId The ID of the target [location](entity:Location).
     * @param string $key The key of the custom attribute to retrieve. This key must match the `key`
     *        of a custom
     *        attribute definition in the Square seller account. If the requesting application is
     *        not the
     *        definition owner, you must use the qualified key.
     * @param bool|null $withDefinition Indicates whether to return the [custom attribute
     *        definition](entity:CustomAttributeDefinition) in the `definition` field of
     *        the custom attribute. Set this parameter to `true` to get the name and description
     *        of the custom
     *        attribute, information about the data type, or other definition details. The default
     *        value is `false`.
     * @param int|null $version The current version of the custom attribute, which is used for
     *        strongly consistent reads to
     *        guarantee that you receive the most up-to-date data. When included in the request,
     *        Square
     *        returns the specified version or a higher version if one exists. If the specified
     *        version is
     *        higher than the current version, Square returns a `BAD_REQUEST` error.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLocationCustomAttribute(
        string $locationId,
        string $key,
        ?bool $withDefinition = false,
        ?int $version = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/locations/{location_id}/custom-attributes/{key}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('key', $key),
                QueryParam::init('with_definition', $withDefinition),
                QueryParam::init('version', $version)
            );

        $_resHandler = $this->responseHandler()
            ->type(RetrieveLocationCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates or updates a [custom attribute]($m/CustomAttribute) for a location.
     * Use this endpoint to set the value of a custom attribute for a specified location.
     * A custom attribute is based on a custom attribute definition in a Square seller account, which
     * is created using the
     * [CreateLocationCustomAttributeDefinition]($e/LocationCustomAttributes/CreateLocationCustomAttributeD
     * efinition) endpoint.
     * To create or update a custom attribute owned by another application, the `visibility` setting
     * must be `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @param string $locationId The ID of the target [location](entity:Location).
     * @param string $key The key of the custom attribute to create or update. This key must match
     *        the `key` of a
     *        custom attribute definition in the Square seller account. If the requesting
     *        application is not
     *        the definition owner, you must use the qualified key.
     * @param UpsertLocationCustomAttributeRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function upsertLocationCustomAttribute(
        string $locationId,
        string $key,
        UpsertLocationCustomAttributeRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::POST,
            '/v2/locations/{location_id}/custom-attributes/{key}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                TemplateParam::init('key', $key),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()
            ->type(UpsertLocationCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
