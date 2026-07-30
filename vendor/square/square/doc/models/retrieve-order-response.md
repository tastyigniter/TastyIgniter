
# Retrieve Order Response

## Structure

`RetrieveOrderResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `order` | [`?Order`](../../doc/models/order.md) | Optional | Contains all information related to a single order to process with Square,<br>including line items that specify the products to purchase. `Order` objects also<br>include information about any associated tenders, refunds, and returns.<br><br>All Connect V2 Transactions have all been converted to Orders including all associated<br>itemization data. | getOrder(): ?Order | setOrder(?Order order): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "order": {
    "created_at": "2020-05-18T16:30:49.614Z",
    "discounts": [
      {
        "applied_money": {
          "amount": 550,
          "currency": "USD"
        },
        "name": "50% Off",
        "percentage": "50",
        "scope": "ORDER",
        "type": "FIXED_PERCENTAGE",
        "uid": "zGsRZP69aqSSR9lq9euSPB"
      }
    ],
    "id": "CAISENgvlJ6jLWAzERDzjyHVybY",
    "line_items": [
      {
        "applied_discounts": [
          {
            "applied_money": {
              "amount": 250,
              "currency": "USD"
            },
            "discount_uid": "zGsRZP69aqSSR9lq9euSPB",
            "uid": "9zr9S4dxvPAixvn0lpa1VC"
          }
        ],
        "base_price_money": {
          "amount": 500,
          "currency": "USD"
        },
        "gross_sales_money": {
          "amount": 500,
          "currency": "USD"
        },
        "name": "Item 1",
        "quantity": "1",
        "total_discount_money": {
          "amount": 250,
          "currency": "USD"
        },
        "total_money": {
          "amount": 250,
          "currency": "USD"
        },
        "total_service_charge_money": {
          "amount": 0,
          "currency": "USD"
        },
        "total_tax_money": {
          "amount": 0,
          "currency": "USD"
        },
        "uid": "ULkg0tQTRK2bkU9fNv3IJD",
        "variation_total_price_money": {
          "amount": 500,
          "currency": "USD"
        }
      },
      {
        "applied_discounts": [
          {
            "applied_money": {
              "amount": 300,
              "currency": "USD"
            },
            "discount_uid": "zGsRZP69aqSSR9lq9euSPB",
            "uid": "qa8LwwZK82FgSEkQc2HYVC"
          }
        ],
        "base_price_money": {
          "amount": 300,
          "currency": "USD"
        },
        "gross_sales_money": {
          "amount": 600,
          "currency": "USD"
        },
        "name": "Item 2",
        "quantity": "2",
        "total_discount_money": {
          "amount": 300,
          "currency": "USD"
        },
        "total_money": {
          "amount": 300,
          "currency": "USD"
        },
        "total_service_charge_money": {
          "amount": 0,
          "currency": "USD"
        },
        "total_tax_money": {
          "amount": 0,
          "currency": "USD"
        },
        "uid": "mumY8Nun4BC5aKe2yyx5a",
        "variation_total_price_money": {
          "amount": 600,
          "currency": "USD"
        }
      }
    ],
    "location_id": "D7AVYMEAPJ3A3",
    "net_amounts": {
      "discount_money": {
        "amount": 550,
        "currency": "USD"
      },
      "service_charge_money": {
        "amount": 0,
        "currency": "USD"
      },
      "tax_money": {
        "amount": 0,
        "currency": "USD"
      },
      "tip_money": {
        "amount": 0,
        "currency": "USD"
      },
      "total_money": {
        "amount": 550,
        "currency": "USD"
      }
    },
    "state": "OPEN",
    "total_discount_money": {
      "amount": 550,
      "currency": "USD"
    },
    "total_money": {
      "amount": 550,
      "currency": "USD"
    },
    "total_service_charge_money": {
      "amount": 0,
      "currency": "USD"
    },
    "total_tax_money": {
      "amount": 0,
      "currency": "USD"
    },
    "total_tip_money": {
      "amount": 0,
      "currency": "USD"
    },
    "updated_at": "2020-05-18T16:30:49.614Z",
    "version": 1
  }
}
```

