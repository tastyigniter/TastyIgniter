
# Search Orders Fulfillment Filter

Filter based on [order fulfillment](../../doc/models/fulfillment.md) information.

## Structure

`SearchOrdersFulfillmentFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `fulfillmentTypes` | [`?(string[]) (FulfillmentType)`](../../doc/models/fulfillment-type.md) | Optional | A list of [fulfillment types](entity:FulfillmentType) to filter<br>for. The list returns orders if any of its fulfillments match any of the fulfillment types<br>listed in this field.<br>See [FulfillmentType](#type-fulfillmenttype) for possible values | getFulfillmentTypes(): ?array | setFulfillmentTypes(?array fulfillmentTypes): void |
| `fulfillmentStates` | [`?(string[]) (FulfillmentState)`](../../doc/models/fulfillment-state.md) | Optional | A list of [fulfillment states](entity:FulfillmentState) to filter<br>for. The list returns orders if any of its fulfillments match any of the<br>fulfillment states listed in this field.<br>See [FulfillmentState](#type-fulfillmentstate) for possible values | getFulfillmentStates(): ?array | setFulfillmentStates(?array fulfillmentStates): void |

## Example (as JSON)

```json
{
  "fulfillment_types": [
    "PICKUP",
    "SHIPMENT"
  ],
  "fulfillment_states": [
    "PROPOSED"
  ]
}
```

