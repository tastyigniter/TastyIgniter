
# Order Return Service Charge

Represents the service charge applied to the original order.

## Structure

`OrderReturnServiceCharge`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the return service charge only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `sourceServiceChargeUid` | `?string` | Optional | The service charge `uid` from the order containing the original<br>service charge. `source_service_charge_uid` is `null` for<br>unlinked returns.<br>**Constraints**: *Maximum Length*: `60` | getSourceServiceChargeUid(): ?string | setSourceServiceChargeUid(?string sourceServiceChargeUid): void |
| `name` | `?string` | Optional | The name of the service charge.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |
| `catalogObjectId` | `?string` | Optional | The catalog object ID of the associated [OrderServiceCharge](entity:OrderServiceCharge).<br>**Constraints**: *Maximum Length*: `192` | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `catalogVersion` | `?int` | Optional | The version of the catalog object that this service charge references. | getCatalogVersion(): ?int | setCatalogVersion(?int catalogVersion): void |
| `percentage` | `?string` | Optional | The percentage of the service charge, as a string representation of<br>a decimal number. For example, a value of `"7.25"` corresponds to a<br>percentage of 7.25%.<br><br>Either `percentage` or `amount_money` should be set, but not both.<br>**Constraints**: *Maximum Length*: `10` | getPercentage(): ?string | setPercentage(?string percentage): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `appliedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppliedMoney(): ?Money | setAppliedMoney(?Money appliedMoney): void |
| `totalMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalMoney(): ?Money | setTotalMoney(?Money totalMoney): void |
| `totalTaxMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalTaxMoney(): ?Money | setTotalTaxMoney(?Money totalTaxMoney): void |
| `calculationPhase` | [`?string (OrderServiceChargeCalculationPhase)`](../../doc/models/order-service-charge-calculation-phase.md) | Optional | Represents a phase in the process of calculating order totals.<br>Service charges are applied after the indicated phase.<br><br>[Read more about how order totals are calculated.](https://developer.squareup.com/docs/orders-api/how-it-works#how-totals-are-calculated) | getCalculationPhase(): ?string | setCalculationPhase(?string calculationPhase): void |
| `taxable` | `?bool` | Optional | Indicates whether the surcharge can be taxed. Service charges<br>calculated in the `TOTAL_PHASE` cannot be marked as taxable. | getTaxable(): ?bool | setTaxable(?bool taxable): void |
| `appliedTaxes` | [`?(OrderLineItemAppliedTax[])`](../../doc/models/order-line-item-applied-tax.md) | Optional | The list of references to `OrderReturnTax` entities applied to the<br>`OrderReturnServiceCharge`. Each `OrderLineItemAppliedTax` has a `tax_uid`<br>that references the `uid` of a top-level `OrderReturnTax` that is being<br>applied to the `OrderReturnServiceCharge`. On reads, the applied amount is<br>populated. | getAppliedTaxes(): ?array | setAppliedTaxes(?array appliedTaxes): void |
| `treatmentType` | [`?string (OrderServiceChargeTreatmentType)`](../../doc/models/order-service-charge-treatment-type.md) | Optional | Indicates whether the service charge will be treated as a value-holding line item or<br>apportioned toward a line item. | getTreatmentType(): ?string | setTreatmentType(?string treatmentType): void |
| `scope` | [`?string (OrderServiceChargeScope)`](../../doc/models/order-service-charge-scope.md) | Optional | Indicates whether this is a line-item or order-level apportioned<br>service charge. | getScope(): ?string | setScope(?string scope): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "source_service_charge_uid": "source_service_charge_uid6",
  "name": "name0",
  "catalog_object_id": "catalog_object_id6",
  "catalog_version": 126,
  "percentage": "percentage8",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "applied_money": {
    "amount": 196,
    "currency": "PLN"
  },
  "total_money": {
    "amount": 250,
    "currency": "UNKNOWN_CURRENCY"
  },
  "total_tax_money": {
    "amount": 58,
    "currency": "SDG"
  },
  "calculation_phase": "APPORTIONED_PERCENTAGE_PHASE",
  "taxable": false,
  "applied_taxes": [
    {
      "uid": "uid0",
      "tax_uid": "tax_uid4",
      "applied_money": {
        "amount": 190,
        "currency": "XAF"
      }
    },
    {
      "uid": "uid1",
      "tax_uid": "tax_uid3",
      "applied_money": {
        "amount": 189,
        "currency": "WST"
      }
    }
  ],
  "treatment_type": "LINE_ITEM_TREATMENT",
  "scope": "ORDER"
}
```

