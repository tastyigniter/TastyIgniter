
# Create Terminal Checkout Request

## Structure

`CreateTerminalCheckoutRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A unique string that identifies this `CreateCheckout` request. Keys can be any valid string but<br>must be unique for every `CreateCheckout` request.<br><br>See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more information.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `64` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `checkout` | [`TerminalCheckout`](../../doc/models/terminal-checkout.md) | Required | Represents a checkout processed by the Square Terminal. | getCheckout(): TerminalCheckout | setCheckout(TerminalCheckout checkout): void |

## Example (as JSON)

```json
{
  "checkout": {
    "amount_money": {
      "amount": 2610,
      "currency": "USD"
    },
    "device_options": {
      "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003"
    },
    "note": "A brief note",
    "reference_id": "id11572"
  },
  "idempotency_key": "28a0c3bc-7839-11ea-bc55-0242ac130003"
}
```

