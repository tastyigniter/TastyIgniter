
# Renew Token Request

## Structure

`RenewTokenRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `accessToken` | `?string` | Optional | The token you want to renew.<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `1024` | getAccessToken(): ?string | setAccessToken(?string accessToken): void |

## Example (as JSON)

```json
{
  "access_token": "ACCESS_TOKEN"
}
```

