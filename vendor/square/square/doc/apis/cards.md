# Cards

```php
$cardsApi = $client->getCardsApi();
```

## Class Name

`CardsApi`

## Methods

* [List Cards](../../doc/apis/cards.md#list-cards)
* [Create Card](../../doc/apis/cards.md#create-card)
* [Retrieve Card](../../doc/apis/cards.md#retrieve-card)
* [Disable Card](../../doc/apis/cards.md#disable-card)


# List Cards

Retrieves a list of cards owned by the account making the request.
A max of 25 cards will be returned.

```php
function listCards(
    ?string $cursor = null,
    ?string $customerId = null,
    ?bool $includeDisabled = false,
    ?string $referenceId = null,
    ?string $sortOrder = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for your original query.<br><br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information. |
| `customerId` | `?string` | Query, Optional | Limit results to cards associated with the customer supplied.<br>By default, all cards owned by the merchant are returned. |
| `includeDisabled` | `?bool` | Query, Optional | Includes disabled cards.<br>By default, all enabled cards owned by the merchant are returned.<br>**Default**: `false` |
| `referenceId` | `?string` | Query, Optional | Limit results to cards associated with the reference_id supplied. |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Query, Optional | Sorts the returned list by when the card was created with the specified order.<br>This field defaults to ASC. |

## Response Type

[`ListCardsResponse`](../../doc/models/list-cards-response.md)

## Example Usage

```php
$includeDisabled = false;

$apiResponse = $cardsApi->listCards($includeDisabled);

if ($apiResponse->isSuccess()) {
    $listCardsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Card

Adds a card on file to an existing merchant.

```php
function createCard(CreateCardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateCardRequest`](../../doc/models/create-card-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateCardResponse`](../../doc/models/create-card-response.md)

## Example Usage

```php
$body = CreateCardRequestBuilder::init(
    '4935a656-a929-4792-b97c-8848be85c27c',
    'cnon:uIbfJXhXETSP197M3GB',
    CardBuilder::init()
        ->cardholderName('Amelia Earhart')
        ->billingAddress(
            AddressBuilder::init()
                ->addressLine1('500 Electric Ave')
                ->addressLine2('Suite 600')
                ->locality('New York')
                ->administrativeDistrictLevel1('NY')
                ->postalCode('10003')
                ->country(Country::US)
                ->build()
        )
        ->customerId('VDKXEEKPJN48QDG3BGGFAK05P8')
        ->referenceId('user-id-1')
        ->build()
)->build();

$apiResponse = $cardsApi->createCard($body);

if ($apiResponse->isSuccess()) {
    $createCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Card

Retrieves details for a specific Card.

```php
function retrieveCard(string $cardId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cardId` | `string` | Template, Required | Unique ID for the desired Card. |

## Response Type

[`RetrieveCardResponse`](../../doc/models/retrieve-card-response.md)

## Example Usage

```php
$cardId = 'card_id4';

$apiResponse = $cardsApi->retrieveCard($cardId);

if ($apiResponse->isSuccess()) {
    $retrieveCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Disable Card

Disables the card, preventing any further updates or charges.
Disabling an already disabled card is allowed but has no effect.

```php
function disableCard(string $cardId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cardId` | `string` | Template, Required | Unique ID for the desired Card. |

## Response Type

[`DisableCardResponse`](../../doc/models/disable-card-response.md)

## Example Usage

```php
$cardId = 'card_id4';

$apiResponse = $cardsApi->disableCard($cardId);

if ($apiResponse->isSuccess()) {
    $disableCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

