
# Renew Token Response

## Structure

`RenewTokenResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `accessToken` | `?string` | Optional | The renewed access token.<br>This value might be different from the `access_token` you provided in your request.<br>You provide this token in a header with every request to Connect API endpoints.<br>See [Request and response headers](https://developer.squareup.com/docs/api/connect/v2/#requestandresponseheaders) for the format of this header.<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `1024` | getAccessToken(): ?string | setAccessToken(?string accessToken): void |
| `tokenType` | `?string` | Optional | This value is always _bearer_.<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `10` | getTokenType(): ?string | setTokenType(?string tokenType): void |
| `expiresAt` | `?string` | Optional | The date when the `access_token` expires, in [ISO 8601](http://www.iso.org/iso/home/standards/iso8601.htm) format.<br>**Constraints**: *Minimum Length*: `20`, *Maximum Length*: `48` | getExpiresAt(): ?string | setExpiresAt(?string expiresAt): void |
| `merchantId` | `?string` | Optional | The ID of the authorizing merchant's business.<br>**Constraints**: *Minimum Length*: `8`, *Maximum Length*: `191` | getMerchantId(): ?string | setMerchantId(?string merchantId): void |
| `subscriptionId` | `?string` | Optional | __LEGACY FIELD__. The ID of the merchant subscription associated with<br>the authorization. The ID is only present if the merchant signed up for a subscription<br>during authorization. | getSubscriptionId(): ?string | setSubscriptionId(?string subscriptionId): void |
| `planId` | `?string` | Optional | __LEGACY FIELD__. The ID of the subscription plan the merchant signed<br>up for. The ID is only present if the merchant signed up for a subscription plan during<br>authorization. | getPlanId(): ?string | setPlanId(?string planId): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "access_token": "ACCESS_TOKEN",
  "expires_at": "2006-01-02T15:04:05Z",
  "merchant_id": "MERCHANT_ID",
  "token_type": "bearer"
}
```

