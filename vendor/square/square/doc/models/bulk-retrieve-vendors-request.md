
# Bulk Retrieve Vendors Request

Represents an input to a call to [BulkRetrieveVendors](../../doc/apis/vendors.md#bulk-retrieve-vendors).

## Structure

`BulkRetrieveVendorsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `vendorIds` | `?(string[])` | Optional | IDs of the [Vendor](entity:Vendor) objects to retrieve. | getVendorIds(): ?array | setVendorIds(?array vendorIds): void |

## Example (as JSON)

```json
{
  "vendor_ids": [
    "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4"
  ]
}
```

