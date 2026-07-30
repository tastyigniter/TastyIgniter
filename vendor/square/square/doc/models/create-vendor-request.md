
# Create Vendor Request

Represents an input to a call to [CreateVendor](../../doc/apis/vendors.md#create-vendor).

## Structure

`CreateVendorRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A client-supplied, universally unique identifier (UUID) to make this [CreateVendor](api-endpoint:Vendors-CreateVendor) call idempotent.<br><br>See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) in the<br>[API Development 101](https://developer.squareup.com/docs/buildbasics) section for more<br>information.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `128` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `vendor` | [`?Vendor`](../../doc/models/vendor.md) | Optional | Represents a supplier to a seller. | getVendor(): ?Vendor | setVendor(?Vendor vendor): void |

## Example (as JSON)

```json
{
  "idempotency_key": "idempotency_key6",
  "vendor": {
    "id": "id6",
    "created_at": "created_at4",
    "updated_at": "updated_at2",
    "name": "name6",
    "address": {
      "address_line_1": "address_line_12",
      "address_line_2": "address_line_22",
      "address_line_3": "address_line_38",
      "locality": "locality2",
      "sublocality": "sublocality2",
      "sublocality_2": "sublocality_20",
      "sublocality_3": "sublocality_32",
      "administrative_district_level_1": "administrative_district_level_16",
      "administrative_district_level_2": "administrative_district_level_28",
      "administrative_district_level_3": "administrative_district_level_30",
      "postal_code": "postal_code4",
      "country": "NL",
      "first_name": "first_name2",
      "last_name": "last_name0"
    },
    "contacts": [
      {
        "id": "id3",
        "name": "name3",
        "email_address": "email_address1",
        "phone_number": "phone_number1",
        "removed": true,
        "ordinal": 11
      }
    ],
    "account_number": "account_number6",
    "note": "note2",
    "version": 76,
    "status": "ACTIVE"
  }
}
```

