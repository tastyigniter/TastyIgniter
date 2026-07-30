
# Update Webhook Subscription Signature Key Request

Updates a [Subscription](../../doc/models/webhook-subscription.md) by replacing the existing signature key with a new one.

## Structure

`UpdateWebhookSubscriptionSignatureKeyRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies the [UpdateWebhookSubscriptionSignatureKey](api-endpoint:WebhookSubscriptions-UpdateWebhookSubscriptionSignatureKey) request.<br>**Constraints**: *Maximum Length*: `45` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |

## Example (as JSON)

```json
{
  "idempotency_key": "ed80ae6b-0654-473b-bbab-a39aee89a60d"
}
```

