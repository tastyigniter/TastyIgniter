<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateLocationRequest;
use Square\Models\CreateLocationResponse;
use Square\Models\ListLocationsResponse;
use Square\Models\RetrieveLocationResponse;
use Square\Models\UpdateLocationRequest;
use Square\Models\UpdateLocationResponse;

class LocationsApi extends BaseApi
{
    /**
     * Provides details about all of the seller's [locations](https://developer.squareup.com/docs/locations-
     * api),
     * including those with an inactive status.
     *
     * @return ApiResponse Response from the API call
     */
    public function listLocations(): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/locations')->auth('global');

        $_resHandler = $this->responseHandler()->type(ListLocationsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a [location](https://developer.squareup.com/docs/locations-api).
     * Creating new locations allows for separate configuration of receipt layouts, item prices,
     * and sales reports. Developers can use locations to separate sales activity through applications
     * that integrate with Square from sales activity elsewhere in a seller's account.
     * Locations created programmatically with the Locations API last forever and
     * are visible to the seller for their own management. Therefore, ensure that
     * each location has a sensible and unique name.
     *
     * @param CreateLocationRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createLocation(CreateLocationRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/locations')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateLocationResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves details of a single location. Specify "main"
     * as the location ID to retrieve details of the [main location](https://developer.squareup.
     * com/docs/locations-api#about-the-main-location).
     *
     * @param string $locationId The ID of the location to retrieve. Specify the string "main" to
     *        return the main location.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveLocation(string $locationId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/locations/{location_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('location_id', $locationId));

        $_resHandler = $this->responseHandler()->type(RetrieveLocationResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a [location](https://developer.squareup.com/docs/locations-api).
     *
     * @param string $locationId The ID of the location to update.
     * @param UpdateLocationRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateLocation(string $locationId, UpdateLocationRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/locations/{location_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('location_id', $locationId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateLocationResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
