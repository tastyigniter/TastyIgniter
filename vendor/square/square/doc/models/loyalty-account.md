
# Loyalty Account

Describes a loyalty account in a [loyalty program](../../doc/models/loyalty-program.md). For more information, see
[Create and Retrieve Loyalty Accounts](https://developer.squareup.com/docs/loyalty-api/loyalty-accounts).

## Structure

`LoyaltyAccount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the loyalty account.<br>**Constraints**: *Maximum Length*: `36` | getId(): ?string | setId(?string id): void |
| `programId` | `string` | Required | The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram) to which the account belongs.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `36` | getProgramId(): string | setProgramId(string programId): void |
| `balance` | `?int` | Optional | The available point balance in the loyalty account. If points are scheduled to expire, they are listed in the `expiring_point_deadlines` field.<br><br>Your application should be able to handle loyalty accounts that have a negative point balance (`balance` is less than 0). This might occur if a seller makes a manual adjustment or as a result of a refund or exchange. | getBalance(): ?int | setBalance(?int balance): void |
| `lifetimePoints` | `?int` | Optional | The total points accrued during the lifetime of the account. | getLifetimePoints(): ?int | setLifetimePoints(?int lifetimePoints): void |
| `customerId` | `?string` | Optional | The Square-assigned ID of the [customer](entity:Customer) that is associated with the account. | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `enrolledAt` | `?string` | Optional | The timestamp when the buyer joined the loyalty program, in RFC 3339 format. This field is used to display the **Enrolled On** or **Member Since** date in first-party Square products.<br><br>If this field is not set in a `CreateLoyaltyAccount` request, Square populates it after the buyer's first action on their account<br>(when `AccumulateLoyaltyPoints` or `CreateLoyaltyReward` is called). In first-party flows, Square populates the field when the buyer agrees to the terms of service in Square Point of Sale.<br><br>This field is typically specified in a `CreateLoyaltyAccount` request when creating a loyalty account for a buyer who already interacted with their account.<br>For example, you would set this field when migrating accounts from an external system. The timestamp in the request can represent a current or previous date and time, but it cannot be set for the future. | getEnrolledAt(): ?string | setEnrolledAt(?string enrolledAt): void |
| `createdAt` | `?string` | Optional | The timestamp when the loyalty account was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp when the loyalty account was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `mapping` | [`?LoyaltyAccountMapping`](../../doc/models/loyalty-account-mapping.md) | Optional | Represents the mapping that associates a loyalty account with a buyer.<br><br>Currently, a loyalty account can only be mapped to a buyer by phone number. For more information, see<br>[Loyalty Overview](https://developer.squareup.com/docs/loyalty/overview). | getMapping(): ?LoyaltyAccountMapping | setMapping(?LoyaltyAccountMapping mapping): void |
| `expiringPointDeadlines` | [`?(LoyaltyAccountExpiringPointDeadline[])`](../../doc/models/loyalty-account-expiring-point-deadline.md) | Optional | The schedule for when points expire in the loyalty account balance. This field is present only if the account has points that are scheduled to expire.<br><br>The total number of points in this field equals the number of points in the `balance` field. | getExpiringPointDeadlines(): ?array | setExpiringPointDeadlines(?array expiringPointDeadlines): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "program_id": "program_id0",
  "balance": 64,
  "lifetime_points": 88,
  "customer_id": "customer_id8",
  "enrolled_at": "enrolled_at0",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "mapping": {
    "id": "id4",
    "created_at": "created_at2",
    "phone_number": "phone_number2"
  },
  "expiring_point_deadlines": [
    {
      "points": 209,
      "expires_at": "expires_at3"
    }
  ]
}
```

