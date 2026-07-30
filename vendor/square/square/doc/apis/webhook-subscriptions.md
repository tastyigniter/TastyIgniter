# Webhook Subscriptions

```php
$webhookSubscriptionsApi = $client->getWebhookSubscriptionsApi();
```

## Class Name

`WebhookSubscriptionsApi`

## Methods

* [List Webhook Event Types](../../doc/apis/webhook-subscriptions.md#list-webhook-event-types)
* [List Webhook Subscriptions](../../doc/apis/webhook-subscriptions.md#list-webhook-subscriptions)
* [Create Webhook Subscription](../../doc/apis/webhook-subscriptions.md#create-webhook-subscription)
* [Delete Webhook Subscription](../../doc/apis/webhook-subscriptions.md#delete-webhook-subscription)
* [Retrieve Webhook Subscription](../../doc/apis/webhook-subscriptions.md#retrieve-webhook-subscription)
* [Update Webhook Subscription](../../doc/apis/webhook-subscriptions.md#update-webhook-subscription)
* [Update Webhook Subscription Signature Key](../../doc/apis/webhook-subscriptions.md#update-webhook-subscription-signature-key)
* [Test Webhook Subscription](../../doc/apis/webhook-subscriptions.md#test-webhook-subscription)


# List Webhook Event Types

Lists all webhook event types that can be subscribed to.

```php
function listWebhookEventTypes(?string $apiVersion = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `apiVersion` | `?string` | Query, Optional | The API version for which to list event types. Setting this field overrides the default version used by the application. |

## Response Type

[`ListWebhookEventTypesResponse`](../../doc/models/list-webhook-event-types-response.md)

## Example Usage

```php
$apiResponse = $webhookSubscriptionsApi->listWebhookEventTypes();

if ($apiResponse->isSuccess()) {
    $listWebhookEventTypesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Webhook Subscriptions

Lists all webhook subscriptions owned by your application.

```php
function listWebhookSubscriptions(
    ?string $cursor = null,
    ?bool $includeDisabled = false,
    ?string $sortOrder = null,
    ?int $limit = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for your original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination). |
| `includeDisabled` | `?bool` | Query, Optional | Includes disabled [Subscription](entity:WebhookSubscription)s.<br>By default, all enabled [Subscription](entity:WebhookSubscription)s are returned.<br>**Default**: `false` |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | Sorts the returned list by when the [Subscription](entity:WebhookSubscription) was created with the specified order.<br>This field defaults to ASC. |
| `limit` | `?int` | Query, Optional | The maximum number of results to be returned in a single page.<br>It is possible to receive fewer results than the specified limit on a given page.<br>The default value of 100 is also the maximum allowed value.<br><br>Default: 100 |

## Response Type

[`ListWebhookSubscriptionsResponse`](../../doc/models/list-webhook-subscriptions-response.md)

## Example Usage

```php
$includeDisabled = false;

$apiResponse = $webhookSubscriptionsApi->listWebhookSubscriptions($includeDisabled);

if ($apiResponse->isSuccess()) {
    $listWebhookSubscriptionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Webhook Subscription

Creates a webhook subscription.

```php
function createWebhookSubscription(CreateWebhookSubscriptionRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateWebhookSubscriptionRequest`](../../doc/models/create-webhook-subscription-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateWebhookSubscriptionResponse`](../../doc/models/create-webhook-subscription-response.md)

## Example Usage

```php
$body = CreateWebhookSubscriptionRequestBuilder::init(
    WebhookSubscriptionBuilder::init()
        ->name('Example Webhook Subscription')
        ->eventTypes(
            [
                'payment.created',
                'payment.updated'
            ]
        )
        ->notificationUrl('https://example-webhook-url.com')
        ->apiVersion('2021-12-15')
        ->build()
)
    ->idempotencyKey('63f84c6c-2200-4c99-846c-2670a1311fbf')
    ->build();

$apiResponse = $webhookSubscriptionsApi->createWebhookSubscription($body);

if ($apiResponse->isSuccess()) {
    $createWebhookSubscriptionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Webhook Subscription

Deletes a webhook subscription.

```php
function deleteWebhookSubscription(string $subscriptionId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `subscriptionId` | `string` | Template, Required | [REQUIRED] The ID of the [Subscription](entity:WebhookSubscription) to delete. |

## Response Type

[`DeleteWebhookSubscriptionResponse`](../../doc/models/delete-webhook-subscription-response.md)

## Example Usage

```php
$subscriptionId = 'subscription_id0';

$apiResponse = $webhookSubscriptionsApi->deleteWebhookSubscription($subscriptionId);

if ($apiResponse->isSuccess()) {
    $deleteWebhookSubscriptionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Webhook Subscription

Retrieves a webhook subscription identified by its ID.

```php
function retrieveWebhookSubscription(string $subscriptionId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `subscriptionId` | `string` | Template, Required | [REQUIRED] The ID of the [Subscription](entity:WebhookSubscription) to retrieve. |

## Response Type

[`RetrieveWebhookSubscriptionResponse`](../../doc/models/retrieve-webhook-subscription-response.md)

## Example Usage

```php
$subscriptionId = 'subscription_id0';

$apiResponse = $webhookSubscriptionsApi->retrieveWebhookSubscription($subscriptionId);

if ($apiResponse->isSuccess()) {
    $retrieveWebhookSubscriptionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Webhook Subscription

Updates a webhook subscription.

```php
function updateWebhookSubscription(string $subscriptionId, UpdateWebhookSubscriptionRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `subscriptionId` | `string` | Template, Required | [REQUIRED] The ID of the [Subscription](entity:WebhookSubscription) to update. |
| `body` | [`UpdateWebhookSubscriptionRequest`](../../doc/models/update-webhook-subscription-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateWebhookSubscriptionResponse`](../../doc/models/update-webhook-subscription-response.md)

## Example Usage

```php
$subscriptionId = 'subscription_id0';

$body = UpdateWebhookSubscriptionRequestBuilder::init()
    ->subscription(
        WebhookSubscriptionBuilder::init()
            ->name('Updated Example Webhook Subscription')
            ->enabled(false)
            ->build()
    )
    ->build();

$apiResponse = $webhookSubscriptionsApi->updateWebhookSubscription(
    $subscriptionId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateWebhookSubscriptionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Update Webhook Subscription Signature Key

Updates a webhook subscription by replacing the existing signature key with a new one.

```php
function updateWebhookSubscriptionSignatureKey(
    string $subscriptionId,
    UpdateWebhookSubscriptionSignatureKeyRequest $body
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `subscriptionId` | `string` | Template, Required | [REQUIRED] The ID of the [Subscription](entity:WebhookSubscription) to update. |
| `body` | [`UpdateWebhookSubscriptionSignatureKeyRequest`](../../doc/models/update-webhook-subscription-signature-key-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpdateWebhookSubscriptionSignatureKeyResponse`](../../doc/models/update-webhook-subscription-signature-key-response.md)

## Example Usage

```php
$subscriptionId = 'subscription_id0';

$body = UpdateWebhookSubscriptionSignatureKeyRequestBuilder::init()
    ->idempotencyKey('ed80ae6b-0654-473b-bbab-a39aee89a60d')
    ->build();

$apiResponse = $webhookSubscriptionsApi->updateWebhookSubscriptionSignatureKey(
    $subscriptionId,
    $body
);

if ($apiResponse->isSuccess()) {
    $updateWebhookSubscriptionSignatureKeyResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Test Webhook Subscription

Tests a webhook subscription by sending a test event to the notification URL.

```php
function testWebhookSubscription(string $subscriptionId, TestWebhookSubscriptionRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `subscriptionId` | `string` | Template, Required | [REQUIRED] The ID of the [Subscription](entity:WebhookSubscription) to test. |
| `body` | [`TestWebhookSubscriptionRequest`](../../doc/models/test-webhook-subscription-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`TestWebhookSubscriptionResponse`](../../doc/models/test-webhook-subscription-response.md)

## Example Usage

```php
$subscriptionId = 'subscription_id0';

$body = TestWebhookSubscriptionRequestBuilder::init()
    ->eventType('payment.created')
    ->build();

$apiResponse = $webhookSubscriptionsApi->testWebhookSubscription(
    $subscriptionId,
    $body
);

if ($apiResponse->isSuccess()) {
    $testWebhookSubscriptionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

