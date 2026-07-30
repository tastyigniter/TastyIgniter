
# Customer Query

Represents filtering and sorting criteria for a [SearchCustomers](../../doc/apis/customers.md#search-customers) request.

## Structure

`CustomerQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?CustomerFilter`](../../doc/models/customer-filter.md) | Optional | Represents the filtering criteria in a [search query](../../doc/models/customer-query.md) that defines how to filter<br>customer profiles returned in [SearchCustomers](../../doc/apis/customers.md#search-customers) results. | getFilter(): ?CustomerFilter | setFilter(?CustomerFilter filter): void |
| `sort` | [`?CustomerSort`](../../doc/models/customer-sort.md) | Optional | Represents the sorting criteria in a [search query](../../doc/models/customer-query.md) that defines how to sort<br>customer profiles returned in [SearchCustomers](../../doc/apis/customers.md#search-customers) results. | getSort(): ?CustomerSort | setSort(?CustomerSort sort): void |

## Example (as JSON)

```json
{
  "filter": {
    "creation_source": {
      "values": [
        "INVOICES",
        "LOYALTY",
        "MARKETING"
      ],
      "rule": "INCLUDE"
    },
    "created_at": {
      "start_at": "start_at4",
      "end_at": "end_at8"
    },
    "updated_at": {
      "start_at": "start_at2",
      "end_at": "end_at0"
    },
    "email_address": {
      "exact": "exact2",
      "fuzzy": "fuzzy2"
    },
    "phone_number": {
      "exact": "exact8",
      "fuzzy": "fuzzy6"
    },
    "reference_id": {},
    "group_ids": {
      "all": [
        "all9",
        "all0",
        "all1"
      ],
      "any": [
        "any8",
        "any9",
        "any0"
      ],
      "none": [
        "none3",
        "none4"
      ]
    },
    "custom_attribute": {
      "filters": [
        {
          "key": "key8",
          "filter": {
            "email": {},
            "phone": {},
            "text": {},
            "selection": {
              "all": [
                "all7",
                "all6"
              ],
              "any": [
                "any4"
              ],
              "none": [
                "none9",
                "none0",
                "none1"
              ]
            },
            "date": {},
            "number": {
              "start_at": "start_at8",
              "end_at": "end_at4"
            },
            "boolean": false,
            "address": {
              "postal_code": {},
              "country": "CZ"
            }
          },
          "updated_at": {}
        },
        {
          "key": "key9",
          "filter": {
            "email": {},
            "phone": {},
            "text": {},
            "selection": {
              "all": [
                "all6",
                "all5",
                "all4"
              ],
              "any": [
                "any3",
                "any4",
                "any5"
              ],
              "none": [
                "none8",
                "none9"
              ]
            },
            "date": {},
            "number": {
              "start_at": "start_at9",
              "end_at": "end_at3"
            },
            "boolean": true,
            "address": {
              "postal_code": {},
              "country": "CY"
            }
          },
          "updated_at": {}
        }
      ]
    },
    "segment_ids": {}
  },
  "sort": {
    "field": "DEFAULT",
    "order": "DESC"
  }
}
```

