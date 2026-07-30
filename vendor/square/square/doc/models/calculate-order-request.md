
# Calculate Order Request

## Structure

`CalculateOrderRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `order` | [`Order`](../../doc/models/order.md) | Required | Contains all information related to a single order to process with Square,<br>including line items that specify the products to purchase. `Order` objects also<br>include information about any associated tenders, refunds, and returns.<br><br>All Connect V2 Transactions have all been converted to Orders including all associated<br>itemization data. | getOrder(): Order | setOrder(Order order): void |
| `proposedRewards` | [`?(OrderReward[])`](../../doc/models/order-reward.md) | Optional | Identifies one or more loyalty reward tiers to apply during the order calculation.<br>The discounts defined by the reward tiers are added to the order only to preview the<br>effect of applying the specified rewards. The rewards do not correspond to actual<br>redemptions; that is, no `reward`s are created. Therefore, the reward `id`s are<br>random strings used only to reference the reward tier. | getProposedRewards(): ?array | setProposedRewards(?array proposedRewards): void |

## Example (as JSON)

```json
{
  "idempotency_key": "b3e98fe3-b8de-471c-82f1-545f371e637c",
  "order": {
    "discounts": [
      {
        "name": "50% Off",
        "percentage": "50",
        "scope": "ORDER"
      }
    ],
    "line_items": [
      {
        "base_price_money": {
          "amount": 500,
          "currency": "USD"
        },
        "name": "Item 1",
        "quantity": "1"
      },
      {
        "base_price_money": {
          "amount": 300,
          "currency": "USD"
        },
        "name": "Item 2",
        "quantity": "2"
      }
    ],
    "location_id": "D7AVYMEAPJ3A3"
  }
}
```

