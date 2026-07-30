
# Update Vendor Request

Represents an input to a call to [UpdateVendor](../../doc/apis/vendors.md#update-vendor).

## Structure

`UpdateVendorRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A client-supplied, universally unique identifier (UUID) for the<br>request.<br><br>See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) in the<br>[API Development 101](https://developer.squareup.com/docs/buildbasics) section for more<br>information.<br>**Constraints**: *Maximum Length*: `128` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `vendor` | [`Vendor`](../../doc/models/vendor.md) | Required | Represents a supplier to a seller. | getVendor(): Vendor | setVendor(Vendor vendor): void |

## Example (as JSON)

```json
{
  "idempotency_key": "8fc6a5b0-9fe8-4b46-b46b-2ef95793abbe",
  "vendor": {
    "id": "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4",
    "name": "Jack's Chicken Shack",
    "status": "ACTIVE",
    "version": 1
  }
}
```

