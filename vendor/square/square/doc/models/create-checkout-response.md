
# Create Checkout Response

Defines the fields that are included in the response body of
a request to the `CreateCheckout` endpoint.

## Structure

`CreateCheckoutResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `checkout` | [`?Checkout`](../../doc/models/checkout.md) | Optional | Square Checkout lets merchants accept online payments for supported<br>payment types using a checkout workflow hosted on squareup.com. | getCheckout(): ?Checkout | setCheckout(?Checkout checkout): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "checkout": {
    "additional_recipients": [
      {
        "amount_money": {
          "amount": 60,
          "currency": "USD"
        },
        "description": "Application fees",
        "location_id": "057P5VYJ4A5X1"
      }
    ],
    "ask_for_shipping_address": true,
    "checkout_page_url": "https://connect.squareup.com/v2/checkout?c=CAISEHGimXh-C3RIT4og1a6u1qw&l=CYTKRM7R7JMV8",
    "created_at": "2017-06-16T22:25:35Z",
    "id": "CAISEHGimXh-C3RIT4og1a6u1qw",
    "merchant_support_email": "merchant+support@website.com",
    "order": {
      "customer_id": "customer_id",
      "discounts": [
        {
          "amount_money": {
            "amount": 100,
            "currency": "USD"
          },
          "applied_money": {
            "amount": 100,
            "currency": "USD"
          },
          "scope": "LINE_ITEM",
          "type": "FIXED_AMOUNT",
          "uid": "56ae1696-z1e3-9328-af6d-f1e04d947gd4"
        }
      ],
      "line_items": [
        {
          "applied_discounts": [
            {
              "applied_money": {
                "amount": 100,
                "currency": "USD"
              },
              "discount_uid": "56ae1696-z1e3-9328-af6d-f1e04d947gd4"
            }
          ],
          "applied_taxes": [
            {
              "applied_money": {
                "amount": 103,
                "currency": "USD"
              },
              "tax_uid": "38ze1696-z1e3-5628-af6d-f1e04d947fg3"
            }
          ],
          "base_price_money": {
            "amount": 1500,
            "currency": "USD"
          },
          "name": "Printed T Shirt",
          "quantity": "2",
          "total_discount_money": {
            "amount": 100,
            "currency": "USD"
          },
          "total_money": {
            "amount": 1503,
            "currency": "USD"
          },
          "total_tax_money": {
            "amount": 103,
            "currency": "USD"
          }
        },
        {
          "base_price_money": {
            "amount": 2500,
            "currency": "USD"
          },
          "name": "Slim Jeans",
          "quantity": "1",
          "total_money": {
            "amount": 2500,
            "currency": "USD"
          }
        },
        {
          "base_price_money": {
            "amount": 3500,
            "currency": "USD"
          },
          "name": "Woven Sweater",
          "quantity": "3",
          "total_money": {
            "amount": 10500,
            "currency": "USD"
          }
        }
      ],
      "location_id": "location_id",
      "reference_id": "reference_id",
      "taxes": [
        {
          "percentage": "7.75",
          "scope": "LINE_ITEM",
          "type": "INCLUSIVE",
          "uid": "38ze1696-z1e3-5628-af6d-f1e04d947fg3"
        }
      ],
      "total_discount_money": {
        "amount": 100,
        "currency": "USD"
      },
      "total_money": {
        "amount": 14503,
        "currency": "USD"
      },
      "total_tax_money": {
        "amount": 103,
        "currency": "USD"
      }
    },
    "pre_populate_buyer_email": "example@email.com",
    "pre_populate_shipping_address": {
      "address_line_1": "1455 Market St.",
      "address_line_2": "Suite 600",
      "administrative_district_level_1": "CA",
      "country": "US",
      "first_name": "Jane",
      "last_name": "Doe",
      "locality": "San Francisco",
      "postal_code": "94103"
    },
    "redirect_url": "https://merchant.website.com/order-confirm",
    "version": 1
  }
}
```

