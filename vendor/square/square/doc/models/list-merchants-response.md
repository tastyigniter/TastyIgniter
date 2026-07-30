
# List Merchants Response

The response object returned by the [ListMerchant](../../doc/apis/merchants.md#list-merchants) endpoint.

## Structure

`ListMerchantsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `merchant` | [`?(Merchant[])`](../../doc/models/merchant.md) | Optional | The requested `Merchant` entities. | getMerchant(): ?array | setMerchant(?array merchant): void |
| `cursor` | `?int` | Optional | If the  response is truncated, the cursor to use in next  request to fetch next set of objects. | getCursor(): ?int | setCursor(?int cursor): void |

## Example (as JSON)

```json
{
  "merchant": [
    {
      "business_name": "Apple A Day",
      "country": "US",
      "created_at": "2021-12-10T19:25:52.484Z",
      "currency": "USD",
      "id": "DM7VKY8Q63GNP",
      "language_code": "en-US",
      "main_location_id": "9A65CGC72ZQG1",
      "status": "ACTIVE"
    }
  ]
}
```

