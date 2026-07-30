# Booking Custom Attributes

```php
$bookingCustomAttributesApi = $client->getBookingCustomAttributesApi();
```

## Class Name

`BookingCustomAttributesApi`

## Methods

* [List Booking Custom Attribute Definitions](../../doc/apis/booking-custom-attributes.md#list-booking-custom-attribute-definitions)
* [Create Booking Custom Attribute Definition](../../doc/apis/booking-custom-attributes.md#create-booking-custom-attribute-definition)
* [Delete Booking Custom Attribute Definition](../../doc/apis/booking-custom-attributes.md#delete-booking-custom-attribute-definition)
* [Retrieve Booking Custom Attribute Definition](../../doc/apis/booking-custom-attributes.md#retrieve-booking-custom-attribute-definition)
* [Update Booking Custom Attribute Definition](../../doc/apis/booking-custom-attributes.md#update-booking-custom-attribute-definition)
* [Bulk Delete Booking Custom Attributes](../../doc/apis/booking-custom-attributes.md#bulk-delete-booking-custom-attributes)
* [Bulk Upsert Booking Custom Attributes](../../doc/apis/booking-custom-attributes.md#bulk-upsert-booking-custom-attributes)
* [List Booking Custom Attributes](../../doc/apis/booking-custom-attributes.md#list-booking-custom-attributes)
* [Delete Booking Custom Attribute](../../doc/apis/booking-custom-attributes.md#delete-booking-custom-attribute)
* [Retrieve Booking Custom Attribute](../../doc/apis/booking-custom-attributes.md#retrieve-booking-custom-attribute)
* [Upsert Booking Custom Attribute](../../doc/apis/booking-custom-attributes.md#upsert-booking-custom-attribute)


# List Booking Custom Attribute Definitions

Get all bookings custom attribute definitions.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and `APPOINTMENTS_READ` for the OAuth scope.

```php
function listBookingCustomAttributeDefinitions(?int $limit = null, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListBookingCustomAttributeDefinitionsResponse`](../../doc/models/list-booking-custom-attribute-definitions-response.md)

## Example Usage

```php
$apiResponse = $bookingCustomAttributesApi->listBookingCustomAttributeDefinitions();

if ($apiResponse->isSuccess()) {
    $listBookingCustomAttributeDefinitionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Booking Custom Attribute Definition

Creates a bookings custom attribute definition.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function createBookingCustomAttributeDefinition(
    CreateBookingCustomAttributeDefinitionRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateBookingCustomAttributeDefinitionRequest`](../../doc/models/create-booking-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateBookingCustomAttributeDefinitionResponse`](../../doc/models/create-booking-custom-attribute-definition-response.md)

## Example Usage

```php
$body = CreateBookingCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()->build()
)->build();

$apiResponse = $bookingCustomAttributesApi->createBookingCustomAttributeDefinition($body);

if ($apiResponse->isSuccess()) {
    $createBookingCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Booking Custom Attribute Definition

Deletes a bookings custom attribute definition.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function deleteBookingCustomAttributeDefinition(string $key): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to delete. |

## Response Type

[`DeleteBookingCustomAttributeDefinitionResponse`](../../doc/models/delete-booking-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $bookingCustomAttributesApi->deleteBookingCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $deleteBookingCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Booking Custom Attribute Definition

Retrieves a bookings custom attribute definition.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and `APPOINTMENTS_READ` for the OAuth scope.

```php
function retrieveBookingCustomAttributeDefinition(string $key, ?int $version = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to retrieve. If the requesting application<br>is not the definition owner, you must use the qualified key. |
| `version` | `?int` | Query, Optional | The current version of the custom attribute definition, which is used for strongly consistent<br>reads to guarantee that you receive the most up-to-date data. When included in the request,<br>Square returns the specified version or a higher version if one exists. If the specified version<br>is higher than the current version, Square returns a `BAD_REQUEST` error. |

## Response Type

[`RetrieveBookingCustomAttributeDefinitionResponse`](../../doc/models/retrieve-booking-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $bookingCustomAttributesApi->retrieveBookingCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $retrieveBookingCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Booking Custom Attribute Definition

Updates a bookings custom attribute definition.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function updateBookingCustomAttributeDefinition(
    string $key,
    UpdateBookingCustomAttributeDefinitionRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to update. |
| `body` | [`UpdateBookingCustomAttributeDefinitionRequest`](../../doc/models/update-booking-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateBookingCustomAttributeDefinitionResponse`](../../doc/models/update-booking-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$body = UpdateBookingCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()->build()
)->build();

$apiResponse = $bookingCustomAttributesApi->updateBookingCustomAttributeDefinition(
    $key,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateBookingCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Delete Booking Custom Attributes

Bulk deletes bookings custom attributes.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function bulkDeleteBookingCustomAttributes(BulkDeleteBookingCustomAttributesRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkDeleteBookingCustomAttributesRequest`](../../doc/models/bulk-delete-booking-custom-attributes-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkDeleteBookingCustomAttributesResponse`](../../doc/models/bulk-delete-booking-custom-attributes-response.md)

## Example Usage

```php
$body = BulkDeleteBookingCustomAttributesRequestBuilder::init(
    [
        'key0' => BookingCustomAttributeDeleteRequestBuilder::init(
            'booking_id8',
            'key4'
        )->build(),
        'key1' => BookingCustomAttributeDeleteRequestBuilder::init(
            'booking_id9',
            'key5'
        )->build()
    ]
)->build();

$apiResponse = $bookingCustomAttributesApi->bulkDeleteBookingCustomAttributes($body);

if ($apiResponse->isSuccess()) {
    $bulkDeleteBookingCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Upsert Booking Custom Attributes

Bulk upserts bookings custom attributes.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function bulkUpsertBookingCustomAttributes(BulkUpsertBookingCustomAttributesRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkUpsertBookingCustomAttributesRequest`](../../doc/models/bulk-upsert-booking-custom-attributes-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkUpsertBookingCustomAttributesResponse`](../../doc/models/bulk-upsert-booking-custom-attributes-response.md)

## Example Usage

```php
$body = BulkUpsertBookingCustomAttributesRequestBuilder::init(
    [
        'key0' => BookingCustomAttributeUpsertRequestBuilder::init(
            'booking_id8',
            CustomAttributeBuilder::init()->build()
        )->build(),
        'key1' => BookingCustomAttributeUpsertRequestBuilder::init(
            'booking_id9',
            CustomAttributeBuilder::init()->build()
        )->build()
    ]
)->build();

$apiResponse = $bookingCustomAttributesApi->bulkUpsertBookingCustomAttributes($body);

if ($apiResponse->isSuccess()) {
    $bulkUpsertBookingCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Booking Custom Attributes

Lists a booking's custom attributes.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and `APPOINTMENTS_READ` for the OAuth scope.

```php
function listBookingCustomAttributes(
    string $bookingId,
    ?int $limit = null,
    ?string $cursor = null,
    ?bool $withDefinitions = false
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `bookingId` | `string` | Template, Required | The ID of the target [booking](entity:Booking). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request. For more<br>information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `withDefinitions` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of each<br>custom attribute. Set this parameter to `true` to get the name and description of each custom<br>attribute, information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |

## Response Type

[`ListBookingCustomAttributesResponse`](../../doc/models/list-booking-custom-attributes-response.md)

## Example Usage

```php
$bookingId = 'booking_id4';

$withDefinitions = false;

$apiResponse = $bookingCustomAttributesApi->listBookingCustomAttributes(
    $bookingId,
    $withDefinitions
);

if ($apiResponse->isSuccess()) {
    $listBookingCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Booking Custom Attribute

Deletes a bookings custom attribute.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function deleteBookingCustomAttribute(string $bookingId, string $key): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `bookingId` | `string` | Template, Required | The ID of the target [booking](entity:Booking). |
| `key` | `string` | Template, Required | The key of the custom attribute to delete. This key must match the `key` of a custom<br>attribute definition in the Square seller account. If the requesting application is not the<br>definition owner, you must use the qualified key. |

## Response Type

[`DeleteBookingCustomAttributeResponse`](../../doc/models/delete-booking-custom-attribute-response.md)

## Example Usage

```php
$bookingId = 'booking_id4';

$key = 'key0';

$apiResponse = $bookingCustomAttributesApi->deleteBookingCustomAttribute(
    $bookingId,
    $key
);

if ($apiResponse->isSuccess()) {
    $deleteBookingCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Booking Custom Attribute

Retrieves a bookings custom attribute.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_READ` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_READ` and `APPOINTMENTS_READ` for the OAuth scope.

```php
function retrieveBookingCustomAttribute(
    string $bookingId,
    string $key,
    ?bool $withDefinition = false,
    ?int $version = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `bookingId` | `string` | Template, Required | The ID of the target [booking](entity:Booking). |
| `key` | `string` | Template, Required | The key of the custom attribute to retrieve. This key must match the `key` of a custom<br>attribute definition in the Square seller account. If the requesting application is not the<br>definition owner, you must use the qualified key. |
| `withDefinition` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of<br>the custom attribute. Set this parameter to `true` to get the name and description of the custom<br>attribute, information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |
| `version` | `?int` | Query, Optional | The current version of the custom attribute, which is used for strongly consistent reads to<br>guarantee that you receive the most up-to-date data. When included in the request, Square<br>returns the specified version or a higher version if one exists. If the specified version is<br>higher than the current version, Square returns a `BAD_REQUEST` error. |

## Response Type

[`RetrieveBookingCustomAttributeResponse`](../../doc/models/retrieve-booking-custom-attribute-response.md)

## Example Usage

```php
$bookingId = 'booking_id4';

$key = 'key0';

$withDefinition = false;

$apiResponse = $bookingCustomAttributesApi->retrieveBookingCustomAttribute(
    $bookingId,
    $key,
    $withDefinition
);

if ($apiResponse->isSuccess()) {
    $retrieveBookingCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Upsert Booking Custom Attribute

Upserts a bookings custom attribute.

To call this endpoint with buyer-level permissions, set `APPOINTMENTS_WRITE` for the OAuth scope.
To call this endpoint with seller-level permissions, set `APPOINTMENTS_ALL_WRITE` and `APPOINTMENTS_WRITE` for the OAuth scope.

For calls to this endpoint with seller-level permissions to succeed, the seller must have subscribed to *Appointments Plus*
or *Appointments Premium*.

```php
function upsertBookingCustomAttribute(
    string $bookingId,
    string $key,
    UpsertBookingCustomAttributeRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `bookingId` | `string` | Template, Required | The ID of the target [booking](entity:Booking). |
| `key` | `string` | Template, Required | The key of the custom attribute to create or update. This key must match the `key` of a<br>custom attribute definition in the Square seller account. If the requesting application is not<br>the definition owner, you must use the qualified key. |
| `body` | [`UpsertBookingCustomAttributeRequest`](../../doc/models/upsert-booking-custom-attribute-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpsertBookingCustomAttributeResponse`](../../doc/models/upsert-booking-custom-attribute-response.md)

## Example Usage

```php
$bookingId = 'booking_id4';

$key = 'key0';

$body = UpsertBookingCustomAttributeRequestBuilder::init(
    CustomAttributeBuilder::init()->build()
)->build();

$apiResponse = $bookingCustomAttributesApi->upsertBookingCustomAttribute(
    $bookingId,
    $key,
    $body
);

if ($apiResponse->isSuccess()) {
    $upsertBookingCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

