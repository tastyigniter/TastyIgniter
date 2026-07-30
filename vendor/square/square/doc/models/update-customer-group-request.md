
# Update Customer Group Request

Defines the body parameters that can be included in a request to the
[UpdateCustomerGroup](../../doc/apis/customer-groups.md#update-customer-group) endpoint.

## Structure

`UpdateCustomerGroupRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `group` | [`CustomerGroup`](../../doc/models/customer-group.md) | Required | Represents a group of customer profiles.<br><br>Customer groups can be created, be modified, and have their membership defined using<br>the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale. | getGroup(): CustomerGroup | setGroup(CustomerGroup group): void |

## Example (as JSON)

```json
{
  "group": {
    "name": "Loyal Customers"
  }
}
```

