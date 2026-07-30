
# Complete Payment Request

Describes a request to complete (capture) a payment using
[CompletePayment](../../doc/apis/payments.md#complete-payment).

By default, payments are set to `autocomplete` immediately after they are created.
To complete payments manually, set `autocomplete` to `false`.

## Structure

`CompletePaymentRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `versionToken` | `?string` | Optional | Used for optimistic concurrency. This opaque token identifies the current `Payment`<br>version that the caller expects. If the server has a different version of the Payment,<br>the update fails and a response with a VERSION_MISMATCH error is returned. | getVersionToken(): ?string | setVersionToken(?string versionToken): void |

## Example (as JSON)

```json
{}
```

