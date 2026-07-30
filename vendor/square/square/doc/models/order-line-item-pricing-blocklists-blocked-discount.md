
# Order Line Item Pricing Blocklists Blocked Discount

A discount to block from applying to a line item. The discount must be
identified by either `discount_uid` or `discount_catalog_object_id`, but not both.

## Structure

`OrderLineItemPricingBlocklistsBlockedDiscount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID of the `BlockedDiscount` within the order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `discountUid` | `?string` | Optional | The `uid` of the discount that should be blocked. Use this field to block<br>ad hoc discounts. For catalog discounts, use the `discount_catalog_object_id` field.<br>**Constraints**: *Maximum Length*: `60` | getDiscountUid(): ?string | setDiscountUid(?string discountUid): void |
| `discountCatalogObjectId` | `?string` | Optional | The `catalog_object_id` of the discount that should be blocked.<br>Use this field to block catalog discounts. For ad hoc discounts, use the<br>`discount_uid` field.<br>**Constraints**: *Maximum Length*: `192` | getDiscountCatalogObjectId(): ?string | setDiscountCatalogObjectId(?string discountCatalogObjectId): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "discount_uid": "discount_uid4",
  "discount_catalog_object_id": "discount_catalog_object_id2"
}
```

