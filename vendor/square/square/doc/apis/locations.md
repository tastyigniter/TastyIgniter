# Locations

```php
$locationsApi = $client->getLocationsApi();
```

## Class Name

`LocationsApi`

## Methods

* [List Locations](../../doc/apis/locations.md#list-locations)
* [Create Location](../../doc/apis/locations.md#create-location)
* [Retrieve Location](../../doc/apis/locations.md#retrieve-location)
* [Update Location](../../doc/apis/locations.md#update-location)


# List Locations

Provides details about all of the seller's [locations](https://developer.squareup.com/docs/locations-api),
including those with an inactive status.

```php
function listLocations(): ApiResponse
```

## Response Type

[`ListLocationsResponse`](../../doc/models/list-locations-response.md)

## Example Usage

```php
$apiResponse = $locationsApi->listLocations();

if ($apiResponse->isSuccess()) {
    $listLocationsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Location

Creates a [location](https://developer.squareup.com/docs/locations-api).
Creating new locations allows for separate configuration of receipt layouts, item prices,
and sales reports. Developers can use locations to separate sales activity through applications
that integrate with Square from sales activity elsewhere in a seller's account.
Locations created programmatically with the Locations API last forever and
are visible to the seller for their own management. Therefore, ensure that
each location has a sensible and unique name.

```php
function createLocation(CreateLocationRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateLocationRequest`](../../doc/models/create-location-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateLocationResponse`](../../doc/models/create-location-response.md)

## Example Usage

```php
$body = CreateLocationRequestBuilder::init()
    ->location(
        LocationBuilder::init()
            ->name('Midtown')
            ->address(
                AddressBuilder::init()
                    ->addressLine1('1234 Peachtree St. NE')
                    ->locality('Atlanta')
                    ->administrativeDistrictLevel1('GA')
                    ->postalCode('30309')
                    ->build()
            )
            ->description('Midtown Atlanta store')
            ->build()
    )
    ->build();

$apiResponse = $locationsApi->createLocation($body);

if ($apiResponse->isSuccess()) {
    $createLocationResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Location

Retrieves details of a single location. Specify "main"
as the location ID to retrieve details of the [main location](https://developer.squareup.com/docs/locations-api#about-the-main-location).

```php
function retrieveLocation(string $locationId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to retrieve. Specify the string<br>"main" to return the main location. |

## Response Type

[`RetrieveLocationResponse`](../../doc/models/retrieve-location-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $locationsApi->retrieveLocation($locationId);

if ($apiResponse->isSuccess()) {
    $retrieveLocationResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Location

Updates a [location](https://developer.squareup.com/docs/locations-api).

```php
function updateLocation(string $locationId, UpdateLocationRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to update. |
| `body` | [`UpdateLocationRequest`](../../doc/models/update-location-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateLocationResponse`](../../doc/models/update-location-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$body = UpdateLocationRequestBuilder::init()
    ->location(
        LocationBuilder::init()
            ->businessHours(
                BusinessHoursBuilder::init()
                    ->periods(
                        [
                            BusinessHoursPeriodBuilder::init()
                                ->dayOfWeek(DayOfWeek::FRI)
                                ->startLocalTime('07:00')
                                ->endLocalTime('18:00')
                                ->build(),
                            BusinessHoursPeriodBuilder::init()
                                ->dayOfWeek(DayOfWeek::SAT)
                                ->startLocalTime('07:00')
                                ->endLocalTime('18:00')
                                ->build(),
                            BusinessHoursPeriodBuilder::init()
                                ->dayOfWeek(DayOfWeek::SUN)
                                ->startLocalTime('09:00')
                                ->endLocalTime('15:00')
                                ->build()
                        ]
                    )
                    ->build()
            )
            ->description('Midtown Atlanta store - Open weekends')
            ->build()
    )
    ->build();

$apiResponse = $locationsApi->updateLocation(
    $locationId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateLocationResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

