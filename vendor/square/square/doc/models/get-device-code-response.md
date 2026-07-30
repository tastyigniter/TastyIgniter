
# Get Device Code Response

## Structure

`GetDeviceCodeResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `deviceCode` | [`?DeviceCode`](../../doc/models/device-code.md) | Optional | - | getDeviceCode(): ?DeviceCode | setDeviceCode(?DeviceCode deviceCode): void |

## Example (as JSON)

```json
{
  "device_code": {
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
  }
}
```

