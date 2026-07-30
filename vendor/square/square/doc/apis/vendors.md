# Vendors

```php
$vendorsApi = $client->getVendorsApi();
```

## Class Name

`VendorsApi`

## Methods

* [Bulk Create Vendors](../../doc/apis/vendors.md#bulk-create-vendors)
* [Bulk Retrieve Vendors](../../doc/apis/vendors.md#bulk-retrieve-vendors)
* [Bulk Update Vendors](../../doc/apis/vendors.md#bulk-update-vendors)
* [Create Vendor](../../doc/apis/vendors.md#create-vendor)
* [Search Vendors](../../doc/apis/vendors.md#search-vendors)
* [Retrieve Vendor](../../doc/apis/vendors.md#retrieve-vendor)
* [Update Vendor](../../doc/apis/vendors.md#update-vendor)


# Bulk Create Vendors

Creates one or more [Vendor](../../doc/models/vendor.md) objects to represent suppliers to a seller.

```php
function bulkCreateVendors(BulkCreateVendorsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkCreateVendorsRequest`](../../doc/models/bulk-create-vendors-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkCreateVendorsResponse`](../../doc/models/bulk-create-vendors-response.md)

## Example Usage

```php
$body = BulkCreateVendorsRequestBuilder::init(
    [
        'key0' => VendorBuilder::init()->build(),
        'key1' => VendorBuilder::init()->build()
    ]
)->build();

$apiResponse = $vendorsApi->bulkCreateVendors($body);

if ($apiResponse->isSuccess()) {
    $bulkCreateVendorsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Retrieve Vendors

Retrieves one or more vendors of specified [Vendor](../../doc/models/vendor.md) IDs.

```php
function bulkRetrieveVendors(BulkRetrieveVendorsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkRetrieveVendorsRequest`](../../doc/models/bulk-retrieve-vendors-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkRetrieveVendorsResponse`](../../doc/models/bulk-retrieve-vendors-response.md)

## Example Usage

```php
$body = BulkRetrieveVendorsRequestBuilder::init()
    ->vendorIds(
        [
            'INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4'
        ]
    )
    ->build();

$apiResponse = $vendorsApi->bulkRetrieveVendors($body);

if ($apiResponse->isSuccess()) {
    $bulkRetrieveVendorsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Update Vendors

Updates one or more of existing [Vendor](../../doc/models/vendor.md) objects as suppliers to a seller.

```php
function bulkUpdateVendors(BulkUpdateVendorsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkUpdateVendorsRequest`](../../doc/models/bulk-update-vendors-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkUpdateVendorsResponse`](../../doc/models/bulk-update-vendors-response.md)

## Example Usage

```php
$body = BulkUpdateVendorsRequestBuilder::init(
    [
        'key0' => UpdateVendorRequestBuilder::init(
            VendorBuilder::init()->build()
        )->build(),
        'key1' => UpdateVendorRequestBuilder::init(
            VendorBuilder::init()->build()
        )->build()
    ]
)->build();

$apiResponse = $vendorsApi->bulkUpdateVendors($body);

if ($apiResponse->isSuccess()) {
    $bulkUpdateVendorsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Vendor

Creates a single [Vendor](../../doc/models/vendor.md) object to represent a supplier to a seller.

```php
function createVendor(CreateVendorRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateVendorRequest`](../../doc/models/create-vendor-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateVendorResponse`](../../doc/models/create-vendor-response.md)

## Example Usage

```php
$body = CreateVendorRequestBuilder::init(
    'idempotency_key2'
)->build();

$apiResponse = $vendorsApi->createVendor($body);

if ($apiResponse->isSuccess()) {
    $createVendorResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Vendors

Searches for vendors using a filter against supported [Vendor](../../doc/models/vendor.md) properties and a supported sorter.

```php
function searchVendors(SearchVendorsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchVendorsRequest`](../../doc/models/search-vendors-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchVendorsResponse`](../../doc/models/search-vendors-response.md)

## Example Usage

```php
$body = SearchVendorsRequestBuilder::init()->build();

$apiResponse = $vendorsApi->searchVendors($body);

if ($apiResponse->isSuccess()) {
    $searchVendorsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Vendor

Retrieves the vendor of a specified [Vendor](../../doc/models/vendor.md) ID.

```php
function retrieveVendor(string $vendorId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `vendorId` | `string` | Template, Required | ID of the [Vendor](entity:Vendor) to retrieve. |

## Response Type

[`RetrieveVendorResponse`](../../doc/models/retrieve-vendor-response.md)

## Example Usage

```php
$vendorId = 'vendor_id8';

$apiResponse = $vendorsApi->retrieveVendor($vendorId);

if ($apiResponse->isSuccess()) {
    $retrieveVendorResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Vendor

Updates an existing [Vendor](../../doc/models/vendor.md) object as a supplier to a seller.

```php
function updateVendor(UpdateVendorRequest $body, string $vendorId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`UpdateVendorRequest`](../../doc/models/update-vendor-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |
| `vendorId` | `string` | Template, Required | - |

## Response Type

[`UpdateVendorResponse`](../../doc/models/update-vendor-response.md)

## Example Usage

```php
$body = UpdateVendorRequestBuilder::init(
    VendorBuilder::init()
        ->id('INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4')
        ->name('Jack\'s Chicken Shack')
        ->version(1)
        ->status(VendorStatus::ACTIVE)
        ->build()
)
    ->idempotencyKey('8fc6a5b0-9fe8-4b46-b46b-2ef95793abbe')
    ->build();

$vendorId = 'vendor_id8';

$apiResponse = $vendorsApi->updateVendor(
    $body,
    $vendorId
);

if ($apiResponse->isSuccess()) {
    $updateVendorResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

