
# Order Line Item Pricing Blocklists Blocked Tax

A tax to block from applying to a line item. The tax must be
identified by either `tax_uid` or `tax_catalog_object_id`, but not both.

## Structure

`OrderLineItemPricingBlocklistsBlockedTax`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID of the `BlockedTax` within the order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `taxUid` | `?string` | Optional | The `uid` of the tax that should be blocked. Use this field to block<br>ad hoc taxes. For catalog, taxes use the `tax_catalog_object_id` field.<br>**Constraints**: *Maximum Length*: `60` | getTaxUid(): ?string | setTaxUid(?string taxUid): void |
| `taxCatalogObjectId` | `?string` | Optional | The `catalog_object_id` of the tax that should be blocked.<br>Use this field to block catalog taxes. For ad hoc taxes, use the<br>`tax_uid` field.<br>**Constraints**: *Maximum Length*: `192` | getTaxCatalogObjectId(): ?string | setTaxCatalogObjectId(?string taxCatalogObjectId): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "tax_uid": "tax_uid4",
  "tax_catalog_object_id": "tax_catalog_object_id4"
}
```

