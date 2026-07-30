# Transactions

```php
$transactionsApi = $client->getTransactionsApi();
```

## Class Name

`TransactionsApi`

## Methods

* [List Transactions](../../doc/apis/transactions.md#list-transactions)
* [Retrieve Transaction](../../doc/apis/transactions.md#retrieve-transaction)
* [Capture Transaction](../../doc/apis/transactions.md#capture-transaction)
* [Void Transaction](../../doc/apis/transactions.md#void-transaction)


# List Transactions

**This endpoint is deprecated.**

Lists transactions for a particular location.

Transactions include payment information from sales and exchanges and refund
information from returns and exchanges.

Max results per [page](https://developer.squareup.com/docs/working-with-apis/pagination): 50

```php
function listTransactions(
    string $locationId,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?string $sortOrder = null,
    ?string $cursor = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to list transactions for. |
| `beginTime` | `?string` | Query, Optional | The beginning of the requested reporting period, in RFC 3339 format.<br><br>See [Date ranges](https://developer.squareup.com/docs/build-basics/working-with-dates) for details on date inclusivity/exclusivity.<br><br>Default value: The current time minus one year. |
| `endTime` | `?string` | Query, Optional | The end of the requested reporting period, in RFC 3339 format.<br><br>See [Date ranges](https://developer.squareup.com/docs/build-basics/working-with-dates) for details on date inclusivity/exclusivity.<br><br>Default value: The current time. |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which results are listed in the response (`ASC` for<br>oldest first, `DESC` for newest first).<br><br>Default value: `DESC` |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for your original query.<br><br>See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more information. |

## Response Type

[`ListTransactionsResponse`](../../doc/models/list-transactions-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $transactionsApi->listTransactions($locationId);

if ($apiResponse->isSuccess()) {
    $listTransactionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Transaction

**This endpoint is deprecated.**

Retrieves details for a single transaction.

```php
function retrieveTransaction(string $locationId, string $transactionId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the transaction's associated location. |
| `transactionId` | `string` | Template, Required | The ID of the transaction to retrieve. |

## Response Type

[`RetrieveTransactionResponse`](../../doc/models/retrieve-transaction-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$transactionId = 'transaction_id8';

$apiResponse = $transactionsApi->retrieveTransaction(
    $locationId,
    $transactionId
);

if ($apiResponse->isSuccess()) {
    $retrieveTransactionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Capture Transaction

**This endpoint is deprecated.**

Captures a transaction that was created with the [Charge](api-endpoint:Transactions-Charge)
endpoint with a `delay_capture` value of `true`.

See [Delayed capture transactions](https://developer.squareup.com/docs/payments/transactions/overview#delayed-capture)
for more information.

```php
function captureTransaction(string $locationId, string $transactionId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | - |
| `transactionId` | `string` | Template, Required | - |

## Response Type

[`CaptureTransactionResponse`](../../doc/models/capture-transaction-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$transactionId = 'transaction_id8';

$apiResponse = $transactionsApi->captureTransaction(
    $locationId,
    $transactionId
);

if ($apiResponse->isSuccess()) {
    $captureTransactionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Void Transaction

**This endpoint is deprecated.**

Cancels a transaction that was created with the [Charge](api-endpoint:Transactions-Charge)
endpoint with a `delay_capture` value of `true`.

See [Delayed capture transactions](https://developer.squareup.com/docs/payments/transactions/overview#delayed-capture)
for more information.

```php
function voidTransaction(string $locationId, string $transactionId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | - |
| `transactionId` | `string` | Template, Required | - |

## Response Type

[`VoidTransactionResponse`](../../doc/models/void-transaction-response.md)

## Example Usage

```php
$locationId = 'location_id4';

$transactionId = 'transaction_id8';

$apiResponse = $transactionsApi->voidTransaction(
    $locationId,
    $transactionId
);

if ($apiResponse->isSuccess()) {
    $voidTransactionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

