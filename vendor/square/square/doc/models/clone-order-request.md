
# Clone Order Request

Defines the fields that are included in requests to the
[CloneOrder](../../doc/apis/orders.md#clone-order) endpoint.

## Structure

`CloneOrderRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orderId` | `string` | Required | The ID of the order to clone. | getOrderId(): string | setOrderId(string orderId): void |
| `version` | `?int` | Optional | An optional order version for concurrency protection.<br><br>If a version is provided, it must match the latest stored version of the order to clone.<br>If a version is not provided, the API clones the latest version. | getVersion(): ?int | setVersion(?int version): void |
| `idempotencyKey` | `?string` | Optional | A value you specify that uniquely identifies this clone request.<br><br>If you are unsure whether a particular order was cloned successfully,<br>you can reattempt the call with the same idempotency key without<br>worrying about creating duplicate cloned orders.<br>The originally cloned order is returned.<br><br>For more information, see [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency). | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "UNIQUE_STRING",
  "order_id": "ZAISEM52YcpmcWAzERDOyiWS123",
  "version": 3
}
```

