
# Clone Order Response

Defines the fields that are included in the response body of
a request to the [CloneOrder](../../doc/apis/orders.md#clone-order) endpoint.

## Structure

`CloneOrderResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `order` | [`?Order`](../../doc/models/order.md) | Optional | Contains all information related to a single order to process with Square,<br>including line items that specify the products to purchase. `Order` objects also<br>include information about any associated tenders, refunds, and returns.<br><br>All Connect V2 Transactions have all been converted to Orders including all associated<br>itemization data. | getOrder(): ?Order | setOrder(?Order order): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "order": {
    "created_at": "2020-01-17T20:47:53.293Z",
    "discounts": [
      {
        "applied_money": {
          "amount": 30,
          "currency": "USD"
        },
        "catalog_object_id": "DB7L55ZH2BGWI4H23ULIWOQ7",
        "name": "Membership Discount",
        "percentage": "0.5",
        "scope": "ORDER",
        "type": "FIXED_PERCENTAGE",
        "uid": "membership-discount"
      },
      {
        "applied_money": {
          "amount": 303,
          "currency": "USD"
        },
        "name": "Labor Day Sale",
        "percentage": "5",
        "scope": "ORDER",
        "type": "FIXED_PERCENTAGE",
        "uid": "labor-day-sale"
      },
      {
        "amount_money": {
          "amount": 100,
          "currency": "USD"
        },
        "applied_money": {
          "amount": 100,
          "currency": "USD"
        },
        "name": "Sale - $1.00 off",
        "scope": "LINE_ITEM",
        "type": "FIXED_AMOUNT",
        "uid": "one-dollar-off"
      }
    ],
    "id": "CAISENgvlJ6jLWAzERDzjyHVybY",
    "line_items": [
      {
        "applied_discounts": [
          {
            "applied_money": {
              "amount": 8,
              "currency": "USD"
            },
            "discount_uid": "membership-discount",
            "uid": "jWdgP1TpHPFBuVrz81mXVC"
          },
          {
            "applied_money": {
              "amount": 79,
              "currency": "USD"
            },
            "discount_uid": "labor-day-sale",
            "uid": "jnZOjjVY57eRcQAVgEwFuC"
          }
        ],
        "applied_taxes": [
          {
            "applied_money": {
              "amount": 136,
              "currency": "USD"
            },
            "tax_uid": "state-sales-tax",
            "uid": "aKG87ArnDpvMLSZJHxWUl"
          }
        ],
        "base_price_money": {
          "amount": 1599,
          "currency": "USD"
        },
        "gross_sales_money": {
          "amount": 1599,
          "currency": "USD"
        },
        "name": "New York Strip Steak",
        "quantity": "1",
        "total_discount_money": {
          "amount": 87,
          "currency": "USD"
        },
        "total_money": {
          "amount": 1648,
          "currency": "USD"
        },
        "total_service_charge_money": {
          "amount": 0,
          "currency": "USD"
        },
        "total_tax_money": {
          "amount": 136,
          "currency": "USD"
        },
        "uid": "8uSwfzvUImn3IRrvciqlXC",
        "variation_total_price_money": {
          "amount": 1599,
          "currency": "USD"
        }
      },
      {
        "applied_discounts": [
          {
            "applied_money": {
              "amount": 22,
              "currency": "USD"
            },
            "discount_uid": "membership-discount",
            "uid": "nUXvdsIItfKko0dbYtY58C"
          },
          {
            "applied_money": {
              "amount": 224,
              "currency": "USD"
            },
            "discount_uid": "labor-day-sale",
            "uid": "qSdkOOOernlVQqsJ94SPjB"
          },
          {
            "applied_money": {
              "amount": 100,
              "currency": "USD"
            },
            "discount_uid": "one-dollar-off",
            "uid": "y7bVl4njrWAnfDwmz19izB"
          }
        ],
        "applied_taxes": [
          {
            "applied_money": {
              "amount": 374,
              "currency": "USD"
            },
            "tax_uid": "state-sales-tax",
            "uid": "v1dAgrfUVUPTnVTf9sRPz"
          }
        ],
        "base_price_money": {
          "amount": 2200,
          "currency": "USD"
        },
        "catalog_object_id": "BEMYCSMIJL46OCDV4KYIKXIB",
        "gross_sales_money": {
          "amount": 4500,
          "currency": "USD"
        },
        "modifiers": [
          {
            "base_price_money": {
              "amount": 50,
              "currency": "USD"
            },
            "catalog_object_id": "CHQX7Y4KY6N5KINJKZCFURPZ",
            "name": "Well",
            "total_price_money": {
              "amount": 100,
              "currency": "USD"
            },
            "uid": "Lo3qMMckDluu9Qsb58d4CC"
          }
        ],
        "name": "New York Steak",
        "quantity": "2",
        "total_discount_money": {
          "amount": 346,
          "currency": "USD"
        },
        "total_money": {
          "amount": 4528,
          "currency": "USD"
        },
        "total_service_charge_money": {
          "amount": 0,
          "currency": "USD"
        },
        "total_tax_money": {
          "amount": 374,
          "currency": "USD"
        },
        "uid": "v8ZuEXpOJpb0bazLuvrLDB",
        "variation_name": "Larger",
        "variation_total_price_money": {
          "amount": 4400,
          "currency": "USD"
        }
      }
    ],
    "location_id": "057P5VYJ4A5X1",
    "net_amounts": {
      "discount_money": {
        "amount": 433,
        "currency": "USD"
      },
      "service_charge_money": {
        "amount": 0,
        "currency": "USD"
      },
      "tax_money": {
        "amount": 510,
        "currency": "USD"
      },
      "tip_money": {
        "amount": 0,
        "currency": "USD"
      },
      "total_money": {
        "amount": 6176,
        "currency": "USD"
      }
    },
    "reference_id": "my-order-001",
    "source": {
      "name": "My App"
    },
    "state": "DRAFT",
    "taxes": [
      {
        "applied_money": {
          "amount": 510,
          "currency": "USD"
        },
        "name": "State Sales Tax",
        "percentage": "9",
        "scope": "ORDER",
        "type": "ADDITIVE",
        "uid": "state-sales-tax"
      }
    ],
    "total_discount_money": {
      "amount": 433,
      "currency": "USD"
    },
    "total_money": {
      "amount": 6176,
      "currency": "USD"
    },
    "total_service_charge_money": {
      "amount": 0,
      "currency": "USD"
    },
    "total_tax_money": {
      "amount": 510,
      "currency": "USD"
    },
    "total_tip_money": {
      "amount": 0,
      "currency": "USD"
    },
    "updated_at": "2020-01-17T20:47:53.293Z",
    "version": 1
  }
}
```

