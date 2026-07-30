
# Create Gift Card Request

Represents a [CreateGiftCard](../../doc/apis/gift-cards.md#create-gift-card) request.

## Structure

`CreateGiftCardRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A unique identifier for this request, used to ensure idempotency. For more information,<br>see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `locationId` | `string` | Required | The ID of the [location](entity:Location) where the gift card should be registered for<br>reporting purposes. Gift cards can be redeemed at any of the seller's locations.<br>**Constraints**: *Minimum Length*: `1` | getLocationId(): string | setLocationId(string locationId): void |
| `giftCard` | [`GiftCard`](../../doc/models/gift-card.md) | Required | Represents a Square gift card. | getGiftCard(): GiftCard | setGiftCard(GiftCard giftCard): void |

## Example (as JSON)

```json
{
  "gift_card": {
    "type": "DIGITAL"
  },
  "idempotency_key": "NC9Tm69EjbjtConu",
  "location_id": "81FN9BNFZTKS4"
}
```

