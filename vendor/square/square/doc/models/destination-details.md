
# Destination Details

Details about a refund's destination.

## Structure

`DestinationDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cardDetails` | [`?DestinationDetailsCardRefundDetails`](../../doc/models/destination-details-card-refund-details.md) | Optional | - | getCardDetails(): ?DestinationDetailsCardRefundDetails | setCardDetails(?DestinationDetailsCardRefundDetails cardDetails): void |

## Example (as JSON)

```json
{
  "card_details": {
    "card": {
      "id": "id6",
      "card_brand": "JCB",
      "last_4": "last_48",
      "exp_month": 4,
      "exp_year": 36,
      "cardholder_name": "cardholder_name8",
      "billing_address": {
        "address_line_1": "address_line_12",
        "address_line_2": "address_line_28",
        "address_line_3": "address_line_34",
        "locality": "locality2",
        "sublocality": "sublocality8",
        "sublocality_2": "sublocality_26",
        "sublocality_3": "sublocality_32",
        "administrative_district_level_1": "administrative_district_level_12",
        "administrative_district_level_2": "administrative_district_level_26",
        "administrative_district_level_3": "administrative_district_level_36",
        "postal_code": "postal_code0",
        "country": "RW",
        "first_name": "first_name8",
        "last_name": "last_name6"
      },
      "fingerprint": "fingerprint2",
      "customer_id": "customer_id4",
      "merchant_id": "merchant_id6",
      "reference_id": "reference_id4",
      "enabled": false,
      "card_type": "UNKNOWN_CARD_TYPE",
      "prepaid_type": "PREPAID",
      "bin": "bin6",
      "version": 122,
      "card_co_brand": "AFTERPAY"
    },
    "entry_method": "entry_method8"
  }
}
```

