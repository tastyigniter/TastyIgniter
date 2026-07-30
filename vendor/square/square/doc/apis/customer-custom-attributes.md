# Customer Custom Attributes

```php
$customerCustomAttributesApi = $client->getCustomerCustomAttributesApi();
```

## Class Name

`CustomerCustomAttributesApi`

## Methods

* [List Customer Custom Attribute Definitions](../../doc/apis/customer-custom-attributes.md#list-customer-custom-attribute-definitions)
* [Create Customer Custom Attribute Definition](../../doc/apis/customer-custom-attributes.md#create-customer-custom-attribute-definition)
* [Delete Customer Custom Attribute Definition](../../doc/apis/customer-custom-attributes.md#delete-customer-custom-attribute-definition)
* [Retrieve Customer Custom Attribute Definition](../../doc/apis/customer-custom-attributes.md#retrieve-customer-custom-attribute-definition)
* [Update Customer Custom Attribute Definition](../../doc/apis/customer-custom-attributes.md#update-customer-custom-attribute-definition)
* [Bulk Upsert Customer Custom Attributes](../../doc/apis/customer-custom-attributes.md#bulk-upsert-customer-custom-attributes)
* [List Customer Custom Attributes](../../doc/apis/customer-custom-attributes.md#list-customer-custom-attributes)
* [Delete Customer Custom Attribute](../../doc/apis/customer-custom-attributes.md#delete-customer-custom-attribute)
* [Retrieve Customer Custom Attribute](../../doc/apis/customer-custom-attributes.md#retrieve-customer-custom-attribute)
* [Upsert Customer Custom Attribute](../../doc/apis/customer-custom-attributes.md#upsert-customer-custom-attribute)


# List Customer Custom Attribute Definitions

Lists the customer-related [custom attribute definitions](../../doc/models/custom-attribute-definition.md) that belong to a Square seller account.

When all response pages are retrieved, the results include all custom attribute definitions
that are visible to the requesting application, including those that are created by other
applications and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that
seller-defined custom attributes (also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function listCustomerCustomAttributeDefinitions(?int $limit = null, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListCustomerCustomAttributeDefinitionsResponse`](../../doc/models/list-customer-custom-attribute-definitions-response.md)

## Example Usage

```php
$apiResponse = $customerCustomAttributesApi->listCustomerCustomAttributeDefinitions();

if ($apiResponse->isSuccess()) {
    $listCustomerCustomAttributeDefinitionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Customer Custom Attribute Definition

Creates a customer-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) for a Square seller account.
Use this endpoint to define a custom attribute that can be associated with customer profiles.

A custom attribute definition specifies the `key`, `visibility`, `schema`, and other properties
for a custom attribute. After the definition is created, you can call
[UpsertCustomerCustomAttribute](../../doc/apis/customer-custom-attributes.md#upsert-customer-custom-attribute) or
[BulkUpsertCustomerCustomAttributes](../../doc/apis/customer-custom-attributes.md#bulk-upsert-customer-custom-attributes)
to set the custom attribute for customer profiles in the seller's Customer Directory.

Sellers can view all custom attributes in exported customer data, including those set to
`VISIBILITY_HIDDEN`.

```php
function createCustomerCustomAttributeDefinition(
    CreateCustomerCustomAttributeDefinitionRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateCustomerCustomAttributeDefinitionRequest`](../../doc/models/create-customer-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateCustomerCustomAttributeDefinitionResponse`](../../doc/models/create-customer-custom-attribute-definition-response.md)

## Example Usage

```php
$body = CreateCustomerCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()
        ->key('favoritemovie')
        ->name('Favorite Movie')
        ->description('The favorite movie of the customer.')
        ->visibility(CustomAttributeDefinitionVisibility::VISIBILITY_HIDDEN)
        ->build()
)->build();

$apiResponse = $customerCustomAttributesApi->createCustomerCustomAttributeDefinition($body);

if ($apiResponse->isSuccess()) {
    $createCustomerCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Customer Custom Attribute Definition

Deletes a customer-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) from a Square seller account.

Deleting a custom attribute definition also deletes the corresponding custom attribute from
all customer profiles in the seller's Customer Directory.

Only the definition owner can delete a custom attribute definition.

```php
function deleteCustomerCustomAttributeDefinition(string $key): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to delete. |

## Response Type

[`DeleteCustomerCustomAttributeDefinitionResponse`](../../doc/models/delete-customer-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $customerCustomAttributesApi->deleteCustomerCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $deleteCustomerCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Customer Custom Attribute Definition

Retrieves a customer-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) from a Square seller account.

To retrieve a custom attribute definition created by another application, the `visibility`
setting must be `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function retrieveCustomerCustomAttributeDefinition(string $key, ?int $version = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to retrieve. If the requesting application<br>is not the definition owner, you must use the qualified key. |
| `version` | `?int` | Query, Optional | The current version of the custom attribute definition, which is used for strongly consistent<br>reads to guarantee that you receive the most up-to-date data. When included in the request,<br>Square returns the specified version or a higher version if one exists. If the specified version<br>is higher than the current version, Square returns a `BAD_REQUEST` error. |

## Response Type

[`RetrieveCustomerCustomAttributeDefinitionResponse`](../../doc/models/retrieve-customer-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$apiResponse = $customerCustomAttributesApi->retrieveCustomerCustomAttributeDefinition($key);

if ($apiResponse->isSuccess()) {
    $retrieveCustomerCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Customer Custom Attribute Definition

Updates a customer-related [custom attribute definition](../../doc/models/custom-attribute-definition.md) for a Square seller account.

Use this endpoint to update the following fields: `name`, `description`, `visibility`, or the
`schema` for a `Selection` data type.

Only the definition owner can update a custom attribute definition. Note that sellers can view
all custom attributes in exported customer data, including those set to `VISIBILITY_HIDDEN`.

```php
function updateCustomerCustomAttributeDefinition(
    string $key,
    UpdateCustomerCustomAttributeDefinitionRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `key` | `string` | Template, Required | The key of the custom attribute definition to update. |
| `body` | [`UpdateCustomerCustomAttributeDefinitionRequest`](../../doc/models/update-customer-custom-attribute-definition-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateCustomerCustomAttributeDefinitionResponse`](../../doc/models/update-customer-custom-attribute-definition-response.md)

## Example Usage

```php
$key = 'key0';

$body = UpdateCustomerCustomAttributeDefinitionRequestBuilder::init(
    CustomAttributeDefinitionBuilder::init()
        ->description('Update the description as desired.')
        ->visibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_ONLY)
        ->build()
)->build();

$apiResponse = $customerCustomAttributesApi->updateCustomerCustomAttributeDefinition(
    $key,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateCustomerCustomAttributeDefinitionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Bulk Upsert Customer Custom Attributes

Creates or updates [custom attributes](../../doc/models/custom-attribute.md) for customer profiles as a bulk operation.

Use this endpoint to set the value of one or more custom attributes for one or more customer profiles.
A custom attribute is based on a custom attribute definition in a Square seller account, which is
created using the [CreateCustomerCustomAttributeDefinition](../../doc/apis/customer-custom-attributes.md#create-customer-custom-attribute-definition) endpoint.

This `BulkUpsertCustomerCustomAttributes` endpoint accepts a map of 1 to 25 individual upsert
requests and returns a map of individual upsert responses. Each upsert request has a unique ID
and provides a customer ID and custom attribute. Each upsert response is returned with the ID
of the corresponding request.

To create or update a custom attribute owned by another application, the `visibility` setting
must be `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function bulkUpsertCustomerCustomAttributes(BulkUpsertCustomerCustomAttributesRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`BulkUpsertCustomerCustomAttributesRequest`](../../doc/models/bulk-upsert-customer-custom-attributes-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`BulkUpsertCustomerCustomAttributesResponse`](../../doc/models/bulk-upsert-customer-custom-attributes-response.md)

## Example Usage

```php
$body = BulkUpsertCustomerCustomAttributesRequestBuilder::init(
    [
        'key0' => BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequestBuilder::init(
            'customer_id2',
            CustomAttributeBuilder::init()->build()
        )->build(),
        'key1' => BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequestBuilder::init(
            'customer_id3',
            CustomAttributeBuilder::init()->build()
        )->build()
    ]
)->build();

$apiResponse = $customerCustomAttributesApi->bulkUpsertCustomerCustomAttributes($body);

if ($apiResponse->isSuccess()) {
    $bulkUpsertCustomerCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Customer Custom Attributes

Lists the [custom attributes](../../doc/models/custom-attribute.md) associated with a customer profile.

You can use the `with_definitions` query parameter to also retrieve custom attribute definitions
in the same call.

When all response pages are retrieved, the results include all custom attributes that are
visible to the requesting application, including those that are owned by other applications
and set to `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.

```php
function listCustomerCustomAttributes(
    string $customerId,
    ?int $limit = null,
    ?string $cursor = null,
    ?bool $withDefinitions = false
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `customerId` | `string` | Template, Required | The ID of the target [customer profile](entity:Customer). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request. For more<br>information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `withDefinitions` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of each<br>custom attribute. Set this parameter to `true` to get the name and description of each custom<br>attribute, information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |

## Response Type

[`ListCustomerCustomAttributesResponse`](../../doc/models/list-customer-custom-attributes-response.md)

## Example Usage

```php
$customerId = 'customer_id8';

$withDefinitions = false;

$apiResponse = $customerCustomAttributesApi->listCustomerCustomAttributes(
    $customerId,
    $withDefinitions
);

if ($apiResponse->isSuccess()) {
    $listCustomerCustomAttributesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Customer Custom Attribute

Deletes a [custom attribute](../../doc/models/custom-attribute.md) associated with a customer profile.

To delete a custom attribute owned by another application, the `visibility` setting must be
`VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function deleteCustomerCustomAttribute(string $customerId, string $key): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `customerId` | `string` | Template, Required | The ID of the target [customer profile](entity:Customer). |
| `key` | `string` | Template, Required | The key of the custom attribute to delete. This key must match the `key` of a custom<br>attribute definition in the Square seller account. If the requesting application is not the<br>definition owner, you must use the qualified key. |

## Response Type

[`DeleteCustomerCustomAttributeResponse`](../../doc/models/delete-customer-custom-attribute-response.md)

## Example Usage

```php
$customerId = 'customer_id8';

$key = 'key0';

$apiResponse = $customerCustomAttributesApi->deleteCustomerCustomAttribute(
    $customerId,
    $key
);

if ($apiResponse->isSuccess()) {
    $deleteCustomerCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Customer Custom Attribute

Retrieves a [custom attribute](../../doc/models/custom-attribute.md) associated with a customer profile.

You can use the `with_definition` query parameter to also retrieve the custom attribute definition
in the same call.

To retrieve a custom attribute owned by another application, the `visibility` setting must be
`VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function retrieveCustomerCustomAttribute(
    string $customerId,
    string $key,
    ?bool $withDefinition = false,
    ?int $version = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `customerId` | `string` | Template, Required | The ID of the target [customer profile](entity:Customer). |
| `key` | `string` | Template, Required | The key of the custom attribute to retrieve. This key must match the `key` of a custom<br>attribute definition in the Square seller account. If the requesting application is not the<br>definition owner, you must use the qualified key. |
| `withDefinition` | `?bool` | Query, Optional | Indicates whether to return the [custom attribute definition](entity:CustomAttributeDefinition) in the `definition` field of<br>the custom attribute. Set this parameter to `true` to get the name and description of the custom<br>attribute, information about the data type, or other definition details. The default value is `false`.<br>**Default**: `false` |
| `version` | `?int` | Query, Optional | The current version of the custom attribute, which is used for strongly consistent reads to<br>guarantee that you receive the most up-to-date data. When included in the request, Square<br>returns the specified version or a higher version if one exists. If the specified version is<br>higher than the current version, Square returns a `BAD_REQUEST` error. |

## Response Type

[`RetrieveCustomerCustomAttributeResponse`](../../doc/models/retrieve-customer-custom-attribute-response.md)

## Example Usage

```php
$customerId = 'customer_id8';

$key = 'key0';

$withDefinition = false;

$apiResponse = $customerCustomAttributesApi->retrieveCustomerCustomAttribute(
    $customerId,
    $key,
    $withDefinition
);

if ($apiResponse->isSuccess()) {
    $retrieveCustomerCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Upsert Customer Custom Attribute

Creates or updates a [custom attribute](../../doc/models/custom-attribute.md) for a customer profile.

Use this endpoint to set the value of a custom attribute for a specified customer profile.
A custom attribute is based on a custom attribute definition in a Square seller account, which
is created using the [CreateCustomerCustomAttributeDefinition](../../doc/apis/customer-custom-attributes.md#create-customer-custom-attribute-definition) endpoint.

To create or update a custom attribute owned by another application, the `visibility` setting
must be `VISIBILITY_READ_WRITE_VALUES`. Note that seller-defined custom attributes
(also known as custom fields) are always set to `VISIBILITY_READ_WRITE_VALUES`.

```php
function upsertCustomerCustomAttribute(
    string $customerId,
    string $key,
    UpsertCustomerCustomAttributeRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `customerId` | `string` | Template, Required | The ID of the target [customer profile](entity:Customer). |
| `key` | `string` | Template, Required | The key of the custom attribute to create or update. This key must match the `key` of a<br>custom attribute definition in the Square seller account. If the requesting application is not<br>the definition owner, you must use the qualified key. |
| `body` | [`UpsertCustomerCustomAttributeRequest`](../../doc/models/upsert-customer-custom-attribute-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpsertCustomerCustomAttributeResponse`](../../doc/models/upsert-customer-custom-attribute-response.md)

## Example Usage

```php
$customerId = 'customer_id8';

$key = 'key0';

$body = UpsertCustomerCustomAttributeRequestBuilder::init(
    CustomAttributeBuilder::init()->build()
)->build();

$apiResponse = $customerCustomAttributesApi->upsertCustomerCustomAttribute(
    $customerId,
    $key,
    $body
);

if ($apiResponse->isSuccess()) {
    $upsertCustomerCustomAttributeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

