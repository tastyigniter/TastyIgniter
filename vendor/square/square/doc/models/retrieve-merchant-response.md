
# Retrieve Merchant Response

The response object returned by the [RetrieveMerchant](../../doc/apis/merchants.md#retrieve-merchant) endpoint.

## Structure

`RetrieveMerchantResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `merchant` | [`?Merchant`](../../doc/models/merchant.md) | Optional | Represents a business that sells with Square. | getMerchant(): ?Merchant | setMerchant(?Merchant merchant): void |

## Example (as JSON)

```json
{
  "merchant": {
    "business_name": "Apple A Day",
    "country": "US",
    "created_at": "2021-12-10T19:25:52.484Z",
    "currency": "USD",
    "id": "DM7VKY8Q63GNP",
    "language_code": "en-US",
    "main_location_id": "9A65CGC72ZQG1",
    "status": "ACTIVE"
  }
}
```

