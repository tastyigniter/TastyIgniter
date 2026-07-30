
# Create Customer Group Request

Defines the body parameters that can be included in a request to the
[CreateCustomerGroup](../../doc/apis/customer-groups.md#create-customer-group) endpoint.

## Structure

`CreateCustomerGroupRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | The idempotency key for the request. For more information, see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency). | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `group` | [`CustomerGroup`](../../doc/models/customer-group.md) | Required | Represents a group of customer profiles.<br><br>Customer groups can be created, be modified, and have their membership defined using<br>the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale. | getGroup(): CustomerGroup | setGroup(CustomerGroup group): void |

## Example (as JSON)

```json
{
  "group": {
    "name": "Loyal Customers"
  }
}
```

