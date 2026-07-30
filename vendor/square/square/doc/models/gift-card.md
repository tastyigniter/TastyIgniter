
# Gift Card

Represents a Square gift card.

## Structure

`GiftCard`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the gift card. | getId(): ?string | setId(?string id): void |
| `type` | [`string (GiftCardType)`](../../doc/models/gift-card-type.md) | Required | Indicates the gift card type. | getType(): string | setType(string type): void |
| `ganSource` | [`?string (GiftCardGANSource)`](../../doc/models/gift-card-gan-source.md) | Optional | Indicates the source that generated the gift card<br>account number (GAN). | getGanSource(): ?string | setGanSource(?string ganSource): void |
| `state` | [`?string (GiftCardStatus)`](../../doc/models/gift-card-status.md) | Optional | Indicates the gift card state. | getState(): ?string | setState(?string state): void |
| `balanceMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getBalanceMoney(): ?Money | setBalanceMoney(?Money balanceMoney): void |
| `gan` | `?string` | Optional | The gift card account number (GAN). Buyers can use the GAN to make purchases or check<br>the gift card balance. | getGan(): ?string | setGan(?string gan): void |
| `createdAt` | `?string` | Optional | The timestamp when the gift card was created, in RFC 3339 format.<br>In the case of a digital gift card, it is the time when you create a card<br>(using the Square Point of Sale application, Seller Dashboard, or Gift Cards API).  <br>In the case of a plastic gift card, it is the time when Square associates the card with the<br>seller at the time of activation. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `customerIds` | `?(string[])` | Optional | The IDs of the [customer profiles](entity:Customer) to whom this gift card is linked. | getCustomerIds(): ?array | setCustomerIds(?array customerIds): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "type": "PHYSICAL",
  "gan_source": "SQUARE",
  "state": "ACTIVE",
  "balance_money": {
    "amount": 146,
    "currency": "ARS"
  },
  "gan": "gan6",
  "created_at": "created_at2",
  "customer_ids": [
    "customer_ids1",
    "customer_ids2"
  ]
}
```

