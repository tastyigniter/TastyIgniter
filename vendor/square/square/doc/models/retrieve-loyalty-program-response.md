
# Retrieve Loyalty Program Response

A response that contains the loyalty program.

## Structure

`RetrieveLoyaltyProgramResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `program` | [`?LoyaltyProgram`](../../doc/models/loyalty-program.md) | Optional | Represents a Square loyalty program. Loyalty programs define how buyers can earn points and redeem points for rewards.<br>Square sellers can have only one loyalty program, which is created and managed from the Seller Dashboard.<br>For more information, see [Loyalty Program Overview](https://developer.squareup.com/docs/loyalty/overview). | getProgram(): ?LoyaltyProgram | setProgram(?LoyaltyProgram program): void |

## Example (as JSON)

```json
{
  "program": {
    "accrual_rules": [
      {
        "accrual_type": "SPEND",
        "points": 1,
        "spend_data": {
          "amount_money": {
            "amount": 100,
            "currency": "USD"
          },
          "excluded_category_ids": [
            "7ZERJKO5PVYXCVUHV2JCZ2UG",
            "FQKAOJE5C4FIMF5A2URMLW6V"
          ],
          "excluded_item_variation_ids": [
            "CBZXBUVVTYUBZGQO44RHMR6B",
            "EDILT24Z2NISEXDKGY6HP7XV"
          ],
          "tax_mode": "BEFORE_TAX"
        }
      }
    ],
    "created_at": "2020-04-20T16:55:11Z",
    "id": "d619f755-2d17-41f3-990d-c04ecedd64dd",
    "location_ids": [
      "P034NEENMD09F"
    ],
    "reward_tiers": [
      {
        "created_at": "2020-04-20T16:55:11Z",
        "definition": {
          "discount_type": "FIXED_PERCENTAGE",
          "percentage_discount": "10",
          "scope": "ORDER"
        },
        "id": "e1b39225-9da5-43d1-a5db-782cdd8ad94f",
        "name": "10% off entire sale",
        "points": 10,
        "pricing_rule_reference": {
          "catalog_version": 1605486402527,
          "object_id": "74C4JSHESNLTB2A7ITO5HO6F"
        }
      }
    ],
    "status": "ACTIVE",
    "terminology": {
      "one": "Point",
      "other": "Points"
    },
    "updated_at": "2020-05-01T02:00:02Z"
  }
}
```

