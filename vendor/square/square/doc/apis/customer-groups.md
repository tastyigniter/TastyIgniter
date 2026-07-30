# Customer Groups

```php
$customerGroupsApi = $client->getCustomerGroupsApi();
```

## Class Name

`CustomerGroupsApi`

## Methods

* [List Customer Groups](../../doc/apis/customer-groups.md#list-customer-groups)
* [Create Customer Group](../../doc/apis/customer-groups.md#create-customer-group)
* [Delete Customer Group](../../doc/apis/customer-groups.md#delete-customer-group)
* [Retrieve Customer Group](../../doc/apis/customer-groups.md#retrieve-customer-group)
* [Update Customer Group](../../doc/apis/customer-groups.md#update-customer-group)


# List Customer Groups

Retrieves the list of customer groups of a business.

```php
function listCustomerGroups(?string $cursor = null, ?int $limit = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for your original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single page. This limit is advisory. The response might contain more or fewer results.<br>If the limit is less than 1 or greater than 50, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 50.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListCustomerGroupsResponse`](../../doc/models/list-customer-groups-response.md)

## Example Usage

```php
$apiResponse = $customerGroupsApi->listCustomerGroups();

if ($apiResponse->isSuccess()) {
    $listCustomerGroupsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Customer Group

Creates a new customer group for a business.

The request must include the `name` value of the group.

```php
function createCustomerGroup(CreateCustomerGroupRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateCustomerGroupRequest`](../../doc/models/create-customer-group-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateCustomerGroupResponse`](../../doc/models/create-customer-group-response.md)

## Example Usage

```php
$body = CreateCustomerGroupRequestBuilder::init(
    CustomerGroupBuilder::init(
        'Loyal Customers'
    )->build()
)->build();

$apiResponse = $customerGroupsApi->createCustomerGroup($body);

if ($apiResponse->isSuccess()) {
    $createCustomerGroupResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Customer Group

Deletes a customer group as identified by the `group_id` value.

```php
function deleteCustomerGroup(string $groupId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `groupId` | `string` | Template, Required | The ID of the customer group to delete. |

## Response Type

[`DeleteCustomerGroupResponse`](../../doc/models/delete-customer-group-response.md)

## Example Usage

```php
$groupId = 'group_id0';

$apiResponse = $customerGroupsApi->deleteCustomerGroup($groupId);

if ($apiResponse->isSuccess()) {
    $deleteCustomerGroupResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Customer Group

Retrieves a specific customer group as identified by the `group_id` value.

```php
function retrieveCustomerGroup(string $groupId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `groupId` | `string` | Template, Required | The ID of the customer group to retrieve. |

## Response Type

[`RetrieveCustomerGroupResponse`](../../doc/models/retrieve-customer-group-response.md)

## Example Usage

```php
$groupId = 'group_id0';

$apiResponse = $customerGroupsApi->retrieveCustomerGroup($groupId);

if ($apiResponse->isSuccess()) {
    $retrieveCustomerGroupResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Customer Group

Updates a customer group as identified by the `group_id` value.

```php
function updateCustomerGroup(string $groupId, UpdateCustomerGroupRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `groupId` | `string` | Template, Required | The ID of the customer group to update. |
| `body` | [`UpdateCustomerGroupRequest`](../../doc/models/update-customer-group-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateCustomerGroupResponse`](../../doc/models/update-customer-group-response.md)

## Example Usage

```php
$groupId = 'group_id0';

$body = UpdateCustomerGroupRequestBuilder::init(
    CustomerGroupBuilder::init(
        'Loyal Customers'
    )->build()
)->build();

$apiResponse = $customerGroupsApi->updateCustomerGroup(
    $groupId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateCustomerGroupResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

