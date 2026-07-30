
# Customer Filter

Represents the filtering criteria in a [search query](../../doc/models/customer-query.md) that defines how to filter
customer profiles returned in [SearchCustomers](../../doc/apis/customers.md#search-customers) results.

## Structure

`CustomerFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `creationSource` | [`?CustomerCreationSourceFilter`](../../doc/models/customer-creation-source-filter.md) | Optional | The creation source filter.<br><br>If one or more creation sources are set, customer profiles are included in,<br>or excluded from, the result if they match at least one of the filter criteria. | getCreationSource(): ?CustomerCreationSourceFilter | setCreationSource(?CustomerCreationSourceFilter creationSource): void |
| `createdAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getCreatedAt(): ?TimeRange | setCreatedAt(?TimeRange createdAt): void |
| `updatedAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getUpdatedAt(): ?TimeRange | setUpdatedAt(?TimeRange updatedAt): void |
| `emailAddress` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getEmailAddress(): ?CustomerTextFilter | setEmailAddress(?CustomerTextFilter emailAddress): void |
| `phoneNumber` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getPhoneNumber(): ?CustomerTextFilter | setPhoneNumber(?CustomerTextFilter phoneNumber): void |
| `referenceId` | [`?CustomerTextFilter`](../../doc/models/customer-text-filter.md) | Optional | A filter to select customers based on exact or fuzzy matching of<br>customer attributes against a specified query. Depending on the customer attributes,<br>the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both. | getReferenceId(): ?CustomerTextFilter | setReferenceId(?CustomerTextFilter referenceId): void |
| `groupIds` | [`?FilterValue`](../../doc/models/filter-value.md) | Optional | A filter to select resources based on an exact field value. For any given<br>value, the value can only be in one property. Depending on the field, either<br>all properties can be set or only a subset will be available.<br><br>Refer to the documentation of the field. | getGroupIds(): ?FilterValue | setGroupIds(?FilterValue groupIds): void |
| `customAttribute` | [`?CustomerCustomAttributeFilters`](../../doc/models/customer-custom-attribute-filters.md) | Optional | The custom attribute filters in a set of [customer filters](../../doc/models/customer-filter.md) used in a search query. Use this filter<br>to search based on [custom attributes](../../doc/models/custom-attribute.md) that are assigned to customer profiles. For more information, see<br>[Search by custom attribute](https://developer.squareup.com/docs/customers-api/use-the-api/search-customers#search-by-custom-attribute). | getCustomAttribute(): ?CustomerCustomAttributeFilters | setCustomAttribute(?CustomerCustomAttributeFilters customAttribute): void |
| `segmentIds` | [`?FilterValue`](../../doc/models/filter-value.md) | Optional | A filter to select resources based on an exact field value. For any given<br>value, the value can only be in one property. Depending on the field, either<br>all properties can be set or only a subset will be available.<br><br>Refer to the documentation of the field. | getSegmentIds(): ?FilterValue | setSegmentIds(?FilterValue segmentIds): void |

## Example (as JSON)

```json
{
  "creation_source": {
    "values": [
      "THIRD_PARTY_IMPORT",
      "THIRD_PARTY",
      "TERMINAL"
    ],
    "rule": "INCLUDE"
  },
  "created_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  },
  "updated_at": {
    "start_at": "start_at6",
    "end_at": "end_at6"
  },
  "email_address": {
    "exact": "exact2",
    "fuzzy": "fuzzy8"
  },
  "phone_number": {
    "exact": "exact2",
    "fuzzy": "fuzzy8"
  },
  "reference_id": {
    "exact": "exact2",
    "fuzzy": "fuzzy8"
  },
  "group_ids": {
    "all": [
      "all5",
      "all4",
      "all3"
    ],
    "any": [
      "any2",
      "any3",
      "any4"
    ],
    "none": [
      "none7",
      "none8"
    ]
  },
  "custom_attribute": {
    "filters": [
      {
        "key": "key8",
        "filter": {
          "email": {
            "exact": "exact0",
            "fuzzy": "fuzzy6"
          },
          "phone": {
            "exact": "exact4",
            "fuzzy": "fuzzy0"
          },
          "text": {},
          "selection": {
            "all": [
              "all5",
              "all4"
            ],
            "any": [
              "any4",
              "any5",
              "any6"
            ],
            "none": [
              "none9",
              "none0"
            ]
          },
          "date": {
            "start_at": "start_at0",
            "end_at": "end_at2"
          },
          "number": {
            "start_at": "start_at8",
            "end_at": "end_at4"
          },
          "boolean": false,
          "address": {
            "postal_code": {},
            "country": "VA"
          }
        },
        "updated_at": {
          "start_at": "start_at8",
          "end_at": "end_at4"
        }
      },
      {
        "key": "key9",
        "filter": {
          "email": {
            "exact": "exact1",
            "fuzzy": "fuzzy7"
          },
          "phone": {
            "exact": "exact5",
            "fuzzy": "fuzzy1"
          },
          "text": {},
          "selection": {
            "all": [
              "all6"
            ],
            "any": [
              "any3",
              "any4"
            ],
            "none": [
              "none8"
            ]
          },
          "date": {
            "start_at": "start_at1",
            "end_at": "end_at1"
          },
          "number": {
            "start_at": "start_at9",
            "end_at": "end_at3"
          },
          "boolean": true,
          "address": {
            "postal_code": {},
            "country": "UZ"
          }
        },
        "updated_at": {
          "start_at": "start_at7",
          "end_at": "end_at5"
        }
      },
      {
        "key": "key0",
        "filter": {
          "email": {
            "exact": "exact2",
            "fuzzy": "fuzzy8"
          },
          "phone": {
            "exact": "exact6",
            "fuzzy": "fuzzy2"
          },
          "text": {},
          "selection": {
            "all": [
              "all7",
              "all6",
              "all5"
            ],
            "any": [
              "any2"
            ],
            "none": [
              "none7",
              "none8",
              "none9"
            ]
          },
          "date": {
            "start_at": "start_at2",
            "end_at": "end_at0"
          },
          "number": {
            "start_at": "start_at0",
            "end_at": "end_at2"
          },
          "boolean": false,
          "address": {
            "postal_code": {},
            "country": "UY"
          }
        },
        "updated_at": {
          "start_at": "start_at6",
          "end_at": "end_at6"
        }
      }
    ]
  },
  "segment_ids": {
    "all": [
      "all9",
      "all8",
      "all7"
    ],
    "any": [
      "any6",
      "any7",
      "any8"
    ],
    "none": [
      "none1",
      "none2"
    ]
  }
}
```

