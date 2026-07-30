
# Bulk Update Vendors Request

Represents an input to a call to [BulkUpdateVendors](../../doc/apis/vendors.md#bulk-update-vendors).

## Structure

`BulkUpdateVendorsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `vendors` | [`array<string,UpdateVendorRequest>`](../../doc/models/update-vendor-request.md) | Required | A set of [UpdateVendorRequest](entity:UpdateVendorRequest) objects encapsulating to-be-updated [Vendor](entity:Vendor)<br>objects. The set is represented by  a collection of `Vendor`-ID/`UpdateVendorRequest`-object pairs. | getVendors(): array | setVendors(array vendors): void |

## Example (as JSON)

```json
{
  "vendors": {
    "key0": {
      "idempotency_key": "idempotency_key5",
      "vendor": {
        "id": "id5",
        "created_at": "created_at3",
        "updated_at": "updated_at1",
        "name": "name5",
        "address": {
          "address_line_1": "address_line_11",
          "address_line_2": "address_line_21",
          "address_line_3": "address_line_37",
          "locality": "locality1",
          "sublocality": "sublocality1",
          "sublocality_2": "sublocality_29",
          "sublocality_3": "sublocality_31",
          "administrative_district_level_1": "administrative_district_level_15",
          "administrative_district_level_2": "administrative_district_level_27",
          "administrative_district_level_3": "administrative_district_level_39",
          "postal_code": "postal_code3",
          "country": "YE",
          "first_name": "first_name1",
          "last_name": "last_name9"
        },
        "contacts": [
          {
            "id": "id2",
            "name": "name2",
            "email_address": "email_address0",
            "phone_number": "phone_number0",
            "removed": false,
            "ordinal": 224
          },
          {
            "id": "id3",
            "name": "name3",
            "email_address": "email_address1",
            "phone_number": "phone_number1",
            "removed": true,
            "ordinal": 225
          }
        ],
        "account_number": "account_number5",
        "note": "note1",
        "version": 33,
        "status": "INACTIVE"
      }
    },
    "key1": {
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
          "country": "YT",
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
            "ordinal": 225
          },
          {
            "id": "id4",
            "name": "name4",
            "email_address": "email_address2",
            "phone_number": "phone_number2",
            "removed": false,
            "ordinal": 226
          },
          {
            "id": "id5",
            "name": "name5",
            "email_address": "email_address3",
            "phone_number": "phone_number3",
            "removed": true,
            "ordinal": 227
          }
        ],
        "account_number": "account_number6",
        "note": "note2",
        "version": 34,
        "status": "ACTIVE"
      }
    },
    "key2": {
      "idempotency_key": "idempotency_key7",
      "vendor": {
        "id": "id7",
        "created_at": "created_at5",
        "updated_at": "updated_at3",
        "name": "name7",
        "address": {
          "address_line_1": "address_line_13",
          "address_line_2": "address_line_23",
          "address_line_3": "address_line_39",
          "locality": "locality3",
          "sublocality": "sublocality3",
          "sublocality_2": "sublocality_21",
          "sublocality_3": "sublocality_33",
          "administrative_district_level_1": "administrative_district_level_17",
          "administrative_district_level_2": "administrative_district_level_29",
          "administrative_district_level_3": "administrative_district_level_31",
          "postal_code": "postal_code5",
          "country": "ZA",
          "first_name": "first_name3",
          "last_name": "last_name1"
        },
        "contacts": [
          {
            "id": "id4",
            "name": "name4",
            "email_address": "email_address2",
            "phone_number": "phone_number2",
            "removed": false,
            "ordinal": 226
          }
        ],
        "account_number": "account_number7",
        "note": "note3",
        "version": 35,
        "status": "INACTIVE"
      }
    }
  }
}
```

