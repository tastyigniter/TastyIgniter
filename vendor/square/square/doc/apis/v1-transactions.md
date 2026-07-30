# V1 Transactions

```php
$v1TransactionsApi = $client->getV1TransactionsApi();
```

## Class Name

`V1TransactionsApi`

## Methods

* [V1 List Orders](../../doc/apis/v1-transactions.md#v1-list-orders)
* [V1 Retrieve Order](../../doc/apis/v1-transactions.md#v1-retrieve-order)
* [V1 Update Order](../../doc/apis/v1-transactions.md#v1-update-order)
* [V1 List Payments](../../doc/apis/v1-transactions.md#v1-list-payments)
* [V1 Retrieve Payment](../../doc/apis/v1-transactions.md#v1-retrieve-payment)
* [V1 List Refunds](../../doc/apis/v1-transactions.md#v1-list-refunds)
* [V1 Create Refund](../../doc/apis/v1-transactions.md#v1-create-refund)
* [V1 List Settlements](../../doc/apis/v1-transactions.md#v1-list-settlements)
* [V1 Retrieve Settlement](../../doc/apis/v1-transactions.md#v1-retrieve-settlement)


# V1 List Orders

**This endpoint is deprecated.**

Provides summary information for a merchant's online store orders.

```php
function v1ListOrders(
    string $locationId,
    ?string $order = null,
    ?int $limit = null,
    ?string $batchToken = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to list online store orders for. |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which payments are listed in the response. |
| `limit` | `?int` | Query, Optional | The maximum number of payments to return in a single response. This value cannot exceed 200. |
| `batchToken` | `?string` | Query, Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. |

## Response Type

[`V1Order[]`](../../doc/models/v1-order.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $v1TransactionsApi->v1ListOrders($locationId);

if ($apiResponse->isSuccess()) {
    $v1Order = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 Retrieve Order

**This endpoint is deprecated.**

Provides comprehensive information for a single online store order, including the order's history.

```php
function v1RetrieveOrder(string $locationId, string $orderId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the order's associated location. |
| `orderId` | `string` | Template, Required | The order's Square-issued ID. You obtain this value from Order objects returned by the List Orders endpoint |

## Response Type

[`V1Order`](../../doc/models/v1-order.md)

## Example Usage

```php
$locationId = 'location_id4';

$orderId = 'order_id6';

$apiResponse = $v1TransactionsApi->v1RetrieveOrder(
    $locationId,
    $orderId
);

if ($apiResponse->isSuccess()) {
    $v1Order = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 Update Order

**This endpoint is deprecated.**

Updates the details of an online store order. Every update you perform on an order corresponds to one of three actions:

```php
function v1UpdateOrder(string $locationId, string $orderId, V1UpdateOrderRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the order's associated location. |
| `orderId` | `string` | Template, Required | The order's Square-issued ID. You obtain this value from Order objects returned by the List Orders endpoint |
| `body` | [`V1UpdateOrderRequest`](../../doc/models/v1-update-order-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`V1Order`](../../doc/models/v1-order.md)

## Example Usage

```php
$locationId = 'location_id4';

$orderId = 'order_id6';

$body = V1UpdateOrderRequestBuilder::init(
    V1UpdateOrderRequestAction::REFUND
)->build();

$apiResponse = $v1TransactionsApi->v1UpdateOrder(
    $locationId,
    $orderId,
    $body
);

if ($apiResponse->isSuccess()) {
    $v1Order = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 List Payments

**This endpoint is deprecated.**

Provides summary information for all payments taken for a given
Square account during a date range. Date ranges cannot exceed 1 year in
length. See Date ranges for details of inclusive and exclusive dates.

*Note**: Details for payments processed with Square Point of Sale while
in offline mode may not be transmitted to Square for up to 72 hours.
Offline payments have a `created_at` value that reflects the time the
payment was originally processed, not the time it was subsequently
transmitted to Square. Consequently, the ListPayments endpoint might
list an offline payment chronologically between online payments that
were seen in a previous request.

```php
function v1ListPayments(
    string $locationId,
    ?string $order = null,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?int $limit = null,
    ?string $batchToken = null,
    ?bool $includePartial = false
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to list payments for. If you specify me, this endpoint returns payments aggregated from all of the business's locations. |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which payments are listed in the response. |
| `beginTime` | `?string` | Query, Optional | The beginning of the requested reporting period, in ISO 8601 format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time minus one year. |
| `endTime` | `?string` | Query, Optional | The end of the requested reporting period, in ISO 8601 format. If this value is more than one year greater than begin_time, this endpoint returns an error. Default value: The current time. |
| `limit` | `?int` | Query, Optional | The maximum number of payments to return in a single response. This value cannot exceed 200. |
| `batchToken` | `?string` | Query, Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. |
| `includePartial` | `?bool` | Query, Optional | Indicates whether or not to include partial payments in the response. Partial payments will have the tenders collected so far, but the itemizations will be empty until the payment is completed.<br>**Default**: `false` |

## Response Type

[`V1Payment[]`](../../doc/models/v1-payment.md)

## Example Usage

```php
$locationId = 'location_id4';

$includePartial = false;

$apiResponse = $v1TransactionsApi->v1ListPayments(
    $locationId,
    $includePartial
);

if ($apiResponse->isSuccess()) {
    $v1Payment = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 Retrieve Payment

**This endpoint is deprecated.**

Provides comprehensive information for a single payment.

```php
function v1RetrievePayment(string $locationId, string $paymentId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the payment's associated location. |
| `paymentId` | `string` | Template, Required | The Square-issued payment ID. payment_id comes from Payment objects returned by the List Payments endpoint, Settlement objects returned by the List Settlements endpoint, or Refund objects returned by the List Refunds endpoint. |

## Response Type

[`V1Payment`](../../doc/models/v1-payment.md)

## Example Usage

```php
$locationId = 'location_id4';

$paymentId = 'payment_id0';

$apiResponse = $v1TransactionsApi->v1RetrievePayment(
    $locationId,
    $paymentId
);

if ($apiResponse->isSuccess()) {
    $v1Payment = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 List Refunds

**This endpoint is deprecated.**

Provides the details for all refunds initiated by a merchant or any of the merchant's mobile staff during a date range. Date ranges cannot exceed one year in length.

```php
function v1ListRefunds(
    string $locationId,
    ?string $order = null,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?int $limit = null,
    ?string $batchToken = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to list refunds for. |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which payments are listed in the response. |
| `beginTime` | `?string` | Query, Optional | The beginning of the requested reporting period, in ISO 8601 format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time minus one year. |
| `endTime` | `?string` | Query, Optional | The end of the requested reporting period, in ISO 8601 format. If this value is more than one year greater than begin_time, this endpoint returns an error. Default value: The current time. |
| `limit` | `?int` | Query, Optional | The approximate number of refunds to return in a single response. Default: 100. Max: 200. Response may contain more results than the prescribed limit when refunds are made simultaneously to multiple tenders in a payment or when refunds are generated in an exchange to account for the value of returned goods. |
| `batchToken` | `?string` | Query, Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. |

## Response Type

[`V1Refund[]`](../../doc/models/v1-refund.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $v1TransactionsApi->v1ListRefunds($locationId);

if ($apiResponse->isSuccess()) {
    $v1Refund = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 Create Refund

**This endpoint is deprecated.**

Issues a refund for a previously processed payment. You must issue
a refund within 60 days of the associated payment.

You cannot issue a partial refund for a split tender payment. You must
instead issue a full or partial refund for a particular tender, by
providing the applicable tender id to the V1CreateRefund endpoint.
Issuing a full refund for a split tender payment refunds all tenders
associated with the payment.

Issuing a refund for a card payment is not reversible. For development
purposes, you can create fake cash payments in Square Point of Sale and
refund them.

```php
function v1CreateRefund(string $locationId, V1CreateRefundRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the original payment's associated location. |
| `body` | [`V1CreateRefundRequest`](../../doc/models/v1-create-refund-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`V1Refund`](../../doc/models/v1-refund.md)

## Example Usage

```php
$locationId = 'location_id4';

$body = V1CreateRefundRequestBuilder::init(
    'payment_id6',
    V1CreateRefundRequestType::FULL,
    'reason8'
)->build();

$apiResponse = $v1TransactionsApi->v1CreateRefund(
    $locationId,
    $body
);

if ($apiResponse->isSuccess()) {
    $v1Refund = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 List Settlements

**This endpoint is deprecated.**

Provides summary information for all deposits and withdrawals
initiated by Square to a linked bank account during a date range. Date
ranges cannot exceed one year in length.

*Note**: the ListSettlements endpoint does not provide entry
information.

```php
function v1ListSettlements(
    string $locationId,
    ?string $order = null,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?int $limit = null,
    ?string $status = null,
    ?string $batchToken = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the location to list settlements for. If you specify me, this endpoint returns settlements aggregated from all of the business's locations. |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | The order in which settlements are listed in the response. |
| `beginTime` | `?string` | Query, Optional | The beginning of the requested reporting period, in ISO 8601 format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time minus one year. |
| `endTime` | `?string` | Query, Optional | The end of the requested reporting period, in ISO 8601 format. If this value is more than one year greater than begin_time, this endpoint returns an error. Default value: The current time. |
| `limit` | `?int` | Query, Optional | The maximum number of settlements to return in a single response. This value cannot exceed 200. |
| `status` | [`?string (V1ListSettlementsRequestStatus)`](../../doc/models/v1-list-settlements-request-status.md) | Query, Optional | Provide this parameter to retrieve only settlements with a particular status (SENT or FAILED). |
| `batchToken` | `?string` | Query, Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. |

## Response Type

[`V1Settlement[]`](../../doc/models/v1-settlement.md)

## Example Usage

```php
$locationId = 'location_id4';

$apiResponse = $v1TransactionsApi->v1ListSettlements($locationId);

if ($apiResponse->isSuccess()) {
    $v1Settlement = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# V1 Retrieve Settlement

**This endpoint is deprecated.**

Provides comprehensive information for a single settlement.

The returned `Settlement` objects include an `entries` field that lists
the transactions that contribute to the settlement total. Most
settlement entries correspond to a payment payout, but settlement
entries are also generated for less common events, like refunds, manual
adjustments, or chargeback holds.

Square initiates its regular deposits as indicated in the
[Deposit Options with Square](https://squareup.com/help/us/en/article/3807)
help article. Details for a regular deposit are usually not available
from Connect API endpoints before 10 p.m. PST the same day.

Square does not know when an initiated settlement **completes**, only
whether it has failed. A completed settlement is typically reflected in
a bank account within 3 business days, but in exceptional cases it may
take longer.

```php
function v1RetrieveSettlement(string $locationId, string $settlementId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `string` | Template, Required | The ID of the settlements's associated location. |
| `settlementId` | `string` | Template, Required | The settlement's Square-issued ID. You obtain this value from Settlement objects returned by the List Settlements endpoint. |

## Response Type

[`V1Settlement`](../../doc/models/v1-settlement.md)

## Example Usage

```php
$locationId = 'location_id4';

$settlementId = 'settlement_id0';

$apiResponse = $v1TransactionsApi->v1RetrieveSettlement(
    $locationId,
    $settlementId
);

if ($apiResponse->isSuccess()) {
    $v1Settlement = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

