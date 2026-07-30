
# Order State

The state of the order.

## Enumeration

`OrderState`

## Fields

| Name | Description |
|  --- | --- |
| `OPEN` | Indicates that the order is open. Open orders can be updated. |
| `COMPLETED` | Indicates that the order is completed. Completed orders are fully paid. This is a terminal state. |
| `CANCELED` | Indicates that the order is canceled. Canceled orders are not paid. This is a terminal state. |
| `DRAFT` | Indicates that the order is in a draft state. Draft orders can be updated,<br>but cannot be paid or fulfilled.<br>For more information, see [Create Orders](https://developer.squareup.com/docs/orders-api/create-orders). |

