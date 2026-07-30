
# Order Service Charge Scope

Indicates whether this is a line-item or order-level apportioned
service charge.

## Enumeration

`OrderServiceChargeScope`

## Fields

| Name | Description |
|  --- | --- |
| `OTHER_SERVICE_CHARGE_SCOPE` | Used for reporting only.<br>The original transaction service charge scope is currently not supported by the API. |
| `LINE_ITEM` | The service charge should be applied to only line items specified by<br>`OrderLineItemAppliedServiceCharge` reference records. |
| `ORDER` | The service charge should be applied to the entire order. |

