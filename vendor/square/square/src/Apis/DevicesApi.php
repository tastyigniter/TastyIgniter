<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateDeviceCodeRequest;
use Square\Models\CreateDeviceCodeResponse;
use Square\Models\GetDeviceCodeResponse;
use Square\Models\ListDeviceCodesResponse;

class DevicesApi extends BaseApi
{
    /**
     * Lists all DeviceCodes associated with the merchant.
     *
     * @param string|null $cursor A pagination cursor returned by a previous call to this endpoint.
     *        Provide this to retrieve the next set of results for your original query.
     *
     *        See [Paginating results](https://developer.squareup.com/docs/working-with-
     *        apis/pagination) for more information.
     * @param string|null $locationId If specified, only returns DeviceCodes of the specified
     *        location.
     *        Returns DeviceCodes of all locations if empty.
     * @param string|null $productType If specified, only returns DeviceCodes targeting the
     *        specified product type.
     *        Returns DeviceCodes of all product types if empty.
     * @param string|null $status If specified, returns DeviceCodes with the specified statuses.
     *        Returns DeviceCodes of status `PAIRED` and `UNPAIRED` if empty.
     *
     * @return ApiResponse Response from the API call
     */
    public function listDeviceCodes(
        ?string $cursor = null,
        ?string $locationId = null,
        ?string $productType = null,
        ?string $status = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/devices/codes')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('location_id', $locationId),
                QueryParam::init('product_type', $productType),
                QueryParam::init('status', $status)
            );

        $_resHandler = $this->responseHandler()->type(ListDeviceCodesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a DeviceCode that can be used to login to a Square Terminal device to enter the connected
     * terminal mode.
     *
     * @param CreateDeviceCodeRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createDeviceCode(CreateDeviceCodeRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/devices/codes')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateDeviceCodeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves DeviceCode with the associated ID.
     *
     * @param string $id The unique identifier for the device code.
     *
     * @return ApiResponse Response from the API call
     */
    public function getDeviceCode(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/devices/codes/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(GetDeviceCodeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
