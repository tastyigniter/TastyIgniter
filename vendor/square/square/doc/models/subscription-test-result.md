
# Subscription Test Result

Represents the details of a webhook subscription, including notification URL,
event types, and signature key.

## Structure

`SubscriptionTestResult`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A Square-generated unique ID for the subscription test result.<br>**Constraints**: *Maximum Length*: `64` | getId(): ?string | setId(?string id): void |
| `statusCode` | `?int` | Optional | The status code returned by the subscription notification URL. | getStatusCode(): ?int | setStatusCode(?int statusCode): void |
| `payload` | `?string` | Optional | An object containing the payload of the test event. For example, a `payment.created` event. | getPayload(): ?string | setPayload(?string payload): void |
| `createdAt` | `?string` | Optional | The timestamp of when the subscription was created, in RFC 3339 format.<br>For example, "2016-09-04T23:59:33.123Z". | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp of when the subscription was updated, in RFC 3339 format. For example, "2016-09-04T23:59:33.123Z".<br>Because a subscription test result is unique, this field is the same as the `created_at` field. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "status_code": 122,
  "payload": "payload6",
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

