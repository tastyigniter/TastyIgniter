# Loyalty

```php
$loyaltyApi = $client->getLoyaltyApi();
```

## Class Name

`LoyaltyApi`

## Methods

* [Create Loyalty Account](../../doc/apis/loyalty.md#create-loyalty-account)
* [Search Loyalty Accounts](../../doc/apis/loyalty.md#search-loyalty-accounts)
* [Retrieve Loyalty Account](../../doc/apis/loyalty.md#retrieve-loyalty-account)
* [Accumulate Loyalty Points](../../doc/apis/loyalty.md#accumulate-loyalty-points)
* [Adjust Loyalty Points](../../doc/apis/loyalty.md#adjust-loyalty-points)
* [Search Loyalty Events](../../doc/apis/loyalty.md#search-loyalty-events)
* [List Loyalty Programs](../../doc/apis/loyalty.md#list-loyalty-programs)
* [Retrieve Loyalty Program](../../doc/apis/loyalty.md#retrieve-loyalty-program)
* [Calculate Loyalty Points](../../doc/apis/loyalty.md#calculate-loyalty-points)
* [List Loyalty Promotions](../../doc/apis/loyalty.md#list-loyalty-promotions)
* [Create Loyalty Promotion](../../doc/apis/loyalty.md#create-loyalty-promotion)
* [Retrieve Loyalty Promotion](../../doc/apis/loyalty.md#retrieve-loyalty-promotion)
* [Cancel Loyalty Promotion](../../doc/apis/loyalty.md#cancel-loyalty-promotion)
* [Create Loyalty Reward](../../doc/apis/loyalty.md#create-loyalty-reward)
* [Search Loyalty Rewards](../../doc/apis/loyalty.md#search-loyalty-rewards)
* [Delete Loyalty Reward](../../doc/apis/loyalty.md#delete-loyalty-reward)
* [Retrieve Loyalty Reward](../../doc/apis/loyalty.md#retrieve-loyalty-reward)
* [Redeem Loyalty Reward](../../doc/apis/loyalty.md#redeem-loyalty-reward)


# Create Loyalty Account

Creates a loyalty account. To create a loyalty account, you must provide the `program_id` and a `mapping` with the `phone_number` of the buyer.

```php
function createLoyaltyAccount(CreateLoyaltyAccountRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateLoyaltyAccountRequest`](../../doc/models/create-loyalty-account-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateLoyaltyAccountResponse`](../../doc/models/create-loyalty-account-response.md)

## Example Usage

```php
$body = CreateLoyaltyAccountRequestBuilder::init(
    LoyaltyAccountBuilder::init(
        'd619f755-2d17-41f3-990d-c04ecedd64dd'
    )
        ->mapping(
            LoyaltyAccountMappingBuilder::init()
                ->phoneNumber('+14155551234')
                ->build()
        )
        ->build(),
    'ec78c477-b1c3-4899-a209-a4e71337c996'
)->build();

$apiResponse = $loyaltyApi->createLoyaltyAccount($body);

if ($apiResponse->isSuccess()) {
    $createLoyaltyAccountResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Loyalty Accounts

Searches for loyalty accounts in a loyalty program.

You can search for a loyalty account using the phone number or customer ID associated with the account. To return all loyalty accounts, specify an empty `query` object or omit it entirely.

Search results are sorted by `created_at` in ascending order.

```php
function searchLoyaltyAccounts(SearchLoyaltyAccountsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchLoyaltyAccountsRequest`](../../doc/models/search-loyalty-accounts-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchLoyaltyAccountsResponse`](../../doc/models/search-loyalty-accounts-response.md)

## Example Usage

```php
$body = SearchLoyaltyAccountsRequestBuilder::init()
    ->query(
        SearchLoyaltyAccountsRequestLoyaltyAccountQueryBuilder::init()
            ->mappings(
                [
                    LoyaltyAccountMappingBuilder::init()
                        ->phoneNumber('+14155551234')
                        ->build()
                ]
            )
            ->build()
    )
    ->limit(10)
    ->build();

$apiResponse = $loyaltyApi->searchLoyaltyAccounts($body);

if ($apiResponse->isSuccess()) {
    $searchLoyaltyAccountsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Loyalty Account

Retrieves a loyalty account.

```php
function retrieveLoyaltyAccount(string $accountId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `accountId` | `string` | Template, Required | The ID of the [loyalty account](entity:LoyaltyAccount) to retrieve. |

## Response Type

[`RetrieveLoyaltyAccountResponse`](../../doc/models/retrieve-loyalty-account-response.md)

## Example Usage

```php
$accountId = 'account_id2';

$apiResponse = $loyaltyApi->retrieveLoyaltyAccount($accountId);

if ($apiResponse->isSuccess()) {
    $retrieveLoyaltyAccountResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Accumulate Loyalty Points

Adds points earned from a purchase to a [loyalty account](../../doc/models/loyalty-account.md).

- If you are using the Orders API to manage orders, provide the `order_id`. Square reads the order
  to compute the points earned from both the base loyalty program and an associated
  [loyalty promotion](../../doc/models/loyalty-promotion.md). For purchases that qualify for multiple accrual
  rules, Square computes points based on the accrual rule that grants the most points.
  For purchases that qualify for multiple promotions, Square computes points based on the most
  recently created promotion. A purchase must first qualify for program points to be eligible for promotion points.

- If you are not using the Orders API to manage orders, provide `points` with the number of points to add.
  You must first perform a client-side computation of the points earned from the loyalty program and
  loyalty promotion. For spend-based and visit-based programs, you can call [CalculateLoyaltyPoints](../../doc/apis/loyalty.md#calculate-loyalty-points)
  to compute the points earned from the base loyalty program. For information about computing points earned from a loyalty promotion, see
  [Calculating promotion points](https://developer.squareup.com/docs/loyalty-api/loyalty-promotions#calculate-promotion-points).

```php
function accumulateLoyaltyPoints(string $accountId, AccumulateLoyaltyPointsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `accountId` | `string` | Template, Required | The ID of the target [loyalty account](entity:LoyaltyAccount). |
| `body` | [`AccumulateLoyaltyPointsRequest`](../../doc/models/accumulate-loyalty-points-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`AccumulateLoyaltyPointsResponse`](../../doc/models/accumulate-loyalty-points-response.md)

## Example Usage

```php
$accountId = 'account_id2';

$body = AccumulateLoyaltyPointsRequestBuilder::init(
    LoyaltyEventAccumulatePointsBuilder::init()
        ->orderId('RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY')
        ->build(),
    '58b90739-c3e8-4b11-85f7-e636d48d72cb',
    'P034NEENMD09F'
)->build();

$apiResponse = $loyaltyApi->accumulateLoyaltyPoints(
    $accountId,
    $body
);

if ($apiResponse->isSuccess()) {
    $accumulateLoyaltyPointsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Adjust Loyalty Points

Adds points to or subtracts points from a buyer's account.

Use this endpoint only when you need to manually adjust points. Otherwise, in your application flow, you call
[AccumulateLoyaltyPoints](../../doc/apis/loyalty.md#accumulate-loyalty-points)
to add points when a buyer pays for the purchase.

```php
function adjustLoyaltyPoints(string $accountId, AdjustLoyaltyPointsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `accountId` | `string` | Template, Required | The ID of the target [loyalty account](entity:LoyaltyAccount). |
| `body` | [`AdjustLoyaltyPointsRequest`](../../doc/models/adjust-loyalty-points-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`AdjustLoyaltyPointsResponse`](../../doc/models/adjust-loyalty-points-response.md)

## Example Usage

```php
$accountId = 'account_id2';

$body = AdjustLoyaltyPointsRequestBuilder::init(
    'bc29a517-3dc9-450e-aa76-fae39ee849d1',
    LoyaltyEventAdjustPointsBuilder::init(
        10
    )
        ->reason('Complimentary points')
        ->build()
)->build();

$apiResponse = $loyaltyApi->adjustLoyaltyPoints(
    $accountId,
    $body
);

if ($apiResponse->isSuccess()) {
    $adjustLoyaltyPointsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Loyalty Events

Searches for loyalty events.

A Square loyalty program maintains a ledger of events that occur during the lifetime of a
buyer's loyalty account. Each change in the point balance
(for example, points earned, points redeemed, and points expired) is
recorded in the ledger. Using this endpoint, you can search the ledger for events.

Search results are sorted by `created_at` in descending order.

```php
function searchLoyaltyEvents(SearchLoyaltyEventsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchLoyaltyEventsRequest`](../../doc/models/search-loyalty-events-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchLoyaltyEventsResponse`](../../doc/models/search-loyalty-events-response.md)

## Example Usage

```php
$body = SearchLoyaltyEventsRequestBuilder::init()
    ->query(
        LoyaltyEventQueryBuilder::init()
            ->filter(
                LoyaltyEventFilterBuilder::init()
                    ->orderFilter(
                        LoyaltyEventOrderFilterBuilder::init(
                            'PyATxhYLfsMqpVkcKJITPydgEYfZY'
                        )->build()
                    )->build()
            )->build()
    )
    ->limit(30)
    ->build();

$apiResponse = $loyaltyApi->searchLoyaltyEvents($body);

if ($apiResponse->isSuccess()) {
    $searchLoyaltyEventsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Loyalty Programs

**This endpoint is deprecated.**

Returns a list of loyalty programs in the seller's account.
Loyalty programs define how buyers can earn points and redeem points for rewards. Square sellers can have only one loyalty program, which is created and managed from the Seller Dashboard. For more information, see [Loyalty Program Overview](https://developer.squareup.com/docs/loyalty/overview).

Replaced with [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) when used with the keyword `main`.

```php
function listLoyaltyPrograms(): ApiResponse
```

## Response Type

[`ListLoyaltyProgramsResponse`](../../doc/models/list-loyalty-programs-response.md)

## Example Usage

```php
$apiResponse = $loyaltyApi->listLoyaltyPrograms();

if ($apiResponse->isSuccess()) {
    $listLoyaltyProgramsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Loyalty Program

Retrieves the loyalty program in a seller's account, specified by the program ID or the keyword `main`.

Loyalty programs define how buyers can earn points and redeem points for rewards. Square sellers can have only one loyalty program, which is created and managed from the Seller Dashboard. For more information, see [Loyalty Program Overview](https://developer.squareup.com/docs/loyalty/overview).

```php
function retrieveLoyaltyProgram(string $programId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `programId` | `string` | Template, Required | The ID of the loyalty program or the keyword `main`. Either value can be used to retrieve the single loyalty program that belongs to the seller. |

## Response Type

[`RetrieveLoyaltyProgramResponse`](../../doc/models/retrieve-loyalty-program-response.md)

## Example Usage

```php
$programId = 'program_id0';

$apiResponse = $loyaltyApi->retrieveLoyaltyProgram($programId);

if ($apiResponse->isSuccess()) {
    $retrieveLoyaltyProgramResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Calculate Loyalty Points

Calculates the number of points a buyer can earn from a purchase. Applications might call this endpoint
to display the points to the buyer.

- If you are using the Orders API to manage orders, provide the `order_id` and (optional) `loyalty_account_id`.
  Square reads the order to compute the points earned from the base loyalty program and an associated
  [loyalty promotion](../../doc/models/loyalty-promotion.md).

- If you are not using the Orders API to manage orders, provide `transaction_amount_money` with the
  purchase amount. Square uses this amount to calculate the points earned from the base loyalty program,
  but not points earned from a loyalty promotion. For spend-based and visit-based programs, the `tax_mode`
  setting of the accrual rule indicates how taxes should be treated for loyalty points accrual.
  If the purchase qualifies for program points, call
  [ListLoyaltyPromotions](../../doc/apis/loyalty.md#list-loyalty-promotions) and perform a client-side computation
  to calculate whether the purchase also qualifies for promotion points. For more information, see
  [Calculating promotion points](https://developer.squareup.com/docs/loyalty-api/loyalty-promotions#calculate-promotion-points).

```php
function calculateLoyaltyPoints(string $programId, CalculateLoyaltyPointsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `programId` | `string` | Template, Required | The ID of the [loyalty program](entity:LoyaltyProgram), which defines the rules for accruing points. |
| `body` | [`CalculateLoyaltyPointsRequest`](../../doc/models/calculate-loyalty-points-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CalculateLoyaltyPointsResponse`](../../doc/models/calculate-loyalty-points-response.md)

## Example Usage

```php
$programId = 'program_id0';

$body = CalculateLoyaltyPointsRequestBuilder::init()
    ->orderId('RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY')
    ->loyaltyAccountId('79b807d2-d786-46a9-933b-918028d7a8c5')
    ->build();

$apiResponse = $loyaltyApi->calculateLoyaltyPoints(
    $programId,
    $body
);

if ($apiResponse->isSuccess()) {
    $calculateLoyaltyPointsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Loyalty Promotions

Lists the loyalty promotions associated with a [loyalty program](../../doc/models/loyalty-program.md).
Results are sorted by the `created_at` date in descending order (newest to oldest).

```php
function listLoyaltyPromotions(
    string $programId,
    ?string $status = null,
    ?string $cursor = null,
    ?int $limit = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `programId` | `string` | Template, Required | The ID of the base [loyalty program](entity:LoyaltyProgram). To get the program ID,<br>call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) using the `main` keyword. |
| `status` | [`?string (LoyaltyPromotionStatus)`](../../doc/models/loyalty-promotion-status.md) | Query, Optional | The status to filter the results by. If a status is provided, only loyalty promotions<br>with the specified status are returned. Otherwise, all loyalty promotions associated with<br>the loyalty program are returned. |
| `cursor` | `?string` | Query, Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `limit` | `?int` | Query, Optional | The maximum number of results to return in a single paged response.<br>The minimum value is 1 and the maximum value is 30. The default value is 30.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListLoyaltyPromotionsResponse`](../../doc/models/list-loyalty-promotions-response.md)

## Example Usage

```php
$programId = 'program_id0';

$apiResponse = $loyaltyApi->listLoyaltyPromotions($programId);

if ($apiResponse->isSuccess()) {
    $listLoyaltyPromotionsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Loyalty Promotion

Creates a loyalty promotion for a [loyalty program](../../doc/models/loyalty-program.md). A loyalty promotion
enables buyers to earn points in addition to those earned from the base loyalty program.

This endpoint sets the loyalty promotion to the `ACTIVE` or `SCHEDULED` status, depending on the
`available_time` setting. A loyalty program can have a maximum of 10 loyalty promotions with an
`ACTIVE` or `SCHEDULED` status.

```php
function createLoyaltyPromotion(string $programId, CreateLoyaltyPromotionRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `programId` | `string` | Template, Required | The ID of the [loyalty program](entity:LoyaltyProgram) to associate with the promotion.<br>To get the program ID, call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram)<br>using the `main` keyword. |
| `body` | [`CreateLoyaltyPromotionRequest`](../../doc/models/create-loyalty-promotion-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateLoyaltyPromotionResponse`](../../doc/models/create-loyalty-promotion-response.md)

## Example Usage

```php
$programId = 'program_id0';

$body = CreateLoyaltyPromotionRequestBuilder::init(
    LoyaltyPromotionBuilder::init(
        'Tuesday Happy Hour Promo',
        LoyaltyPromotionIncentiveBuilder::init(
            LoyaltyPromotionIncentiveType::POINTS_MULTIPLIER
        )
            ->pointsMultiplierData(
                LoyaltyPromotionIncentivePointsMultiplierDataBuilder::init(
                    3
                )->build()
            )->build(),
        LoyaltyPromotionAvailableTimeDataBuilder::init(
            [
                'BEGIN:VEVENT
DTSTART:20220816T160000
DURATION:PT2H
RRULE:FREQ=WEEKLY;BYDAY=TU
END:VEVENT'
            ]
        )->build()
    )
        ->triggerLimit(
            LoyaltyPromotionTriggerLimitBuilder::init(
                1
            )
                ->interval(LoyaltyPromotionTriggerLimitInterval::DAY)
                ->build()
        )
        ->minimumSpendAmountMoney(
            MoneyBuilder::init()
                ->amount(2000)
                ->currency(Currency::USD)
                ->build()
        )
        ->qualifyingCategoryIds(
            [
                'XTQPYLR3IIU9C44VRCB3XD12'
            ]
        )
        ->build(),
    'ec78c477-b1c3-4899-a209-a4e71337c996'
)->build();

$apiResponse = $loyaltyApi->createLoyaltyPromotion(
    $programId,
    $body
);

if ($apiResponse->isSuccess()) {
    $createLoyaltyPromotionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Loyalty Promotion

Retrieves a loyalty promotion.

```php
function retrieveLoyaltyPromotion(string $promotionId, string $programId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `promotionId` | `string` | Template, Required | The ID of the [loyalty promotion](entity:LoyaltyPromotion) to retrieve. |
| `programId` | `string` | Template, Required | The ID of the base [loyalty program](entity:LoyaltyProgram). To get the program ID,<br>call [RetrieveLoyaltyProgram](api-endpoint:Loyalty-RetrieveLoyaltyProgram) using the `main` keyword. |

## Response Type

[`RetrieveLoyaltyPromotionResponse`](../../doc/models/retrieve-loyalty-promotion-response.md)

## Example Usage

```php
$promotionId = 'promotion_id0';

$programId = 'program_id0';

$apiResponse = $loyaltyApi->retrieveLoyaltyPromotion(
    $promotionId,
    $programId
);

if ($apiResponse->isSuccess()) {
    $retrieveLoyaltyPromotionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Cancel Loyalty Promotion

Cancels a loyalty promotion. Use this endpoint to cancel an `ACTIVE` promotion earlier than the
end date, cancel an `ACTIVE` promotion when an end date is not specified, or cancel a `SCHEDULED` promotion.
Because updating a promotion is not supported, you can also use this endpoint to cancel a promotion before
you create a new one.

This endpoint sets the loyalty promotion to the `CANCELED` state

```php
function cancelLoyaltyPromotion(string $promotionId, string $programId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `promotionId` | `string` | Template, Required | The ID of the [loyalty promotion](entity:LoyaltyPromotion) to cancel. You can cancel a<br>promotion that has an `ACTIVE` or `SCHEDULED` status. |
| `programId` | `string` | Template, Required | The ID of the base [loyalty program](entity:LoyaltyProgram). |

## Response Type

[`CancelLoyaltyPromotionResponse`](../../doc/models/cancel-loyalty-promotion-response.md)

## Example Usage

```php
$promotionId = 'promotion_id0';

$programId = 'program_id0';

$apiResponse = $loyaltyApi->cancelLoyaltyPromotion(
    $promotionId,
    $programId
);

if ($apiResponse->isSuccess()) {
    $cancelLoyaltyPromotionResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Loyalty Reward

Creates a loyalty reward. In the process, the endpoint does following:

- Uses the `reward_tier_id` in the request to determine the number of points
  to lock for this reward.
- If the request includes `order_id`, it adds the reward and related discount to the order.

After a reward is created, the points are locked and
not available for the buyer to redeem another reward.

```php
function createLoyaltyReward(CreateLoyaltyRewardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateLoyaltyRewardRequest`](../../doc/models/create-loyalty-reward-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateLoyaltyRewardResponse`](../../doc/models/create-loyalty-reward-response.md)

## Example Usage

```php
$body = CreateLoyaltyRewardRequestBuilder::init(
    LoyaltyRewardBuilder::init(
        '5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd',
        'e1b39225-9da5-43d1-a5db-782cdd8ad94f'
    )
        ->orderId('RFZfrdtm3mhO1oGzf5Cx7fEMsmGZY')
        ->build(),
    '18c2e5ea-a620-4b1f-ad60-7b167285e451'
)->build();

$apiResponse = $loyaltyApi->createLoyaltyReward($body);

if ($apiResponse->isSuccess()) {
    $createLoyaltyRewardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Search Loyalty Rewards

Searches for loyalty rewards. This endpoint accepts a request with no query filters and returns results for all loyalty accounts.
If you include a `query` object, `loyalty_account_id` is required and `status` is  optional.

If you know a reward ID, use the
[RetrieveLoyaltyReward](../../doc/apis/loyalty.md#retrieve-loyalty-reward) endpoint.

Search results are sorted by `updated_at` in descending order.

```php
function searchLoyaltyRewards(SearchLoyaltyRewardsRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`SearchLoyaltyRewardsRequest`](../../doc/models/search-loyalty-rewards-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`SearchLoyaltyRewardsResponse`](../../doc/models/search-loyalty-rewards-response.md)

## Example Usage

```php
$body = SearchLoyaltyRewardsRequestBuilder::init()
    ->query(
        SearchLoyaltyRewardsRequestLoyaltyRewardQueryBuilder::init(
            '5adcb100-07f1-4ee7-b8c6-6bb9ebc474bd'
        )->build()
    )
    ->limit(10)
    ->build();

$apiResponse = $loyaltyApi->searchLoyaltyRewards($body);

if ($apiResponse->isSuccess()) {
    $searchLoyaltyRewardsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Loyalty Reward

Deletes a loyalty reward by doing the following:

- Returns the loyalty points back to the loyalty account.
- If an order ID was specified when the reward was created
  (see [CreateLoyaltyReward](../../doc/apis/loyalty.md#create-loyalty-reward)),
  it updates the order by removing the reward and related
  discounts.

You cannot delete a reward that has reached the terminal state (REDEEMED).

```php
function deleteLoyaltyReward(string $rewardId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `rewardId` | `string` | Template, Required | The ID of the [loyalty reward](entity:LoyaltyReward) to delete. |

## Response Type

[`DeleteLoyaltyRewardResponse`](../../doc/models/delete-loyalty-reward-response.md)

## Example Usage

```php
$rewardId = 'reward_id4';

$apiResponse = $loyaltyApi->deleteLoyaltyReward($rewardId);

if ($apiResponse->isSuccess()) {
    $deleteLoyaltyRewardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Loyalty Reward

Retrieves a loyalty reward.

```php
function retrieveLoyaltyReward(string $rewardId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `rewardId` | `string` | Template, Required | The ID of the [loyalty reward](entity:LoyaltyReward) to retrieve. |

## Response Type

[`RetrieveLoyaltyRewardResponse`](../../doc/models/retrieve-loyalty-reward-response.md)

## Example Usage

```php
$rewardId = 'reward_id4';

$apiResponse = $loyaltyApi->retrieveLoyaltyReward($rewardId);

if ($apiResponse->isSuccess()) {
    $retrieveLoyaltyRewardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Redeem Loyalty Reward

Redeems a loyalty reward.

The endpoint sets the reward to the `REDEEMED` terminal state.

If you are using your own order processing system (not using the
Orders API), you call this endpoint after the buyer paid for the
purchase.

After the reward reaches the terminal state, it cannot be deleted.
In other words, points used for the reward cannot be returned
to the account.

```php
function redeemLoyaltyReward(string $rewardId, RedeemLoyaltyRewardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `rewardId` | `string` | Template, Required | The ID of the [loyalty reward](entity:LoyaltyReward) to redeem. |
| `body` | [`RedeemLoyaltyRewardRequest`](../../doc/models/redeem-loyalty-reward-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`RedeemLoyaltyRewardResponse`](../../doc/models/redeem-loyalty-reward-response.md)

## Example Usage

```php
$rewardId = 'reward_id4';

$body = RedeemLoyaltyRewardRequestBuilder::init(
    '98adc7f7-6963-473b-b29c-f3c9cdd7d994',
    'P034NEENMD09F'
)->build();

$apiResponse = $loyaltyApi->redeemLoyaltyReward(
    $rewardId,
    $body
);

if ($apiResponse->isSuccess()) {
    $redeemLoyaltyRewardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

