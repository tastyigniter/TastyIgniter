<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BulkCreateVendorsRequest;
use Square\Models\BulkCreateVendorsResponse;
use Square\Models\BulkRetrieveVendorsRequest;
use Square\Models\BulkRetrieveVendorsResponse;
use Square\Models\BulkUpdateVendorsRequest;
use Square\Models\BulkUpdateVendorsResponse;
use Square\Models\CreateVendorRequest;
use Square\Models\CreateVendorResponse;
use Square\Models\RetrieveVendorResponse;
use Square\Models\SearchVendorsRequest;
use Square\Models\SearchVendorsResponse;
use Square\Models\UpdateVendorRequest;
use Square\Models\UpdateVendorResponse;

class VendorsApi extends BaseApi
{
    /**
     * Creates one or more [Vendor]($m/Vendor) objects to represent suppliers to a seller.
     *
     * @param BulkCreateVendorsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkCreateVendors(BulkCreateVendorsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/vendors/bulk-create')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BulkCreateVendorsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves one or more vendors of specified [Vendor]($m/Vendor) IDs.
     *
     * @param BulkRetrieveVendorsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkRetrieveVendors(BulkRetrieveVendorsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/vendors/bulk-retrieve')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BulkRetrieveVendorsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates one or more of existing [Vendor]($m/Vendor) objects as suppliers to a seller.
     *
     * @param BulkUpdateVendorsRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkUpdateVendors(BulkUpdateVendorsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/vendors/bulk-update')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BulkUpdateVendorsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a single [Vendor]($m/Vendor) object to represent a supplier to a seller.
     *
     * @param CreateVendorRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createVendor(CreateVendorRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/vendors/create')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateVendorResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Searches for vendors using a filter against supported [Vendor]($m/Vendor) properties and a supported
     * sorter.
     *
     * @param SearchVendorsRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchVendors(SearchVendorsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/vendors/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchVendorsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves the vendor of a specified [Vendor]($m/Vendor) ID.
     *
     * @param string $vendorId ID of the [Vendor](entity:Vendor) to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveVendor(string $vendorId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/vendors/{vendor_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('vendor_id', $vendorId));

        $_resHandler = $this->responseHandler()->type(RetrieveVendorResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates an existing [Vendor]($m/Vendor) object as a supplier to a seller.
     *
     * @param UpdateVendorRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     * @param string $vendorId
     *
     * @return ApiResponse Response from the API call
     */
    public function updateVendor(UpdateVendorRequest $body, string $vendorId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/vendors/{vendor_id}')
            ->auth('global')
            ->parameters(
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body),
                TemplateParam::init('vendor_id', $vendorId)
            );

        $_resHandler = $this->responseHandler()->type(UpdateVendorResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
