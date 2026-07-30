# Customer Segments

```php
$customerSegmentsApi = $client->getCustomerSegmentsApi();
```

## Class Name

`CustomerSegmentsApi`

## Methods

* [List Customer Segments](../../doc/apis/customer-segments.md#list-customer-segments)
* [Retrieve Customer Segment](../../doc/apis/customer-segments.md#retrieve-customer-segment)


# List Customer Segments

Retrieves the list of customer segments of a business.

```php
function listCustomerSegments(?string $cursor = null, ?int $limit = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by previous calls to `ListCustomerSegments`.<br>This cursor is used to retrieve the next set of query results.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single page. This limit is advisory. The response might contain more or fewer results.<br>If the specified limit is less than 1 or greater than 50, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 50.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListCustomerSegmentsResponse`](../../doc/models/list-customer-segments-response.md)

## Example Usage

```php
$apiResponse = $customerSegmentsApi->listCustomerSegments();

if ($apiResponse->isSuccess()) {
    $listCustomerSegmentsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Customer Segment

Retrieves a specific customer segment as identified by the `segment_id` value.

```php
function retrieveCustomerSegment(string $segmentId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `segmentId` | `string` | Template, Required | The Square-issued ID of the customer segment. |

## Response Type

[`RetrieveCustomerSegmentResponse`](../../doc/models/retrieve-customer-segment-response.md)

## Example Usage

```php
$segmentId = 'segment_id4';

$apiResponse = $customerSegmentsApi->retrieveCustomerSegment($segmentId);

if ($apiResponse->isSuccess()) {
    $retrieveCustomerSegmentResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

