
# Customer Group

Represents a group of customer profiles.

Customer groups can be created, be modified, and have their membership defined using
the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale.

## Structure

`CustomerGroup`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique Square-generated ID for the customer group.<br>**Constraints**: *Maximum Length*: `255` | getId(): ?string | setId(?string id): void |
| `name` | `string` | Required | The name of the customer group. | getName(): string | setName(string name): void |
| `createdAt` | `?string` | Optional | The timestamp when the customer group was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp when the customer group was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "name": "name0",
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

