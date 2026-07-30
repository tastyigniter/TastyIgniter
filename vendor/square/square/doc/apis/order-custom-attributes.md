# Order Custom Attributes

```php
$orderCustomAttributesApi = $client->getOrderCustomAttributesApi();
```

## Class Name

`OrderCustomAttributesApi`

## Methods

* [List Order Custom Attribute Definitions](../../doc/apis/order-custom-attributes.md#list-order-custom-attribute-definitions)
* [Create Order Custom Attribute Definition](../../doc/apis/order-custom-attributes.md#create-order-custom-attribute-definition)
* [Delete Order Custom Attribute Definition](../../doc/apis/order-custom-attributes.md#delete-order-custom-attribute-definition)
* [Retrieve Order Custom Attribute Definition](../../doc/apis/order-custom-attributes.md#retrieve-order-custom-attribute-definition)
* [Update Order Custom Attribute Definition](../../doc/apis/order-custom-attributes.md#update-order-custom-attribute-definition)
* [Bulk Delete Order Custom Attributes](../../doc/apis/order-custom-attributes.md#bulk-delete-order-custom-attributes)
* [Bulk Upsert Order Custom Attributes](../../doc/apis/order-custom-attributes.md#bulk-upsert-order-custom-attributes)
* [List Order Custom Attributes](../../doc/apis/order-custom-attributes.md#list-order-custom-attributes)
* [Delete Order Custom Attribute](../../doc/apis/order-custom-attributes.md#delete-order-custom-attribute)
* [Retrieve Order Custom Attribute](../../doc/apis/order-custom-attributes.md#retrieve-order-custom-attribute)
* [Upsert Order Custom Attribute](../../doc/apis/order-custom-attributes.md#upsert-order-custom-attribute)


# List Order Custom Attribute Definitions

Lists the order-related [custom attribute definitions](../../doc/models/custom-attribute-definition.md) that belong to a Square seller account.

When all response pages are retrieved, the results include all custom attribute definitions
that are visible to the requesting application, including those that are created by other
applications and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that
seller-defined custom attributes (also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function listOrderCustomAttributeDefinitions(
    ?string $visibilityFilter = null,
    ?string $cursor = null,
    ?int $limit = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `visibilityFilter` | [`?string (VisibilityFilter)`](../../doc/models/visibility-filter.md) | Query, Optional | Requests that all of the custom attributes be returned, or only those that are read-only or read-write. |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |

## Response Type

[`ListOrderCustomAttributeDefinitionsResponse`](../../doc/models/list-order-custom-attribute-definitions-response.md)

## Example Usage

```php
$apiResponse = $orderCustomAttributesApi->listOrderCustomAttributeDefinitions();

if ($apiResponse->isSuccess()) {
    $listOrderCustomAttributeDefinitionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Order Custom Attribute Definition

Creates an order-related custom attribute definition.  Use this endpoint to
define a custom attribute that can be associated with orders.

After creating a custom attribute definition, you can set the custom attribute for orders
in the Square seller account.

```php
function createOrderCustomAttributeDefinition(CreateOrderCustomAttributeDefinitionRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateOrderCustomAttributeDefinitionRequest`](../../doc/models/create-order-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateOrderCustomAttributeDefinitionResponse`](../../doc/models/create-order-custom-attribute-definition-response.md)

## Example Usage

```php
$body = CreateOrderCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()
        ->key('cover-count')
        ->name('Cover count')
        ->description('The number of people seated at a table')
        ->visibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_WRITE_VALUES)
        ->build()
)
    ->idempotencyKey('IDEMPOTENCY_KEY')
    ->build();

$apiResponse = $orderCustomAttributesApi->createOrderCustomAttributeDefinition($body);

if ($apiResponse->isSuccess()) {
    $createOrderCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Order Custom Attribute Definition

Deletes an order-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) from a Square seller account.

Only the definition owner can delete a custom attribute definition.

```php
function deleteOrderCustomAttributeDefinition(string $key): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to delete. |

## Response Type

[`DeleteOrderCustomAttributeDefinitionResponse`](../../doc/models/delete-order-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $orderCustomAttributesApi->deleteOrderCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $deleteOrderCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Order Custom Attribute Definition

Retrieves an order-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) from a Square seller account.

To retrieve a custom attribute definition created by another application, the `visibility`
setting must be `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function retrieveOrderCustomAttributeDefinition(string $key, ?int $version = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to retrieve. |
| `version` | `?int` | Query, Optional | To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency)<br>control, include this optional field and specify the current version of the custom attribute. |

## Response Type

[`RetrieveOrderCustomAttributeDefinitionResponse`](../../doc/models/retrieve-order-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $orderCustomAttributesApi->retrieveOrderCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $retrieveOrderCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Order Custom Attribute Definition

Updates an order-related custom attribute definition for a Square seller account.

Only the definition owner can update a custom attribute definition. Note that sellers can view all custom attributes in exported customer data, including those set to `VISIBILITY_HIDDEN`.

```php
function updateOrderCustomAttributeDefinition(
    string $key,
    UpdateOrderCustomAttributeDefinitionRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to update. |
| `body` | [`UpdateOrderCustomAttributeDefinitionRequest`](../../doc/models/update-order-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateOrderCustomAttributeDefinitionResponse`](../../doc/models/update-order-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$body = UpdateOrderCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()
        ->key('cover-count')
        ->visibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_ONLY)
        ->version(1)
        ->build()
)
    ->idempotencyKey('IDEMPOTENCY_KEY')
    ->build();

$apiResponse = $orderCustomAttributesApi->updateOrderCustomAttributeDefinition(
    $key,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateOrderCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Delete Order Custom Attributes

Deletes order [custom attributes](../../doc/models/custom-attribute.md) as a bulk operation.

Use this endpoint to delete one or more custom attributes from one or more orders.
A custom attribute is based on a custom attribute definition in a Square seller account.  (To create a
custom attribute definition, use the [CreateOrderCustomAttributeDefinition](../../doc/apis/order-custom-attributes.md#create-order-custom-attribute-definition) endpoint.)

This `BulkDeleteOrderCustomAttributes` endpoint accepts a map of 1 to 25 individual delete
requests and returns a map of individual delete responses. Each delete request has a unique ID
and provides an order ID and custom attribute. Each delete response is returned with the ID
of the corresponding request.

To delete a custom attribute owned by another application, the `visibility` setting
must be `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function bulkDeleteOrderCustomAttributes(BulkDeleteOrderCustomAttributesRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkDeleteOrderCustomAttributesRequest`](../../doc/models/bulk-delete-order-custom-attributes-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkDeleteOrderCustomAttributesResponse`](../../doc/models/bulk-delete-order-custom-attributes-response.md)

## Example Usage

```php
$body = BulkDeleteOrderCustomAttributesRequestBuilder::init(
    [
        'cover-count' => BulkDeleteOrderCustomAttributesRequestDeleteCustomAttributeBuilder::init(
            '7BbXGEIWNldxAzrtGf9GPVZTwZ4F'
        )
            ->key('cover-count')
            ->build(),
        'table-number' => BulkDeleteOrderCustomAttributesRequestDeleteCustomAttributeBuilder::init(
            '7BbXGEIWNldxAzrtGf9GPVZTwZ4F'
        )
            ->key('table-number')
            ->build()
    ]
)->build();

$apiResponse = $orderCustomAttributesApi->bulkDeleteOrderCustomAttributes($body);

if ($apiResponse->isSuccess()) {
    $bulkDeleteOrderCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Upsert Order Custom Attributes

Creates or updates order [custom attributes](../../doc/models/custom-attribute.md) as a bulk operation.

Use this endpoint to delete one or more custom attributes from one or more orders.
A custom attribute is based on a custom attribute definition in a Square seller account.  (To create a
custom attribute definition, use the [CreateOrderCustomAttributeDefinition](../../doc/apis/order-custom-attributes.md#create-order-custom-attribute-definition) endpoint.)

This `BulkUpsertOrderCustomAttributes` endpoint accepts a map of 1 to 25 individual upsert
requests and returns a map of individual upsert responses. Each upsert request has a unique ID
and provides an order ID and custom attribute. Each upsert response is returned with the ID
of the corresponding request.

To create or update a custom attribute owned by another application, the `visibility` setting
must be `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function bulkUpsertOrderCustomAttributes(BulkUpsertOrderCustomAttributesRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkUpsertOrderCustomAttributesRequest`](../../doc/models/bulk-upsert-order-custom-attributes-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkUpsertOrderCustomAttributesResponse`](../../doc/models/bulk-upsert-order-custom-attributes-response.md)

## Example Usage

```php
$body = BulkUpsertOrderCustomAttributesRequestBuilder::init(
    [
        'key0' => BulkUpsertOrderCustomAttributesRequestUpsertCustomAttributeBuilder::init(
            CustomAttributeBuilder::init()->build(),
            'order_id2'
        )->build(),
        'key1' => BulkUpsertOrderCustomAttributesRequestUpsertCustomAttributeBuilder::init(
            CustomAttributeBuilder::init()->build(),
            'order_id1'
        )->build()
    ]
)->build();

$apiResponse = $orderCustomAttributesApi->bulkUpsertOrderCustomAttributes($body);

if ($apiResponse->isSuccess()) {
    $bulkUpsertOrderCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Order Custom Attributes

Lists the [custom attributes](../../doc/models/custom-attribute.md) associated with an order.

You can use the `with_definitions` query parameter to also retrieve custom attribute definitions
in the same call.

When all response pages are retrieved, the results include all custom attributes that are
visible to the requesting application, including those that are owned by other applications
and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.

```php
function listOrderCustomAttributes(
    string $orderId,
    ?string $visibilityFilter = null,
    ?string $cursor = null,
    ?int $limit = null,
    ?bool $withDefinitions = false
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderId` | `string` | Template, Required | The ID of the target [order](entity:Order). |
| `visibilityFilter` | [`?string (VisibilityFilter)`](../../doc/models/visibility-filter.md) | Query, Optional | Requests that all of the custom attributes be returned, or only those that are read-only or read-write. |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `withDefinitions` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of each<br>custom attribute. Set this parameter to `true` to get the name and description of each custom attribute,<br>information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |

## Response Type

[`ListOrderCustomAttributesResponse`](../../doc/models/list-order-custom-attributes-response.md)

## Example Usage

```php
$orderId = 'order_id6';

$withDefinitions = false;

$apiResponse = $orderCustomAttributesApi->listOrderCustomAttributes(
    $orderId,
    $withDefinitions
);

if ($apiResponse->isSuccess()) {
    $listOrderCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Order Custom Attribute

Deletes a [custom attribute](../../doc/models/custom-attribute.md) associated with a customer profile.

To delete a custom attribute owned by another application, the `visibility` setting must be
`VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function deleteOrderCustomAttribute(string $orderId, string $customAttributeKey): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderId` | `string` | Template, Required | The ID of the target [order](entity:Order). |
| `customAttributeKey` | `string` | Template, Required | The key of the custom attribute to delete.  This key must match the key of an<br>existing custom attribute definition. |

## Response Type

[`DeleteOrderCustomAttributeResponse`](../../doc/models/delete-order-custom-attribute-response.md)

## Example Usage

```php
$orderId = 'order_id6';

$customAttributeKey = 'custom_attribute_key2';

$apiResponse = $orderCustomAttributesApi->deleteOrderCustomAttribute(
    $orderId,
    $customAttributeKey
);

if ($apiResponse->isSuccess()) {
    $deleteOrderCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Order Custom Attribute

Retrieves a [custom attribute](../../doc/models/custom-attribute.md) associated with an order.

You can use the `with_definition` query parameter to also retrieve the custom attribute definition
in the same call.

To retrieve a custom attribute owned by another application, the `visibility` setting must be
`VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function retrieveOrderCustomAttribute(
    string $orderId,
    string $customAttributeKey,
    ?int $version = null,
    ?bool $withDefinition = false
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderId` | `string` | Template, Required | The ID of the target [order](entity:Order). |
| `customAttributeKey` | `string` | Template, Required | The key of the custom attribute to retrieve.  This key must match the key of an<br>existing custom attribute definition. |
| `version` | `?int` | Query, Optional | To enable [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency)<br>control, include this optional field and specify the current version of the custom attribute. |
| `withDefinition` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of each<br>custom attribute. Set this parameter to `true` to get the name and description of each custom attribute,<br>information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |

## Response Type

[`RetrieveOrderCustomAttributeResponse`](../../doc/models/retrieve-order-custom-attribute-response.md)

## Example Usage

```php
$orderId = 'order_id6';

$customAttributeKey = 'custom_attribute_key2';

$withDefinition = false;

$apiResponse = $orderCustomAttributesApi->retrieveOrderCustomAttribute(
    $orderId,
    $customAttributeKey,
    $withDefinition
);

if ($apiResponse->isSuccess()) {
    $retrieveOrderCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Upsert Order Custom Attribute

Creates or updates a [custom attribute](../../doc/models/custom-attribute.md) for an order.

Use this endpoint to set the value of a custom attribute for a specific order.
A custom attribute is based on a custom attribute definition in a Square seller account. (To create a
custom attribute definition, use the [CreateOrderCustomAttributeDefinition](../../doc/apis/order-custom-attributes.md#create-order-custom-attribute-definition) endpoint.)

To create or update a custom attribute owned by another application, the `visibility` setting
must be `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function upsertOrderCustomAttribute(
    string $orderId,
    string $customAttributeKey,
    UpsertOrderCustomAttributeRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `orderId` | `string` | Template, Required | The ID of the target [order](entity:Order). |
| `customAttributeKey` | `string` | Template, Required | The key of the custom attribute to create or update.  This key must match the key<br>of an existing custom attribute definition. |
| `body` | [`UpsertOrderCustomAttributeRequest`](../../doc/models/upsert-order-custom-attribute-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpsertOrderCustomAttributeResponse`](../../doc/models/upsert-order-custom-attribute-response.md)

## Example Usage

```php
$orderId = 'order_id6';

$customAttributeKey = 'custom_attribute_key2';

$body = UpsertOrderCustomAttributeRequestBuilder::init(
    CustomAttributeBuilder::init()->build()
)->build();

$apiResponse = $orderCustomAttributesApi->upsertOrderCustomAttribute(
    $orderId,
    $customAttributeKey,
    $body
);

if ($apiResponse->isSuccess()) {
    $upsertOrderCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

