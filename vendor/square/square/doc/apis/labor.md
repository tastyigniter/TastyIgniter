# Labor

```php
$laborApi = $client->getLaborApi();
```

## Class Name

`LaborApi`

## Methods

* [List Break Types](../../doc/apis/labor.md#list-break-types)
* [Create Break Type](../../doc/apis/labor.md#create-break-type)
* [Delete Break Type](../../doc/apis/labor.md#delete-break-type)
* [Get Break Type](../../doc/apis/labor.md#get-break-type)
* [Update Break Type](../../doc/apis/labor.md#update-break-type)
* [List Employee Wages](../../doc/apis/labor.md#list-employee-wages)
* [Get Employee Wage](../../doc/apis/labor.md#get-employee-wage)
* [Create Shift](../../doc/apis/labor.md#create-shift)
* [Search Shifts](../../doc/apis/labor.md#search-shifts)
* [Delete Shift](../../doc/apis/labor.md#delete-shift)
* [Get Shift](../../doc/apis/labor.md#get-shift)
* [Update Shift](../../doc/apis/labor.md#update-shift)
* [List Team Member Wages](../../doc/apis/labor.md#list-team-member-wages)
* [Get Team Member Wage](../../doc/apis/labor.md#get-team-member-wage)
* [List Workweek Configs](../../doc/apis/labor.md#list-workweek-configs)
* [Update Workweek Config](../../doc/apis/labor.md#update-workweek-config)


# List Break Types

Returns a paginated list of `BreakType` instances for a business.

```php
function listBreakTypes(?string $locationId = null, ?int $limit = null, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `?string` | Query, Optional | Filter the returned `BreakType` results to only those that are associated with the<br>specified location. |
| `limit` | `?int` | Query, Optional | The maximum number of `BreakType` results to return per page. The number can range between 1<br>and 200. The default is 200. |
| `cursor` | `?string` | Query, Optional | A pointer to the next page of `BreakType` results to fetch. |

## Response Type

[`ListBreakTypesResponse`](../../doc/models/list-break-types-response.md)

## Example Usage

```php
$apiResponse = $laborApi->listBreakTypes();

if ($apiResponse->isSuccess()) {
    $listBreakTypesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Break Type

Creates a new `BreakType`.

A `BreakType` is a template for creating `Break` objects.
You must provide the following values in your request to this
endpoint:

- `location_id`
- `break_name`
- `expected_duration`
- `is_paid`

You can only have three `BreakType` instances per location. If you attempt to add a fourth
`BreakType` for a location, an `INVALID_REQUEST_ERROR` "Exceeded limit of 3 breaks per location."
is returned.

```php
function createBreakType(CreateBreakTypeRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateBreakTypeRequest`](../../doc/models/create-break-type-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateBreakTypeResponse`](../../doc/models/create-break-type-response.md)

## Example Usage

```php
$body = CreateBreakTypeRequestBuilder::init(
    BreakTypeBuilder::init(
        'CGJN03P1D08GF',
        'Lunch Break',
        'PT30M',
        true
    )->build()
)
    ->idempotencyKey('PAD3NG5KSN2GL')
    ->build();

$apiResponse = $laborApi->createBreakType($body);

if ($apiResponse->isSuccess()) {
    $createBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Break Type

Deletes an existing `BreakType`.

A `BreakType` can be deleted even if it is referenced from a `Shift`.

```php
function deleteBreakType(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `BreakType` being deleted. |

## Response Type

[`DeleteBreakTypeResponse`](../../doc/models/delete-break-type-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->deleteBreakType($id);

if ($apiResponse->isSuccess()) {
    $deleteBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Break Type

Returns a single `BreakType` specified by `id`.

```php
function getBreakType(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `BreakType` being retrieved. |

## Response Type

[`GetBreakTypeResponse`](../../doc/models/get-break-type-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getBreakType($id);

if ($apiResponse->isSuccess()) {
    $getBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Break Type

Updates an existing `BreakType`.

```php
function updateBreakType(string $id, UpdateBreakTypeRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `BreakType` being updated. |
| `body` | [`UpdateBreakTypeRequest`](../../doc/models/update-break-type-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateBreakTypeResponse`](../../doc/models/update-break-type-response.md)

## Example Usage

```php
$id = 'id0';

$body = UpdateBreakTypeRequestBuilder::init(
    BreakTypeBuilder::init(
        '26M7H24AZ9N6R',
        'Lunch',
        'PT50M',
        true
    )
        ->version(1)
        ->build()
)->build();

$apiResponse = $laborApi->updateBreakType(
    $id,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateBreakTypeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Employee Wages

**This endpoint is deprecated.**

Returns a paginated list of `EmployeeWage` instances for a business.

```php
function listEmployeeWages(?string $employeeId = null, ?int $limit = null, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `employeeId` | `?string` | Query, Optional | Filter the returned wages to only those that are associated with the specified employee. |
| `limit` | `?int` | Query, Optional | The maximum number of `EmployeeWage` results to return per page. The number can range between<br>1 and 200. The default is 200. |
| `cursor` | `?string` | Query, Optional | A pointer to the next page of `EmployeeWage` results to fetch. |

## Response Type

[`ListEmployeeWagesResponse`](../../doc/models/list-employee-wages-response.md)

## Example Usage

```php
$apiResponse = $laborApi->listEmployeeWages();

if ($apiResponse->isSuccess()) {
    $listEmployeeWagesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Employee Wage

**This endpoint is deprecated.**

Returns a single `EmployeeWage` specified by `id`.

```php
function getEmployeeWage(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `EmployeeWage` being retrieved. |

## Response Type

[`GetEmployeeWageResponse`](../../doc/models/get-employee-wage-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getEmployeeWage($id);

if ($apiResponse->isSuccess()) {
    $getEmployeeWageResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Shift

Creates a new `Shift`.

A `Shift` represents a complete workday for a single employee.
You must provide the following values in your request to this
endpoint:

- `location_id`
- `employee_id`
- `start_at`

An attempt to create a new `Shift` can result in a `BAD_REQUEST` error when:

- The `status` of the new `Shift` is `OPEN` and the employee has another
  shift with an `OPEN` status.
- The `start_at` date is in the future.
- The `start_at` or `end_at` date overlaps another shift for the same employee.
- The `Break` instances are set in the request and a break `start_at`
  is before the `Shift.start_at`, a break `end_at` is after
  the `Shift.end_at`, or both.

```php
function createShift(CreateShiftRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateShiftRequest`](../../doc/models/create-shift-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateShiftResponse`](../../doc/models/create-shift-response.md)

## Example Usage

```php
$body = CreateShiftRequestBuilder::init(
    ShiftBuilder::init(
        '2019-01-25T08:11:00+00:00'
    )
        ->locationId('PAA1RJZZKXBFG')
        ->endAt('2019-01-25T18:11:00+00:00')
        ->wage(
            ShiftWageBuilder::init()
                ->title('Barista')
                ->hourlyRate(
                    MoneyBuilder::init()
                        ->amount(1100)
                        ->currency(Currency::USD)
                        ->build()
                )
                ->build()
        )
        ->breaks(
            [
                MBreakBuilder::init(
                    '2019-01-25T11:11:00+00:00',
                    'REGS1EQR1TPZ5',
                    'Tea Break',
                    'PT5M',
                    true
                )
                    ->endAt('2019-01-25T11:16:00+00:00')
                    ->build()
            ]
        )
        ->teamMemberId('ormj0jJJZ5OZIzxrZYJI')
        ->build()
)
    ->idempotencyKey('HIDSNG5KS478L')
    ->build();

$apiResponse = $laborApi->createShift($body);

if ($apiResponse->isSuccess()) {
    $createShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Shifts

Returns a paginated list of `Shift` records for a business.
The list to be returned can be filtered by:

- Location IDs.
- Employee IDs.
- Shift status (`OPEN` and `CLOSED`).
- Shift start.
- Shift end.
- Workday details.

The list can be sorted by:

- `start_at`.
- `end_at`.
- `created_at`.
- `updated_at`.

```php
function searchShifts(SearchShiftsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchShiftsRequest`](../../doc/models/search-shifts-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchShiftsResponse`](../../doc/models/search-shifts-response.md)

## Example Usage

```php
$body = SearchShiftsRequestBuilder::init()
    ->query(
        ShiftQueryBuilder::init()
            ->filter(
                ShiftFilterBuilder::init()
                    ->workday(
                        ShiftWorkdayBuilder::init()
                            ->dateRange(
                                DateRangeBuilder::init()
                                    ->startDate('2019-01-20')
                                    ->endDate('2019-02-03')
                                    ->build()
                            )
                            ->matchShiftsBy(ShiftWorkdayMatcher::START_AT)
                            ->defaultTimezone('America/Los_Angeles')
                            ->build()
                    )
                    ->build()
            )
            ->build()
    )
    ->limit(100)
    ->build();

$apiResponse = $laborApi->searchShifts($body);

if ($apiResponse->isSuccess()) {
    $searchShiftsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Shift

Deletes a `Shift`.

```php
function deleteShift(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `Shift` being deleted. |

## Response Type

[`DeleteShiftResponse`](../../doc/models/delete-shift-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->deleteShift($id);

if ($apiResponse->isSuccess()) {
    $deleteShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Shift

Returns a single `Shift` specified by `id`.

```php
function getShift(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `Shift` being retrieved. |

## Response Type

[`GetShiftResponse`](../../doc/models/get-shift-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getShift($id);

if ($apiResponse->isSuccess()) {
    $getShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Shift

Updates an existing `Shift`.

When adding a `Break` to a `Shift`, any earlier `Break` instances in the `Shift` have
the `end_at` property set to a valid RFC-3339 datetime string.

When closing a `Shift`, all `Break` instances in the `Shift` must be complete with `end_at`
set on each `Break`.

```php
function updateShift(string $id, UpdateShiftRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The ID of the object being updated. |
| `body` | [`UpdateShiftRequest`](../../doc/models/update-shift-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateShiftResponse`](../../doc/models/update-shift-response.md)

## Example Usage

```php
$id = 'id0';

$body = UpdateShiftRequestBuilder::init(
    ShiftBuilder::init(
        '2019-01-25T08:11:00+00:00'
    )
        ->locationId('PAA1RJZZKXBFG')
        ->endAt('2019-01-25T18:11:00+00:00')
        ->wage(
            ShiftWageBuilder::init()
                ->title('Bartender')
                ->hourlyRate(
                    MoneyBuilder::init()
                        ->amount(1500)
                        ->currency(Currency::USD)
                        ->build()
                )
                ->build()
        )
        ->breaks(
            [
                MBreakBuilder::init(
                    '2019-01-25T11:11:00+00:00',
                    'REGS1EQR1TPZ5',
                    'Tea Break',
                    'PT5M',
                    true
                )
                    ->id('X7GAQYVVRRG6P')
                    ->endAt('2019-01-25T11:16:00+00:00')
                    ->build()
            ]
        )
        ->version(1)
        ->teamMemberId('ormj0jJJZ5OZIzxrZYJI')
        ->build()
)->build();

$apiResponse = $laborApi->updateShift(
    $id,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Team Member Wages

Returns a paginated list of `TeamMemberWage` instances for a business.

```php
function listTeamMemberWages(
    ?string $teamMemberId = null,
    ?int $limit = null,
    ?string $cursor = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `teamMemberId` | `?string` | Query, Optional | Filter the returned wages to only those that are associated with the<br>specified team member. |
| `limit` | `?int` | Query, Optional | The maximum number of `TeamMemberWage` results to return per page. The number can range between<br>1 and 200. The default is 200. |
| `cursor` | `?string` | Query, Optional | A pointer to the next page of `EmployeeWage` results to fetch. |

## Response Type

[`ListTeamMemberWagesResponse`](../../doc/models/list-team-member-wages-response.md)

## Example Usage

```php
$apiResponse = $laborApi->listTeamMemberWages();

if ($apiResponse->isSuccess()) {
    $listTeamMemberWagesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Team Member Wage

Returns a single `TeamMemberWage` specified by `id`.

```php
function getTeamMemberWage(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `TeamMemberWage` being retrieved. |

## Response Type

[`GetTeamMemberWageResponse`](../../doc/models/get-team-member-wage-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $laborApi->getTeamMemberWage($id);

if ($apiResponse->isSuccess()) {
    $getTeamMemberWageResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Workweek Configs

Returns a list of `WorkweekConfig` instances for a business.

```php
function listWorkweekConfigs(?int $limit = null, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `limit` | `?int` | Query, Optional | The maximum number of `WorkweekConfigs` results to return per page. |
| `cursor` | `?string` | Query, Optional | A pointer to the next page of `WorkweekConfig` results to fetch. |

## Response Type

[`ListWorkweekConfigsResponse`](../../doc/models/list-workweek-configs-response.md)

## Example Usage

```php
$apiResponse = $laborApi->listWorkweekConfigs();

if ($apiResponse->isSuccess()) {
    $listWorkweekConfigsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Workweek Config

Updates a `WorkweekConfig`.

```php
function updateWorkweekConfig(string $id, UpdateWorkweekConfigRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The UUID for the `WorkweekConfig` object being updated. |
| `body` | [`UpdateWorkweekConfigRequest`](../../doc/models/update-workweek-config-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateWorkweekConfigResponse`](../../doc/models/update-workweek-config-response.md)

## Example Usage

```php
$id = 'id0';

$body = UpdateWorkweekConfigRequestBuilder::init(
    WorkweekConfigBuilder::init(
        Weekday::MON,
        '10:00'
    )
        ->version(10)
        ->build()
)->build();

$apiResponse = $laborApi->updateWorkweekConfig(
    $id,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateWorkweekConfigResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

