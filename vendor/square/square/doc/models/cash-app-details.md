
# Cash App Details

Additional details about `WALLET` type payments with the `brand` of `CASH_APP`.

## Structure

`CashAppDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `buyerFullName` | `?string` | Optional | The name of the Cash App account holder.<br>**Constraints**: *Maximum Length*: `255` | getBuyerFullName(): ?string | setBuyerFullName(?string buyerFullName): void |
| `buyerCountryCode` | `?string` | Optional | The country of the Cash App account holder, in ISO 3166-1-alpha-2 format.<br><br>For possible values, see [Country](entity:Country).<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `2` | getBuyerCountryCode(): ?string | setBuyerCountryCode(?string buyerCountryCode): void |
| `buyerCashtag` | `?string` | Optional | $Cashtag of the Cash App account holder.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `21` | getBuyerCashtag(): ?string | setBuyerCashtag(?string buyerCashtag): void |

## Example (as JSON)

```json
{
  "buyer_full_name": "buyer_full_name4",
  "buyer_country_code": "buyer_country_code4",
  "buyer_cashtag": "buyer_cashtag6"
}
```

