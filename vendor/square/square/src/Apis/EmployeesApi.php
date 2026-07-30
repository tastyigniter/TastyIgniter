<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\ListEmployeesResponse;
use Square\Models\RetrieveEmployeeResponse;

class EmployeesApi extends BaseApi
{
    /**
     * ListEmployees
     *
     * @deprecated
     *
     * @param string|null $locationId
     * @param string|null $status Specifies the EmployeeStatus to filter the employee by.
     * @param int|null $limit The number of employees to be returned on each page.
     * @param string|null $cursor The token required to retrieve the specified page of results.
     *
     * @return ApiResponse Response from the API call
     */
    public function listEmployees(
        ?string $locationId = null,
        ?string $status = null,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/employees')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                QueryParam::init('status', $status),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListEmployeesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * RetrieveEmployee
     *
     * @deprecated
     *
     * @param string $id UUID for the employee that was requested.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveEmployee(string $id): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/employees/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(RetrieveEmployeeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
