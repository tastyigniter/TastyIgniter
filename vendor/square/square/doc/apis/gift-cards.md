# Gift Cards

```php
$giftCardsApi = $client->getGiftCardsApi();
```

## Class Name

`GiftCardsApi`

## Methods

* [List Gift Cards](../../doc/apis/gift-cards.md#list-gift-cards)
* [Create Gift Card](../../doc/apis/gift-cards.md#create-gift-card)
* [Retrieve Gift Card From GAN](../../doc/apis/gift-cards.md#retrieve-gift-card-from-gan)
* [Retrieve Gift Card From Nonce](../../doc/apis/gift-cards.md#retrieve-gift-card-from-nonce)
* [Link Customer to Gift Card](../../doc/apis/gift-cards.md#link-customer-to-gift-card)
* [Unlink Customer From Gift Card](../../doc/apis/gift-cards.md#unlink-customer-from-gift-card)
* [Retrieve Gift Card](../../doc/apis/gift-cards.md#retrieve-gift-card)


# List Gift Cards

Lists all gift cards. You can specify optional filters to retrieve
a subset of the gift cards. Results are sorted by `created_at` in ascending order.

```php
function listGiftCards(
    ?string $type = null,
    ?string $state = null,
    ?int $limit = null,
    ?string $cursor = null,
    ?string $customerId = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `type` | `?string` | Query, Optional | If a [type](entity:GiftCardType) is provided, the endpoint returns gift cards of the specified type.<br>Otherwise, the endpoint returns gift cards of all types. |
| `state` | `?string` | Query, Optional | If a [state](entity:GiftCardStatus) is provided, the endpoint returns the gift cards in the specified state.<br>Otherwise, the endpoint returns the gift cards of all states. |
| `limit` | `?int` | Query, Optional | If a limit is provided, the endpoint returns only the specified number of results per page.<br>The maximum value is 50. The default value is 30.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>If a cursor is not provided, the endpoint returns the first page of the results.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). |
| `customerId` | `?string` | Query, Optional | If a customer ID is provided, the endpoint returns only the gift cards linked to the specified customer. |

## Response Type

[`ListGiftCardsResponse`](../../doc/models/list-gift-cards-response.md)

## Example Usage

```php
$apiResponse = $giftCardsApi->listGiftCards();

if ($apiResponse->isSuccess()) {
    $listGiftCardsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Gift Card

Creates a digital gift card or registers a physical (plastic) gift card. After the gift card
is created, you must call [CreateGiftCardActivity](../../doc/apis/gift-card-activities.md#create-gift-card-activity)
to activate the card with an initial balance before it can be used for payment.

```php
function createGiftCard(CreateGiftCardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateGiftCardRequest`](../../doc/models/create-gift-card-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateGiftCardResponse`](../../doc/models/create-gift-card-response.md)

## Example Usage

```php
$body = CreateGiftCardRequestBuilder::init(
    'NC9Tm69EjbjtConu',
    '81FN9BNFZTKS4',
    GiftCardBuilder::init(
        GiftCardType::DIGITAL
    )->build()
)->build();

$apiResponse = $giftCardsApi->createGiftCard($body);

if ($apiResponse->isSuccess()) {
    $createGiftCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Gift Card From GAN

Retrieves a gift card using the gift card account number (GAN).

```php
function retrieveGiftCardFromGAN(RetrieveGiftCardFromGANRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`RetrieveGiftCardFromGANRequest`](../../doc/models/retrieve-gift-card-from-gan-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`RetrieveGiftCardFromGANResponse`](../../doc/models/retrieve-gift-card-from-gan-response.md)

## Example Usage

```php
$body = RetrieveGiftCardFromGANRequestBuilder::init(
    '7783320001001635'
)->build();

$apiResponse = $giftCardsApi->retrieveGiftCardFromGAN($body);

if ($apiResponse->isSuccess()) {
    $retrieveGiftCardFromGANResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Gift Card From Nonce

Retrieves a gift card using a secure payment token that represents the gift card.

```php
function retrieveGiftCardFromNonce(RetrieveGiftCardFromNonceRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`RetrieveGiftCardFromNonceRequest`](../../doc/models/retrieve-gift-card-from-nonce-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`RetrieveGiftCardFromNonceResponse`](../../doc/models/retrieve-gift-card-from-nonce-response.md)

## Example Usage

```php
$body = RetrieveGiftCardFromNonceRequestBuilder::init(
    'cnon:7783322135245171'
)->build();

$apiResponse = $giftCardsApi->retrieveGiftCardFromNonce($body);

if ($apiResponse->isSuccess()) {
    $retrieveGiftCardFromNonceResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Link Customer to Gift Card

Links a customer to a gift card, which is also referred to as adding a card on file.

```php
function linkCustomerToGiftCard(string $giftCardId, LinkCustomerToGiftCardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `giftCardId` | `string` | Template, Required | The ID of the gift card to be linked. |
| `body` | [`LinkCustomerToGiftCardRequest`](../../doc/models/link-customer-to-gift-card-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`LinkCustomerToGiftCardResponse`](../../doc/models/link-customer-to-gift-card-response.md)

## Example Usage

```php
$giftCardId = 'gift_card_id8';

$body = LinkCustomerToGiftCardRequestBuilder::init(
    'GKY0FZ3V717AH8Q2D821PNT2ZW'
)->build();

$apiResponse = $giftCardsApi->linkCustomerToGiftCard(
    $giftCardId,
    $body
);

if ($apiResponse->isSuccess()) {
    $linkCustomerToGiftCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Unlink Customer From Gift Card

Unlinks a customer from a gift card, which is also referred to as removing a card on file.

```php
function unlinkCustomerFromGiftCard(string $giftCardId, UnlinkCustomerFromGiftCardRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `giftCardId` | `string` | Template, Required | The ID of the gift card to be unlinked. |
| `body` | [`UnlinkCustomerFromGiftCardRequest`](../../doc/models/unlink-customer-from-gift-card-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UnlinkCustomerFromGiftCardResponse`](../../doc/models/unlink-customer-from-gift-card-response.md)

## Example Usage

```php
$giftCardId = 'gift_card_id8';

$body = UnlinkCustomerFromGiftCardRequestBuilder::init(
    'GKY0FZ3V717AH8Q2D821PNT2ZW'
)->build();

$apiResponse = $giftCardsApi->unlinkCustomerFromGiftCard(
    $giftCardId,
    $body
);

if ($apiResponse->isSuccess()) {
    $unlinkCustomerFromGiftCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Gift Card

Retrieves a gift card using the gift card ID.

```php
function retrieveGiftCard(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | The ID of the gift card to retrieve. |

## Response Type

[`RetrieveGiftCardResponse`](../../doc/models/retrieve-gift-card-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $giftCardsApi->retrieveGiftCard($id);

if ($apiResponse->isSuccess()) {
    $retrieveGiftCardResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

