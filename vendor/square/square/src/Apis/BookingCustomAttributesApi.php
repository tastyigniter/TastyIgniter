<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BulkDeleteBookingCustomAttributesRequest;
use Square\Models\BulkDeleteBookingCustomAttributesResponse;
use Square\Models\BulkUpsertBookingCustomAttributesRequest;
use Square\Models\BulkUpsertBookingCustomAttributesResponse;
use Square\Models\CreateBookingCustomAttributeDefinitionRequest;
use Square\Models\CreateBookingCustomAttributeDefinitionResponse;
use Square\Models\DeleteBookingCustomAttributeDefinitionResponse;
use Square\Models\DeleteBookingCustomAttributeResponse;
use Square\Models\ListBookingCustomAttributeDefinitionsResponse;
use Square\Models\ListBookingCustomAttributesResponse;
use Square\Models\RetrieveBookingCustomAttributeDefinitionResponse;
use Square\Models\RetrieveBookingCustomAttributeResponse;
use Square\Models\UpdateBookingCustomAttributeDefinitionRequest;
use Square\Models\UpdateBookingCustomAttributeDefinitionResponse;
use Square\Models\UpsertBookingCustomAttributeRequest;
use Square\Models\UpsertBookingCustomAttributeResponse;

class BookingCustomAttributesApi extends BaseApi
{
    /**
     * Get all bookings custom attribute definitions.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and
     * `APPOINTMENTS_READ` for the OAuth scope.
     *
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
    public function listBookingCustomAttributeDefinitions(?int $limit = null, ?string $cursor = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bookings/custom-attribute-definitions')
            ->auth('global')
            ->parameters(QueryParam::init('limit', $limit), QueryParam::init('cursor', $cursor));

        $_resHandler = $this->responseHandler()
            ->type(ListBookingCustomAttributeDefinitionsResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a bookings custom attribute definition.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param CreateBookingCustomAttributeDefinitionRequest $body An object containing the fields to
     *        POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createBookingCustomAttributeDefinition(
        CreateBookingCustomAttributeDefinitionRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/bookings/custom-attribute-definitions')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(CreateBookingCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a bookings custom attribute definition.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param string $key The key of the custom attribute definition to delete.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteBookingCustomAttributeDefinition(string $key): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/bookings/custom-attribute-definitions/{key}'
        )->auth('global')->parameters(TemplateParam::init('key', $key));

        $_resHandler = $this->responseHandler()
            ->type(DeleteBookingCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a bookings custom attribute definition.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and
     * `APPOINTMENTS_READ` for the OAuth scope.
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
    public function retrieveBookingCustomAttributeDefinition(string $key, ?int $version = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bookings/custom-attribute-definitions/{key}')
            ->auth('global')
            ->parameters(TemplateParam::init('key', $key), QueryParam::init('version', $version));

        $_resHandler = $this->responseHandler()
            ->type(RetrieveBookingCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a bookings custom attribute definition.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param string $key The key of the custom attribute definition to update.
     * @param UpdateBookingCustomAttributeDefinitionRequest $body An object containing the fields to
     *        POST for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateBookingCustomAttributeDefinition(
        string $key,
        UpdateBookingCustomAttributeDefinitionRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/bookings/custom-attribute-definitions/{key}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('key', $key),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()
            ->type(UpdateBookingCustomAttributeDefinitionResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Bulk deletes bookings custom attributes.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param BulkDeleteBookingCustomAttributesRequest $body An object containing the fields to POST
     *        for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkDeleteBookingCustomAttributes(BulkDeleteBookingCustomAttributesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/bookings/custom-attributes/bulk-delete')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BulkDeleteBookingCustomAttributesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Bulk upserts bookings custom attributes.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param BulkUpsertBookingCustomAttributesRequest $body An object containing the fields to POST
     *        for the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkUpsertBookingCustomAttributes(BulkUpsertBookingCustomAttributesRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/bookings/custom-attributes/bulk-upsert')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()
            ->type(BulkUpsertBookingCustomAttributesResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Lists a booking's custom attributes.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and
     * `APPOINTMENTS_READ` for the OAuth scope.
     *
     * @param string $bookingId The ID of the target [booking](entity:Booking).
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
    public function listBookingCustomAttributes(
        string $bookingId,
        ?int $limit = null,
        ?string $cursor = null,
        ?bool $withDefinitions = false
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bookings/{booking_id}/custom-attributes')
            ->auth('global')
            ->parameters(
                TemplateParam::init('booking_id', $bookingId),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor),
                QueryParam::init('with_definitions', $withDefinitions)
            );

        $_resHandler = $this->responseHandler()->type(ListBookingCustomAttributesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a bookings custom attribute.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param string $bookingId The ID of the target [booking](entity:Booking).
     * @param string $key The key of the custom attribute to delete. This key must match the `key`
     *        of a custom
     *        attribute definition in the Square seller account. If the requesting application is
     *        not the
     *        definition owner, you must use the qualified key.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteBookingCustomAttribute(string $bookingId, string $key): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::DELETE,
            '/v2/bookings/{booking_id}/custom-attributes/{key}'
        )->auth('global')->parameters(TemplateParam::init('booking_id', $bookingId), TemplateParam::init('key', $key));

        $_resHandler = $this->responseHandler()
            ->type(DeleteBookingCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a bookings custom attribute.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and
     * `APPOINTMENTS_READ` for the OAuth scope.
     *
     * @param string $bookingId The ID of the target [booking](entity:Booking).
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
    public function retrieveBookingCustomAttribute(
        string $bookingId,
        string $key,
        ?bool $withDefinition = false,
        ?int $version = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::GET,
            '/v2/bookings/{booking_id}/custom-attributes/{key}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('booking_id', $bookingId),
                TemplateParam::init('key', $key),
                QueryParam::init('with_definition', $withDefinition),
                QueryParam::init('version', $version)
            );

        $_resHandler = $this->responseHandler()
            ->type(RetrieveBookingCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Upserts a bookings custom attribute.
     *
     * To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
     * To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and
     * `APPOINTMENTS_WRITE` for the OAuth scope.
     *
     * For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed
     * to *Appointments Plus*
     * or *Appointments Premium*.
     *
     * @param string $bookingId The ID of the target [booking](entity:Booking).
     * @param string $key The key of the custom attribute to create or update. This key must match
     *        the `key` of a
     *        custom attribute definition in the Square seller account. If the requesting
     *        application is not
     *        the definition owner, you must use the qualified key.
     * @param UpsertBookingCustomAttributeRequest $body An object containing the fields to POST for
     *        the request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function upsertBookingCustomAttribute(
        string $bookingId,
        string $key,
        UpsertBookingCustomAttributeRequest $body
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(
            RequestMethod::PUT,
            '/v2/bookings/{booking_id}/custom-attributes/{key}'
        )
            ->auth('global')
            ->parameters(
                TemplateParam::init('booking_id', $bookingId),
                TemplateParam::init('key', $key),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()
            ->type(UpsertBookingCustomAttributeResponse::class)
            ->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
