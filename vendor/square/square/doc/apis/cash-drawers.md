# Cash Drawers

```php
$cashDrawersApi = $client->getCashDrawersApi();
```

## Class Name

`CashDrawersApi`

## Methods

* [List Cash Drawer Shifts](../../doc/apis/cash-drawers.md#list-cash-drawer-shifts)
* [Retrieve Cash Drawer Shift](../../doc/apis/cash-drawers.md#retrieve-cash-drawer-shift)
* [List Cash Drawer Shift Events](../../doc/apis/cash-drawers.md#list-cash-drawer-shift-events)


# List Cash Drawer Shifts

Provides the details for all of the cash drawer shifts for a location
in a date range.

```php
function listCashDrawerShifts(
    string $locationId,
    ?string $sortOrder = null,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?int $limit = null,
    ?string $cursor = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Query, Required | The ID of the location to query for a list of cash drawer shifts. |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which cash drawer shifts are listed in the response,<br>based on their opened_at field. Default value: ASC |
| `beginTime` | `?string` | Query, Optional | The inclusive start time of the query on opened_at, in ISO 8601 format. |
| `endTime` | `?string` | Query, Optional | The exclusive end date of the query on opened_at, in ISO 8601 format. |
| `limit` | `?int` | Query, Optional | Number of cash drawer shift events in a page of results (200 by<br>default, 1000 max). |
| `cursor` | `?string` | Query, Optional | Opaque cursor for fetching the next page of results. |

## Response Type

[`ListCashDrawerShiftsResponse`](../../doc/models/list-cash-drawer-shifts-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $cashDrawersApi->listCashDrawerShifts($locationId);

if ($apiResponse->isSuccess()) {
    $listCashDrawerShiftsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Cash Drawer Shift

Provides the summary details for a single cash drawer shift. See
[ListCashDrawerShiftEvents](../../doc/apis/cash-drawers.md#list-cash-drawer-shift-events) for a list of cash drawer shift events.

```php
function retrieveCashDrawerShift(string $locationId, string $shiftId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Query, Required | The ID of the location to retrieve cash drawer shifts from. |
| `shiftId` | `string` | Template, Required | The shift ID. |

## Response Type

[`RetrieveCashDrawerShiftResponse`](../../doc/models/retrieve-cash-drawer-shift-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$shiftId = 'shift_id0';

$apiResponse = $cashDrawersApi->retrieveCashDrawerShift(
    $locationId,
    $shiftId
);

if ($apiResponse->isSuccess()) {
    $retrieveCashDrawerShiftResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Cash Drawer Shift Events

Provides a paginated list of events for a single cash drawer shift.

```php
function listCashDrawerShiftEvents(
    string $locationId,
    string $shiftId,
    ?int $limit = null,
    ?string $cursor = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Query, Required | The ID of the location to list cash drawer shifts for. |
| `shiftId` | `string` | Template, Required | The shift ID. |
| `limit` | `?int` | Query, Optional | Number of resources to be returned in a page of results (200 by<br>default, 1000 max). |
| `cursor` | `?string` | Query, Optional | Opaque cursor for fetching the next page of results. |

## Response Type

[`ListCashDrawerShiftEventsResponse`](../../doc/models/list-cash-drawer-shift-events-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$shiftId = 'shift_id0';

$apiResponse = $cashDrawersApi->listCashDrawerShiftEvents(
    $locationId,
    $shiftId
);

if ($apiResponse->isSuccess()) {
    $listCashDrawerShiftEventsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

