
# Order Service Charge

Represents a service charge applied to an order.

## Structure

`OrderServiceCharge`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the service charge only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `name` | `?string` | Optional | The name of the service charge.<br>**Constraints**: *Maximum Length*: `512` | getName(): ?string | setName(?string name): void |
| `catalogObjectId` | `?string` | Optional | The catalog object ID referencing the service charge [CatalogObject](entity:CatalogObject).<br>**Constraints**: *Maximum Length*: `192` | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `catalogVersion` | `?int` | Optional | The version of the catalog object that this service charge references. | getCatalogVersion(): ?int | setCatalogVersion(?int catalogVersion): void |
| `percentage` | `?string` | Optional | The service charge percentage as a string representation of a<br>decimal number. For example, `"7.25"` indicates a service charge of 7.25%.<br><br>Exactly 1 of `percentage` or `amount_money` should be set.<br>**Constraints**: *Maximum Length*: `10` | getPercentage(): ?string | setPercentage(?string percentage): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `appliedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppliedMoney(): ?Money | setAppliedMoney(?Money appliedMoney): void |
| `totalMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalMoney(): ?Money | setTotalMoney(?Money totalMoney): void |
| `totalTaxMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalTaxMoney(): ?Money | setTotalTaxMoney(?Money totalTaxMoney): void |
| `calculationPhase` | [`?string (OrderServiceChargeCalculationPhase)`](../../doc/models/order-service-charge-calculation-phase.md) | Optional | Represents a phase in the process of calculating order totals.<br>Service charges are applied after the indicated phase.<br><br>[Read more about how order totals are calculated.](https://developer.squareup.com/docs/orders-api/how-it-works#how-totals-are-calculated) | getCalculationPhase(): ?string | setCalculationPhase(?string calculationPhase): void |
| `taxable` | `?bool` | Optional | Indicates whether the service charge can be taxed. If set to `true`,<br>order-level taxes automatically apply to the service charge. Note that<br>service charges calculated in the `TOTAL_PHASE` cannot be marked as taxable. | getTaxable(): ?bool | setTaxable(?bool taxable): void |
| `appliedTaxes` | [`?(OrderLineItemAppliedTax[])`](../../doc/models/order-line-item-applied-tax.md) | Optional | The list of references to the taxes applied to this service charge. Each<br>`OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level<br>`OrderLineItemTax` that is being applied to this service charge. On reads, the amount applied<br>is populated.<br><br>An `OrderLineItemAppliedTax` is automatically created on every taxable service charge<br>for all `ORDER` scoped taxes that are added to the order. `OrderLineItemAppliedTax` records<br>for `LINE_ITEM` scoped taxes must be added in requests for the tax to apply to any taxable<br>service charge. Taxable service charges have the `taxable` field set to `true` and calculated<br>in the `SUBTOTAL_PHASE`.<br><br>To change the amount of a tax, modify the referenced top-level tax. | getAppliedTaxes(): ?array | setAppliedTaxes(?array appliedTaxes): void |
| `metadata` | `?array<string,string>` | Optional | Application-defined data attached to this service charge. Metadata fields are intended<br>to store descriptive references or associations with an entity in another system or store brief<br>information about the object. Square does not process this field; it only stores and returns it<br>in relevant API calls. Do not use metadata to store any sensitive information (such as personally<br>identifiable information or card details).<br><br>Keys written by applications must be 60 characters or less and must be in the character set<br>`[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed<br>with a namespace, separated from the key with a ':' character.<br><br>Values have a maximum length of 255 characters.<br><br>An application can have up to 10 entries per metadata field.<br><br>Entries written by applications are private and can only be read or modified by the same<br>application.<br><br>For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata). | getMetadata(): ?array | setMetadata(?array metadata): void |
| `type` | [`?string (OrderServiceChargeType)`](../../doc/models/order-service-charge-type.md) | Optional | - | getType(): ?string | setType(?string type): void |
| `treatmentType` | [`?string (OrderServiceChargeTreatmentType)`](../../doc/models/order-service-charge-treatment-type.md) | Optional | Indicates whether the service charge will be treated as a value-holding line item or<br>apportioned toward a line item. | getTreatmentType(): ?string | setTreatmentType(?string treatmentType): void |
| `scope` | [`?string (OrderServiceChargeScope)`](../../doc/models/order-service-charge-scope.md) | Optional | Indicates whether this is a line-item or order-level apportioned<br>service charge. | getScope(): ?string | setScope(?string scope): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
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
  "metadata": {
    "key0": "metadata3",
    "key1": "metadata4",
    "key2": "metadata5"
  },
  "type": "AUTO_GRATUITY",
  "treatment_type": "LINE_ITEM_TREATMENT",
  "scope": "ORDER"
}
```

