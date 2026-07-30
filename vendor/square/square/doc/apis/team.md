# Team

```php
$teamApi = $client->getTeamApi();
```

## Class Name

`TeamApi`

## Methods

* [Create Team Member](../../doc/apis/team.md#create-team-member)
* [Bulk Create Team Members](../../doc/apis/team.md#bulk-create-team-members)
* [Bulk Update Team Members](../../doc/apis/team.md#bulk-update-team-members)
* [Search Team Members](../../doc/apis/team.md#search-team-members)
* [Retrieve Team Member](../../doc/apis/team.md#retrieve-team-member)
* [Update Team Member](../../doc/apis/team.md#update-team-member)
* [Retrieve Wage Setting](../../doc/apis/team.md#retrieve-wage-setting)
* [Update Wage Setting](../../doc/apis/team.md#update-wage-setting)


# Create Team Member

Creates a single `TeamMember` object. The `TeamMember` object is returned on successful creates.
You must provide the following values in your request to this endpoint:

- `given_name`
- `family_name`

Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#createteammember).

```php
function createTeamMember(CreateTeamMemberRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateTeamMemberRequest`](../../doc/models/create-team-member-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateTeamMemberResponse`](../../doc/models/create-team-member-response.md)

## Example Usage

```php
$body = CreateTeamMemberRequestBuilder::init()
    ->idempotencyKey('idempotency-key-0')
    ->teamMember(
        TeamMemberBuilder::init()
            ->referenceId('reference_id_1')
            ->status(TeamMemberStatus::ACTIVE)
            ->givenName('Joe')
            ->familyName('Doe')
            ->emailAddress('joe_doe@gmail.com')
            ->phoneNumber('+14159283333')
            ->assignedLocations(
                TeamMemberAssignedLocationsBuilder::init()
                    ->assignmentType(TeamMemberAssignedLocationsAssignmentType::EXPLICIT_LOCATIONS)
                    ->locationIds(
                        [
                            'YSGH2WBKG94QZ',
                            'GA2Y9HSJ8KRYT'
                        ]
                    )
                    ->build()
            )
            ->build()
    )
    ->build();

$apiResponse = $teamApi->createTeamMember($body);

if ($apiResponse->isSuccess()) {
    $createTeamMemberResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Create Team Members

Creates multiple `TeamMember` objects. The created `TeamMember` objects are returned on successful creates.
This process is non-transactional and processes as much of the request as possible. If one of the creates in
the request cannot be successfully processed, the request is not marked as failed, but the body of the response
contains explicit error information for the failed create.

Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#bulk-create-team-members).

```php
function bulkCreateTeamMembers(BulkCreateTeamMembersRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkCreateTeamMembersRequest`](../../doc/models/bulk-create-team-members-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkCreateTeamMembersResponse`](../../doc/models/bulk-create-team-members-response.md)

## Example Usage

```php
$body = BulkCreateTeamMembersRequestBuilder::init(
    [
        'idempotency-key-1' => CreateTeamMemberRequestBuilder::init()
            ->teamMember(
                TeamMemberBuilder::init()
                    ->referenceId('reference_id_1')
                    ->givenName('Joe')
                    ->familyName('Doe')
                    ->emailAddress('joe_doe@gmail.com')
                    ->phoneNumber('+14159283333')
                    ->assignedLocations(
                        TeamMemberAssignedLocationsBuilder::init()
                            ->assignmentType(TeamMemberAssignedLocationsAssignmentType::EXPLICIT_LOCATIONS)
                            ->locationIds(
                                [
                                    'YSGH2WBKG94QZ',
                                    'GA2Y9HSJ8KRYT'
                                ]
                            )
                            ->build()
                    )
                    ->build()
            )
            ->build(),
        'idempotency-key-2' => CreateTeamMemberRequestBuilder::init()
            ->teamMember(
                TeamMemberBuilder::init()
                    ->referenceId('reference_id_2')
                    ->givenName('Jane')
                    ->familyName('Smith')
                    ->emailAddress('jane_smith@gmail.com')
                    ->phoneNumber('+14159223334')
                    ->assignedLocations(
                        TeamMemberAssignedLocationsBuilder::init()
                            ->assignmentType(TeamMemberAssignedLocationsAssignmentType::ALL_CURRENT_AND_FUTURE_LOCATIONS)
                            ->build()
                    )
                    ->build()
            )
            ->build()
    ]
)->build();

$apiResponse = $teamApi->bulkCreateTeamMembers($body);

if ($apiResponse->isSuccess()) {
    $bulkCreateTeamMembersResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Update Team Members

Updates multiple `TeamMember` objects. The updated `TeamMember` objects are returned on successful updates.
This process is non-transactional and processes as much of the request as possible. If one of the updates in
the request cannot be successfully processed, the request is not marked as failed, but the body of the response
contains explicit error information for the failed update.
Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#bulk-update-team-members).

```php
function bulkUpdateTeamMembers(BulkUpdateTeamMembersRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkUpdateTeamMembersRequest`](../../doc/models/bulk-update-team-members-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkUpdateTeamMembersResponse`](../../doc/models/bulk-update-team-members-response.md)

## Example Usage

```php
$body = BulkUpdateTeamMembersRequestBuilder::init(
    [
        'AFMwA08kR-MIF-3Vs0OE' => UpdateTeamMemberRequestBuilder::init()
            ->teamMember(
                TeamMemberBuilder::init()
                    ->referenceId('reference_id_2')
                    ->isOwner(false)
                    ->status(TeamMemberStatus::ACTIVE)
                    ->givenName('Jane')
                    ->familyName('Smith')
                    ->emailAddress('jane_smith@gmail.com')
                    ->phoneNumber('+14159223334')
                    ->assignedLocations(
                        TeamMemberAssignedLocationsBuilder::init()
                            ->assignmentType(TeamMemberAssignedLocationsAssignmentType::ALL_CURRENT_AND_FUTURE_LOCATIONS)
                            ->build()
                    )
                    ->build()
            )
            ->build(),
        'fpgteZNMaf0qOK-a4t6P' => UpdateTeamMemberRequestBuilder::init()
            ->teamMember(
                TeamMemberBuilder::init()
                    ->referenceId('reference_id_1')
                    ->isOwner(false)
                    ->status(TeamMemberStatus::ACTIVE)
                    ->givenName('Joe')
                    ->familyName('Doe')
                    ->emailAddress('joe_doe@gmail.com')
                    ->phoneNumber('+14159283333')
                    ->assignedLocations(
                        TeamMemberAssignedLocationsBuilder::init()
                            ->assignmentType(TeamMemberAssignedLocationsAssignmentType::EXPLICIT_LOCATIONS)
                            ->locationIds(
                                [
                                    'YSGH2WBKG94QZ',
                                    'GA2Y9HSJ8KRYT'
                                ]
                            )
                            ->build()
                    )
                    ->build()
            )
            ->build()
    ]
)->build();

$apiResponse = $teamApi->bulkUpdateTeamMembers($body);

if ($apiResponse->isSuccess()) {
    $bulkUpdateTeamMembersResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Team Members

Returns a paginated list of `TeamMember` objects for a business.
The list can be filtered by the following:

- location IDs
- `status`

```php
function searchTeamMembers(SearchTeamMembersRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchTeamMembersRequest`](../../doc/models/search-team-members-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchTeamMembersResponse`](../../doc/models/search-team-members-response.md)

## Example Usage

```php
$body = SearchTeamMembersRequestBuilder::init()
    ->query(
        SearchTeamMembersQueryBuilder::init()
            ->filter(
                SearchTeamMembersFilterBuilder::init()
                    ->locationIds(
                        [
                            '0G5P3VGACMMQZ'
                        ]
                    )
                    ->status(TeamMemberStatus::ACTIVE)
                    ->build()
            )
            ->build()
    )
    ->limit(10)
    ->build();

$apiResponse = $teamApi->searchTeamMembers($body);

if ($apiResponse->isSuccess()) {
    $searchTeamMembersResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Team Member

Retrieves a `TeamMember` object for the given `TeamMember.id`.
Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#retrieve-a-team-member).

```php
function retrieveTeamMember(string $teamMemberId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `teamMemberId` | `string` | Template, Required | The ID of the team member to retrieve. |

## Response Type

[`RetrieveTeamMemberResponse`](../../doc/models/retrieve-team-member-response.md)

## Example Usage

```php
$teamMemberId = 'team_member_id0';

$apiResponse = $teamApi->retrieveTeamMember($teamMemberId);

if ($apiResponse->isSuccess()) {
    $retrieveTeamMemberResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Team Member

Updates a single `TeamMember` object. The `TeamMember` object is returned on successful updates.
Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#update-a-team-member).

```php
function updateTeamMember(string $teamMemberId, UpdateTeamMemberRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `teamMemberId` | `string` | Template, Required | The ID of the team member to update. |
| `body` | [`UpdateTeamMemberRequest`](../../doc/models/update-team-member-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateTeamMemberResponse`](../../doc/models/update-team-member-response.md)

## Example Usage

```php
$teamMemberId = 'team_member_id0';

$body = UpdateTeamMemberRequestBuilder::init()
    ->teamMember(
        TeamMemberBuilder::init()
            ->referenceId('reference_id_1')
            ->status(TeamMemberStatus::ACTIVE)
            ->givenName('Joe')
            ->familyName('Doe')
            ->emailAddress('joe_doe@gmail.com')
            ->phoneNumber('+14159283333')
            ->assignedLocations(
                TeamMemberAssignedLocationsBuilder::init()
                    ->assignmentType(TeamMemberAssignedLocationsAssignmentType::EXPLICIT_LOCATIONS)
                    ->locationIds(
                        [
                            'YSGH2WBKG94QZ',
                            'GA2Y9HSJ8KRYT'
                        ]
                    )
                    ->build()
            )
            ->build()
    )
    ->build();

$apiResponse = $teamApi->updateTeamMember(
    $teamMemberId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateTeamMemberResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Wage Setting

Retrieves a `WageSetting` object for a team member specified
by `TeamMember.id`.
Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#retrievewagesetting).

```php
function retrieveWageSetting(string $teamMemberId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `teamMemberId` | `string` | Template, Required | The ID of the team member for which to retrieve the wage setting. |

## Response Type

[`RetrieveWageSettingResponse`](../../doc/models/retrieve-wage-setting-response.md)

## Example Usage

```php
$teamMemberId = 'team_member_id0';

$apiResponse = $teamApi->retrieveWageSetting($teamMemberId);

if ($apiResponse->isSuccess()) {
    $retrieveWageSettingResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Wage Setting

Creates or updates a `WageSetting` object. The object is created if a
`WageSetting` with the specified `team_member_id` does not exist. Otherwise,
it fully replaces the `WageSetting` object for the team member.
The `WageSetting` is returned on a successful update.
Learn about [Troubleshooting the Team API](https://developer.squareup.com/docs/team/troubleshooting#create-or-update-a-wage-setting).

```php
function updateWageSetting(string $teamMemberId, UpdateWageSettingRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `teamMemberId` | `string` | Template, Required | The ID of the team member for which to update the `WageSetting` object. |
| `body` | [`UpdateWageSettingRequest`](../../doc/models/update-wage-setting-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateWageSettingResponse`](../../doc/models/update-wage-setting-response.md)

## Example Usage

```php
$teamMemberId = 'team_member_id0';

$body = UpdateWageSettingRequestBuilder::init(
    WageSettingBuilder::init()
        ->jobAssignments(
            [
                JobAssignmentBuilder::init(
                    'Manager',
                    JobAssignmentPayType::SALARY
                )
                    ->annualRate(
                        MoneyBuilder::init()
                            ->amount(3000000)
                            ->currency(Currency::USD)
                            ->build()
                    )
                    ->weeklyHours(40)
                    ->build(),
                JobAssignmentBuilder::init(
                    'Cashier',
                    JobAssignmentPayType::HOURLY
                )
                    ->hourlyRate(
                        MoneyBuilder::init()
                            ->amount(1200)
                            ->currency(Currency::USD)
                            ->build()
                    )
                    ->build()
            ]
        )
        ->isOvertimeExempt(true)
        ->build()
)->build();

$apiResponse = $teamApi->updateWageSetting(
    $teamMemberId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateWageSettingResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

