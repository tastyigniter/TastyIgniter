
# Order Line Item Applied Service Charge

## Structure

`OrderLineItemAppliedServiceCharge`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the applied service charge only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `serviceChargeUid` | `string` | Required | The `uid` of the service charge that the applied service charge represents. It must<br>reference a service charge present in the `order.service_charges` field.<br><br>This field is immutable. To change which service charges apply to a line item,<br>delete and add a new `OrderLineItemAppliedServiceCharge`.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `60` | getServiceChargeUid(): string | setServiceChargeUid(string serviceChargeUid): void |
| `appliedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppliedMoney(): ?Money | setAppliedMoney(?Money appliedMoney): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "service_charge_uid": "service_charge_uid0",
  "applied_money": {
    "amount": 196,
    "currency": "PLN"
  }
}
```

