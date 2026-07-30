
# List Device Codes Response

## Structure

`ListDeviceCodesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `deviceCodes` | [`?(DeviceCode[])`](../../doc/models/device-code.md) | Optional | The queried DeviceCode. | getDeviceCodes(): ?array | setDeviceCodes(?array deviceCodes): void |
| `cursor` | `?string` | Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. This value is present only if the request<br>succeeded and additional results are available.<br><br>See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "device_codes": [
    {
      "code": "EBCARJ",
      "created_at": "2020-02-06T18:44:33.000Z",
      "device_id": "907CS13101300122",
      "id": "B3Z6NAMYQSMTM",
      "location_id": "B5E4484SHHNYH",
      "name": "Counter 1",
      "pair_by": "2020-02-06T18:49:33.000Z",
      "product_type": "TERMINAL_API",
      "status": "PAIRED",
      "status_changed_at": "2020-02-06T18:47:28.000Z"
    },
    {
      "code": "GVXNYN",
      "created_at": "2020-02-07T19:55:04.000Z",
      "id": "YKGMJMYK8H4PQ",
      "location_id": "A6SYFRSV4WAFW",
      "name": "Unused device code",
      "pair_by": "2020-02-07T20:00:04.000Z",
      "product_type": "TERMINAL_API",
      "status": "UNPAIRED",
      "status_changed_at": "2020-02-07T19:55:04.000Z"
    }
  ]
}
```

