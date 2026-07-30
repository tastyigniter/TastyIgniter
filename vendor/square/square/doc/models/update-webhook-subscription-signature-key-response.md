
# Update Webhook Subscription Signature Key Response

Defines the fields that are included in the response body of
a request to the [UpdateWebhookSubscriptionSignatureKey](../../doc/apis/webhook-subscriptions.md#update-webhook-subscription-signature-key) endpoint.

Note: If there are errors processing the request, the [Subscription](../../doc/models/webhook-subscription.md) is not
present.

## Structure

`UpdateWebhookSubscriptionSignatureKeyResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `signatureKey` | `?string` | Optional | The new Square-generated signature key used to validate the origin of the webhook event. | getSignatureKey(): ?string | setSignatureKey(?string signatureKey): void |

## Example (as JSON)

```json
{
  "signature_key": "1k9bIJKCeTmSQwyagtNRLg"
}
```

