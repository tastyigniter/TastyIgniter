
# Bulk Retrieve Vendors Response

Represents an output from a call to [BulkRetrieveVendors](../../doc/apis/vendors.md#bulk-retrieve-vendors).

## Structure

`BulkRetrieveVendorsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `responses` | [`?array<string,RetrieveVendorResponse>`](../../doc/models/retrieve-vendor-response.md) | Optional | The set of [RetrieveVendorResponse](entity:RetrieveVendorResponse) objects encapsulating successfully retrieved [Vendor](entity:Vendor)<br>objects or error responses for failed attempts. The set is represented by<br>a collection of `Vendor`-ID/`Vendor`-object or `Vendor`-ID/error-object pairs. | getResponses(): ?array | setResponses(?array responses): void |

## Example (as JSON)

```json
{
  "errors": [],
  "vendors": {
    "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4": {
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
            "phone_number": "1-212-555-4250"
          }
        ],
        "created_at": "2022-03-16T10:21:54.859Z",
        "id": "INV_V_JDKYHBWT1D4F8MFH63DBMEN8Y4",
        "name": "Joe's Fresh Seafood",
        "note": "a vendor",
        "status": "ACTIVE",
        "updated_at": "2022-03-16T10:21:54.859Z",
        "version": 1
      }
    }
  }
}
```

