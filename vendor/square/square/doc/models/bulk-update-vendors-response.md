
# Bulk Update Vendors Response

Represents an output from a call to [BulkUpdateVendors](../../doc/apis/vendors.md#bulk-update-vendors).

## Structure

`BulkUpdateVendorsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered when the request fails. | getErrors(): ?array | setErrors(?array errors): void |
| `responses` | [`?array<string,UpdateVendorResponse>`](../../doc/models/update-vendor-response.md) | Optional | A set of [UpdateVendorResponse](entity:UpdateVendorResponse) objects encapsulating successfully created [Vendor](entity:Vendor)<br>objects or error responses for failed attempts. The set is represented by a collection of `Vendor`-ID/`UpdateVendorResponse`-object or<br>`Vendor`-ID/error-object pairs. | getResponses(): ?array | setResponses(?array responses): void |

## Example (as JSON)

```json
{
  "vendors": {
    "INV_V_FMCYHBWT1TPL8MFH52PBMEN92A": {
      "address": {
        "address_line_1": "202 Mill St",
        "administrative_district_level_1": "NJ",
        "country": "US",
        "locality": "Moorestown",
        "postal_code": "08057"
      },
      "contacts": [
        {
          "email_address": "annie@annieshotsauce.com",
          "id": "INV_VC_ABYYHBWT1TPL8MFH52PBMENPJ4",
          "name": "Annie Thomas",
          "ordinal": 0,
          "phone_number": "1-212-555-4250"
        }
      ],
      "created_at": "2022-03-16T10:21:54.859Z",
      "id": "INV_V_FMCYHBWT1TPL8MFH52PBMEN92A",
      "name": "Annie’s Hot Sauce",
      "status": "ACTIVE",
      "updated_at": "2022-03-16T20:21:54.859Z",
      "version": 11
    },
    "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4": {
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
      "created_at": "2022-03-16T10:10:54.859Z",
      "id": "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4",
      "name": "Joe's Fresh Seafood",
      "note": "favorite vendor",
      "status": "ACTIVE",
      "updated_at": "2022-03-16T20:21:54.859Z",
      "version": 31
    }
  }
}
```

