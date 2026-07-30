
# Create Vendor Response

Represents an output from a call to [CreateVendor](../../doc/apis/vendors.md#create-vendor).

## Structure

`CreateVendorResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered when the request fails. | getErrors(): ?array | setErrors(?array errors): void |
| `vendor` | [`?Vendor`](../../doc/models/vendor.md) | Optional | Represents a supplier to a seller. | getVendor(): ?Vendor | setVendor(?Vendor vendor): void |

## Example (as JSON)

```json
{
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ],
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

