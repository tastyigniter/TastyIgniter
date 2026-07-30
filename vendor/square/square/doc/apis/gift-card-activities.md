# Gift Card Activities

```php
$giftCardActivitiesApi = $client->getGiftCardActivitiesApi();
```

## Class Name

`GiftCardActivitiesApi`

## Methods

* [List Gift Card Activities](../../doc/apis/gift-card-activities.md#list-gift-card-activities)
* [Create Gift Card Activity](../../doc/apis/gift-card-activities.md#create-gift-card-activity)


# List Gift Card Activities

Lists gift card activities. By default, you get gift card activities for all
gift cards in the seller's account. You can optionally specify query parameters to
filter the list. For example, you can get a list of gift card activities for a gift card,
for all gift cards in a specific region, or for activities within a time window.

```php
function listGiftCardActivities(
    ?string $giftCardId = null,
    ?string $type = null,
    ?string $locationId = null,
    ?string $beginTime = null,
    ?string $endTime = null,
    ?int $limit = null,
    ?string $cursor = null,
    ?string $sortOrder = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `giftCardId` | `?string` | Query, Optional | If a gift card ID is provided, the endpoint returns activities related<br>to the specified gift card. Otherwise, the endpoint returns all gift card activities for<br>the seller. |
| `type` | `?string` | Query, Optional | If a [type](entity:GiftCardActivityType) is provided, the endpoint returns gift card activities of the specified type.<br>Otherwise, the endpoint returns all types of gift card activities. |
| `locationId` | `?string` | Query, Optional | If a location ID is provided, the endpoint returns gift card activities for the specified location.<br>Otherwise, the endpoint returns gift card activities for all locations. |
| `beginTime` | `?string` | Query, Optional | The timestamp for the beginning of the reporting period, in RFC 3339 format.<br>This start time is inclusive. The default value is the current time minus one year. |
| `endTime` | `?string` | Query, Optional | The timestamp for the end of the reporting period, in RFC 3339 format.<br>This end time is inclusive. The default value is the current time. |
| `limit` | `?int` | Query, Optional | If a limit is provided, the endpoint returns the specified number<br>of results (or fewer) per page. The maximum value is 100. The default value is 50.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>If a cursor is not provided, the endpoint returns the first page of the results.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `sortOrder` | `?string` | Query, Optional | The order in which the endpoint returns the activities, based on `created_at`.<br><br>- `ASC` - Oldest to newest.<br>- `DESC` - Newest to oldest (default). |

## Response Type

[`ListGiftCardActivitiesResponse`](../../doc/models/list-gift-card-activities-response.md)

## Example Usage

```php
$apiResponse = $giftCardActivitiesApi->listGiftCardActivities();

if ($apiResponse->isSuccess()) {
    $listGiftCardActivitiesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Gift Card Activity

Creates a gift card activity to manage the balance or state of a [gift card](../../doc/models/gift-card.md).
For example, you create an `ACTIVATE` activity to activate a gift card with an initial balance
before the gift card can be used.

```php
function createGiftCardActivity(CreateGiftCardActivityRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateGiftCardActivityRequest`](../../doc/models/create-gift-card-activity-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateGiftCardActivityResponse`](../../doc/models/create-gift-card-activity-response.md)

## Example Usage

```php
$body = CreateGiftCardActivityRequestBuilder::init(
    'U16kfr-kA70er-q4Rsym-7U7NnY',
    GiftCardActivityBuilder::init(
        GiftCardActivityType::ACTIVATE,
        '81FN9BNFZTKS4'
    )
        ->giftCardId('gftc:6d55a72470d940c6ba09c0ab8ad08d20')
        ->activateActivityDetails(
            GiftCardActivityActivateBuilder::init()
                ->orderId('jJNGHm4gLI6XkFbwtiSLqK72KkAZY')
                ->lineItemUid('eIWl7X0nMuO9Ewbh0ChIx')
                ->build()
        )
        ->build()
)->build();

$apiResponse = $giftCardActivitiesApi->createGiftCardActivity($body);

if ($apiResponse->isSuccess()) {
    $createGiftCardActivityResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

