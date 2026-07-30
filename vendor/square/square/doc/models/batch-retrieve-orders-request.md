
# Batch Retrieve Orders Request

Defines the fields that are included in requests to the
`BatchRetrieveOrders` endpoint.

## Structure

`BatchRetrieveOrdersRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationId` | `?string` | Optional | The ID of the location for these orders. This field is optional: omit it to retrieve<br>orders within the scope of the current authorization's merchant ID. | getLocationId(): ?string | setLocationId(?string locationId): void |
| `orderIds` | `string[]` | Required | The IDs of the orders to retrieve. A maximum of 100 orders can be retrieved per request. | getOrderIds(): array | setOrderIds(array orderIds): void |

## Example (as JSON)

```json
{
  "location_id": "057P5VYJ4A5X1",
  "order_ids": [
    "CAISEM82RcpmcFBM0TfOyiHV3es",
    "CAISENgvlJ6jLWAzERDzjyHVybY"
  ]
}
```

