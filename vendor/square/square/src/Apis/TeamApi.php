<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\BulkCreateTeamMembersRequest;
use Square\Models\BulkCreateTeamMembersResponse;
use Square\Models\BulkUpdateTeamMembersRequest;
use Square\Models\BulkUpdateTeamMembersResponse;
use Square\Models\CreateTeamMemberRequest;
use Square\Models\CreateTeamMemberResponse;
use Square\Models\RetrieveTeamMemberResponse;
use Square\Models\RetrieveWageSettingResponse;
use Square\Models\SearchTeamMembersRequest;
use Square\Models\SearchTeamMembersResponse;
use Square\Models\UpdateTeamMemberRequest;
use Square\Models\UpdateTeamMemberResponse;
use Square\Models\UpdateWageSettingRequest;
use Square\Models\UpdateWageSettingResponse;

class TeamApi extends BaseApi
{
    /**
     * Creates a single `TeamMember` object. The `TeamMember` object is returned on successful creates.
     * You must provide the following values in your request to this endpoint:
     * - `given_name`
     * - `family_name`
     *
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#createteammember).
     *
     * @param CreateTeamMemberRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function createTeamMember(CreateTeamMemberRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/team-members')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(CreateTeamMemberResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates multiple `TeamMember` objects. The created `TeamMember` objects are returned on successful
     * creates.
     * This process is non-transactional and processes as much of the request as possible. If one of the
     * creates in
     * the request cannot be successfully processed, the request is not marked as failed, but the body of
     * the response
     * contains explicit error information for the failed create.
     *
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#bulk-create-team-members).
     *
     * @param BulkCreateTeamMembersRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkCreateTeamMembers(BulkCreateTeamMembersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/team-members/bulk-create')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BulkCreateTeamMembersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates multiple `TeamMember` objects. The updated `TeamMember` objects are returned on successful
     * updates.
     * This process is non-transactional and processes as much of the request as possible. If one of the
     * updates in
     * the request cannot be successfully processed, the request is not marked as failed, but the body of
     * the response
     * contains explicit error information for the failed update.
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#bulk-update-team-members).
     *
     * @param BulkUpdateTeamMembersRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function bulkUpdateTeamMembers(BulkUpdateTeamMembersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/team-members/bulk-update')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(BulkUpdateTeamMembersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns a paginated list of `TeamMember` objects for a business.
     * The list can be filtered by the following:
     * - location IDs
     * - `status`
     *
     * @param SearchTeamMembersRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function searchTeamMembers(SearchTeamMembersRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v2/team-members/search')
            ->auth('global')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(SearchTeamMembersResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a `TeamMember` object for the given `TeamMember.id`.
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#retrieve-a-team-member).
     *
     * @param string $teamMemberId The ID of the team member to retrieve.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveTeamMember(string $teamMemberId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/team-members/{team_member_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('team_member_id', $teamMemberId));

        $_resHandler = $this->responseHandler()->type(RetrieveTeamMemberResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Updates a single `TeamMember` object. The `TeamMember` object is returned on successful updates.
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#update-a-team-member).
     *
     * @param string $teamMemberId The ID of the team member to update.
     * @param UpdateTeamMemberRequest $body An object containing the fields to POST for the request.
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateTeamMember(string $teamMemberId, UpdateTeamMemberRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/team-members/{team_member_id}')
            ->auth('global')
            ->parameters(
                TemplateParam::init('team_member_id', $teamMemberId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateTeamMemberResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Retrieves a `WageSetting` object for a team member specified
     * by `TeamMember.id`.
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#retrievewagesetting).
     *
     * @param string $teamMemberId The ID of the team member for which to retrieve the wage setting.
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveWageSetting(string $teamMemberId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/team-members/{team_member_id}/wage-setting')
            ->auth('global')
            ->parameters(TemplateParam::init('team_member_id', $teamMemberId));

        $_resHandler = $this->responseHandler()->type(RetrieveWageSettingResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Creates or updates a `WageSetting` object. The object is created if a
     * `WageSetting` with the specified `team_member_id` does not exist. Otherwise,
     * it fully replaces the `WageSetting` object for the team member.
     * The `WageSetting` is returned on a successful update.
     * Learn about [Troubleshooting the Team API](https://developer.squareup.
     * com/docs/team/troubleshooting#create-or-update-a-wage-setting).
     *
     * @param string $teamMemberId The ID of the team member for which to update the `WageSetting`
     *        object.
     * @param UpdateWageSettingRequest $body An object containing the fields to POST for the
     *        request.
     *
     *        See the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function updateWageSetting(string $teamMemberId, UpdateWageSettingRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::PUT, '/v2/team-members/{team_member_id}/wage-setting')
            ->auth('global')
            ->parameters(
                TemplateParam::init('team_member_id', $teamMemberId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body)
            );

        $_resHandler = $this->responseHandler()->type(UpdateWageSettingResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
