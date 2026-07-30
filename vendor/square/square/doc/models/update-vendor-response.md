
# Update Vendor Response

Represents an output from a call to [UpdateVendor](../../doc/apis/vendors.md#update-vendor).

## Structure

`UpdateVendorResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors occurred when the request fails. | getErrors(): ?array | setErrors(?array errors): void |
| `vendor` | [`?Vendor`](../../doc/models/vendor.md) | Optional | Represents a supplier to a seller. | getVendor(): ?Vendor | setVendor(?Vendor vendor): void |

## Example (as JSON)

```json
{
  "errors": [],
  "vendor": {
    "account_number": "4025391",
    "address": {
      "address_line_1": "505 Electric Ave",
      "address_line_2": "Suite 600",
      "administrative_district_level_1": "NY",
      "country": "US",
      "locality": "New York",
      "postal_code": "10003"
    },
    "contacts": [
      {
        "email_address": "joe@joesfreshseafood.com",
        "id": "INV_VC_FMCYHBWT1TPL8MFH52PBMEN92A",
        "name": "Joe Burrow",
        "ordinal": 0,
        "phone_number": "1-212-555-4250"
      }
    ],
    "created_at": "2022-03-16T10:21:54.859Z",
    "id": "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4",
    "name": "Jack's Chicken Shack",
    "status": "ACTIVE",
    "updated_at": "2022-03-16T20:21:54.859Z",
    "version": 2
  }
}
```

