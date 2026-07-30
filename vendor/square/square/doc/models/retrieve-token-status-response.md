
# Retrieve Token Status Response

Defines the fields that are included in the response body of
a request to the `RetrieveTokenStatus` endpoint

## Structure

`RetrieveTokenStatusResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `scopes` | `?(string[])` | Optional | The list of scopes associated with an access token. | getScopes(): ?array | setScopes(?array scopes): void |
| `expiresAt` | `?string` | Optional | The date and time when the `access_token` expires, in RFC 3339 format. Empty if token never expires. | getExpiresAt(): ?string | setExpiresAt(?string expiresAt): void |
| `clientId` | `?string` | Optional | The Square-issued application ID associated with the access token. This is the same application ID used to obtain the token.<br>**Constraints**: *Maximum Length*: `191` | getClientId(): ?string | setClientId(?string clientId): void |
| `merchantId` | `?string` | Optional | The ID of the authorizing merchant's business.<br>**Constraints**: *Minimum Length*: `8`, *Maximum Length*: `191` | getMerchantId(): ?string | setMerchantId(?string merchantId): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "client_id": "CLIENT_ID",
  "expires_at": "2022-10-14T14:44:00Z",
  "merchant_id": "MERCHANT_ID",
  "scopes": [
    "PAYMENTS_READ",
    "PAYMENTS_WRITE"
  ]
}
```

