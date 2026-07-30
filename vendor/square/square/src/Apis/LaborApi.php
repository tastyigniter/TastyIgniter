<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\CreateBreakTypeRequest;
use Square\Models\CreateBreakTypeResponse;
use Square\Models\CreateShiftRequest;
use Square\Models\CreateShiftResponse;
use Square\Models\DeleteBreakTypeResponse;
use Square\Models\DeleteShiftResponse;
use Square\Models\GetBreakTypeResponse;
use Square\Models\GetEmployeeWageResponse;
use Square\Models\GetShiftResponse;
use Square\Models\GetTeamMemberWageResponse;
use Square\Models\ListBreakTypesResponse;
use Square\Models\ListEmployeeWagesResponse;
use Square\Models\ListTeamMemberWagesResponse;
use Square\Models\ListWorkweekConfigsResponse;
use Square\Models\SearchShiftsRequest;
use Square\Models\SearchShiftsResponse;
use Square\Models\UpdateBreakTypeRequest;
use Square\Models\UpdateBreakTypeResponse;
use Square\Models\UpdateShiftRequest;
use Square\Models\UpdateShiftResponse;
use Square\Models\UpdateWorkweekConfigRequest;
use Square\Models\UpdateWorkweekConfigResponse;

class LaborApi extends BaseApi
{
    /**
     * Returns a paginated list of `BreakType` instances for a business.
     *
     * @param string|null $locationId Filter the returned `BreakType` results to only those that are
     *        associated with the
     *        specified location.
     * @param int|null $limit The maximum number of `BreakType` results to return per page. The
     *        number can range between 1
     *        and 200. The default is 200.
     * @param string|null $cursor A pointer to the next page of `BreakType` results to fetch.
     *
     * @return ApiResponse Response from the API call
     */
    public function listBreakTypes(?string $locationId = null, ?int $limit = null, ?string $cursor = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/break-types')
            ->auth('global')
            ->parameters(
                QueryParam::init('location_id', $locationId),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListBreakTypesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a new `BreakType`.
     *
     * A `BreakType` is a template for creating `Break` objects.
     * You must provide the following values in your request to this
     * endpoint:
     *
     * - `location_id`
     * - `break_name`
     * - `expected_duration`
     * - `is_paid`
     *
     * You can only have three `BreakType` instances per location. If you attempt to add a fourth
     * `BreakType` for a location, an `INVALID_REQUEST_ERROR` "Exceeded limit of 3 breaks per location."
     * is returned.
     *
     * @param CreateBreakTypeRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createBreakType(CreateBreakTypeRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/labor/break-types')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateBreakTypeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes an existing `BreakType`.
     *
     * A `BreakType` can be deleted even if it is referenced from a `Shift`.
     *
     * @param string $id The UUID for the `BreakType` being deleted.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteBreakType(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/labor/break-types/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(DeleteBreakTypeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a single `BreakType` specified by `id`.
     *
     * @param string $id The UUID for the `BreakType` being retrieved.
     *
     * @return ApiResponse Response from the API call
     */
    public function getBreakType(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/break-types/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(GetBreakTypeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates an existing `BreakType`.
     *
     * @param string $id The UUID for the `BreakType` being updated.
     * @param UpdateBreakTypeRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateBreakType(string $id, UpdateBreakTypeRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/labor/break-types/{id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('id', $id),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateBreakTypeResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a paginated list of `EmployeeWage` instances for a business.
     *
     * @deprecated
     *
     * @param string|null $employeeId Filter the returned wages to only those that are associated
     *        with the specified employee.
     * @param int|null $limit The maximum number of `EmployeeWage` results to return per page. The
     *        number can range between
     *        1 and 200. The default is 200.
     * @param string|null $cursor A pointer to the next page of `EmployeeWage` results to fetch.
     *
     * @return ApiResponse Response from the API call
     */
    public function listEmployeeWages(
        ?string $employeeId = null,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/employee-wages')
            ->auth('global')
            ->parameters(
                QueryParam::init('employee_id', $employeeId),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListEmployeeWagesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a single `EmployeeWage` specified by `id`.
     *
     * @deprecated
     *
     * @param string $id The UUID for the `EmployeeWage` being retrieved.
     *
     * @return ApiResponse Response from the API call
     */
    public function getEmployeeWage(string $id): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/employee-wages/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(GetEmployeeWageResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates a new `Shift`.
     *
     * A `Shift` represents a complete workday for a single employee.
     * You must provide the following values in your request to this
     * endpoint:
     *
     * - `location_id`
     * - `employee_id`
     * - `start_at`
     *
     * An attempt to create a new `Shift` can result in a `BAD_REQUEST` error when:
     * - The `status` of the new `Shift` is `OPEN` and the employee has another
     * shift with an `OPEN` status.
     * - The `start_at` date is in the future.
     * - The `start_at` or `end_at` date overlaps another shift for the same employee.
     * - The `Break` instances are set in the request and a break `start_at`
     * is before the `Shift.start_at`, a break `end_at` is after
     * the `Shift.end_at`, or both.
     *
     * @param CreateShiftRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createShift(CreateShiftRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/labor/shifts')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateShiftResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a paginated list of `Shift` records for a business.
     * The list to be returned can be filtered by:
     * - Location IDs.
     * - Employee IDs.
     * - Shift status (`OPEN` and `CLOSED`).
     * - Shift start.
     * - Shift end.
     * - Workday details.
     *
     * The list can be sorted by:
     * - `start_at`.
     * - `end_at`.
     * - `created_at`.
     * - `updated_at`.
     *
     * @param SearchShiftsRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchShifts(SearchShiftsRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/labor/shifts/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchShiftsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Deletes a `Shift`.
     *
     * @param string $id The UUID for the `Shift` being deleted.
     *
     * @return ApiResponse Response from the API call
     */
    public function deleteShift(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::DELETE, '/v2/labor/shifts/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(DeleteShiftResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a single `Shift` specified by `id`.
     *
     * @param string $id The UUID for the `Shift` being retrieved.
     *
     * @return ApiResponse Response from the API call
     */
    public function getShift(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/shifts/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(GetShiftResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates an existing `Shift`.
     *
     * When adding a `Break` to a `Shift`, any earlier `Break` instances in the `Shift` have
     * the `end_at` property set to a valid RFC-3339 datetime string.
     *
     * When closing a `Shift`, all `Break` instances in the `Shift` must be complete with `end_at`
     * set on each `Break`.
     *
     * @param string $id The ID of the object being updated.
     * @param UpdateShiftRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateShift(string $id, UpdateShiftRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/labor/shifts/{id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('id', $id),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateShiftResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a paginated list of `TeamMemberWage` instances for a business.
     *
     * @param string|null $teamMemberId Filter the returned wages to only those that are associated
     *        with the
     *        specified team member.
     * @param int|null $limit The maximum number of `TeamMemberWage` results to return per page. The
     *        number can range between
     *        1 and 200. The default is 200.
     * @param string|null $cursor A pointer to the next page of `EmployeeWage` results to fetch.
     *
     * @return ApiResponse Response from the API call
     */
    public function listTeamMemberWages(
        ?string $teamMemberId = null,
        ?int $limit = null,
        ?string $cursor = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/team-member-wages')
            ->auth('global')
            ->parameters(
                QueryParam::init('team_member_id', $teamMemberId),
                QueryParam::init('limit', $limit),
                QueryParam::init('cursor', $cursor)
            );

        $_resHandler = $this->responseHandler()->type(ListTeamMemberWagesResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a single `TeamMemberWage` specified by `id `.
     *
     * @param string $id The UUID for the `TeamMemberWage` being retrieved.
     *
     * @return ApiResponse Response from the API call
     */
    public function getTeamMemberWage(string $id): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/team-member-wages/{id}')
            ->auth('global')
            ->parameters(TemplateParam::init('id', $id));

        $_resHandler = $this->responseHandler()->type(GetTeamMemberWageResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a list of `WorkweekConfig` instances for a business.
     *
     * @param int|null $limit The maximum number of `WorkweekConfigs` results to return per page.
     * @param string|null $cursor A pointer to the next page of `WorkweekConfig` results to fetch.
     *
     * @return ApiResponse Response from the API call
     */
    public function listWorkweekConfigs(?int $limit = null, ?string $cursor = null): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/labor/workweek-configs')
            ->auth('global')
            ->parameters(QueryParam::init('limit', $limit), QueryParam::init('cursor', $cursor));

        $_resHandler = $this->responseHandler()->type(ListWorkweekConfigsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a `WorkweekConfig`.
     *
     * @param string $id The UUID for the `WorkweekConfig` object being updated.
     * @param UpdateWorkweekConfigRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateWorkweekConfig(string $id, UpdateWorkweekConfigRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/labor/workweek-configs/{id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('id', $id),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateWorkweekConfigResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
