
# Fulfillment Pickup Details

Contains details necessary to fulfill a pickup order.

## Structure

`FulfillmentPickupDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `recipient` | [`?FulfillmentRecipient`](../../doc/models/fulfillment-recipient.md) | Optional | Information about the fulfillment recipient. | getRecipient(): ?FulfillmentRecipient | setRecipient(?FulfillmentRecipient recipient): void |
| `expiresAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when this fulfillment expires if it is not accepted. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). The expiration time can only be set up to 7 days in the future.<br>If `expires_at` is not set, this pickup fulfillment is automatically accepted when<br>placed. | getExpiresAt(): ?string | setExpiresAt(?string expiresAt): void |
| `autoCompleteDuration` | `?string` | Optional | The duration of time after which an open and accepted pickup fulfillment<br>is automatically moved to the `COMPLETED` state. The duration must be in RFC 3339<br>format (for example, "P1W3D").<br><br>If not set, this pickup fulfillment remains accepted until it is canceled or completed. | getAutoCompleteDuration(): ?string | setAutoCompleteDuration(?string autoCompleteDuration): void |
| `scheduleType` | [`?string (FulfillmentPickupDetailsScheduleType)`](../../doc/models/fulfillment-pickup-details-schedule-type.md) | Optional | The schedule type of the pickup fulfillment. | getScheduleType(): ?string | setScheduleType(?string scheduleType): void |
| `pickupAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>that represents the start of the pickup window. Must be in RFC 3339 timestamp format, e.g.,<br>"2016-09-04T23:59:33.123Z".<br><br>For fulfillments with the schedule type `ASAP`, this is automatically set<br>to the current time plus the expected duration to prepare the fulfillment. | getPickupAt(): ?string | setPickupAt(?string pickupAt): void |
| `pickupWindowDuration` | `?string` | Optional | The window of time in which the order should be picked up after the `pickup_at` timestamp.<br>Must be in RFC 3339 duration format, e.g., "P1W3D". Can be used as an<br>informational guideline for merchants. | getPickupWindowDuration(): ?string | setPickupWindowDuration(?string pickupWindowDuration): void |
| `prepTimeDuration` | `?string` | Optional | The duration of time it takes to prepare this fulfillment.<br>The duration must be in RFC 3339 format (for example, "P1W3D"). | getPrepTimeDuration(): ?string | setPrepTimeDuration(?string prepTimeDuration): void |
| `note` | `?string` | Optional | A note to provide additional instructions about the pickup<br>fulfillment displayed in the Square Point of Sale application and set by the API.<br>**Constraints**: *Maximum Length*: `500` | getNote(): ?string | setNote(?string note): void |
| `placedAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment was placed. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getPlacedAt(): ?string | setPlacedAt(?string placedAt): void |
| `acceptedAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment was accepted. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getAcceptedAt(): ?string | setAcceptedAt(?string acceptedAt): void |
| `rejectedAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment was rejected. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getRejectedAt(): ?string | setRejectedAt(?string rejectedAt): void |
| `readyAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment is marked as ready for pickup. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getReadyAt(): ?string | setReadyAt(?string readyAt): void |
| `expiredAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment expired. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getExpiredAt(): ?string | setExpiredAt(?string expiredAt): void |
| `pickedUpAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment was picked up by the recipient. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getPickedUpAt(): ?string | setPickedUpAt(?string pickedUpAt): void |
| `canceledAt` | `?string` | Optional | The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)<br>indicating when the fulfillment was canceled. The timestamp must be in RFC 3339 format<br>(for example, "2016-09-04T23:59:33.123Z"). | getCanceledAt(): ?string | setCanceledAt(?string canceledAt): void |
| `cancelReason` | `?string` | Optional | A description of why the pickup was canceled. The maximum length: 100 characters.<br>**Constraints**: *Maximum Length*: `100` | getCancelReason(): ?string | setCancelReason(?string cancelReason): void |
| `isCurbsidePickup` | `?bool` | Optional | If set to `true`, indicates that this pickup order is for curbside pickup, not in-store pickup. | getIsCurbsidePickup(): ?bool | setIsCurbsidePickup(?bool isCurbsidePickup): void |
| `curbsidePickupDetails` | [`?FulfillmentPickupDetailsCurbsidePickupDetails`](../../doc/models/fulfillment-pickup-details-curbside-pickup-details.md) | Optional | Specific details for curbside pickup. | getCurbsidePickupDetails(): ?FulfillmentPickupDetailsCurbsidePickupDetails | setCurbsidePickupDetails(?FulfillmentPickupDetailsCurbsidePickupDetails curbsidePickupDetails): void |

## Example (as JSON)

```json
{
  "recipient": {
    "customer_id": "customer_id6",
    "display_name": "display_name8",
    "email_address": "email_address4",
    "phone_number": "phone_number4",
    "address": {
      "address_line_1": "address_line_14",
      "address_line_2": "address_line_24",
      "address_line_3": "address_line_30",
      "locality": "locality4",
      "sublocality": "sublocality4",
      "sublocality_2": "sublocality_22",
      "sublocality_3": "sublocality_34",
      "administrative_district_level_1": "administrative_district_level_18",
      "administrative_district_level_2": "administrative_district_level_20",
      "administrative_district_level_3": "administrative_district_level_32",
      "postal_code": "postal_code6",
      "country": "PK",
      "first_name": "first_name4",
      "last_name": "last_name2"
    }
  },
  "expires_at": "expires_at6",
  "auto_complete_duration": "auto_complete_duration4",
  "schedule_type": "SCHEDULED",
  "pickup_at": "pickup_at4",
  "pickup_window_duration": "pickup_window_duration0",
  "prep_time_duration": "prep_time_duration2",
  "note": "note4",
  "placed_at": "placed_at0",
  "accepted_at": "accepted_at6",
  "rejected_at": "rejected_at8",
  "ready_at": "ready_at0",
  "expired_at": "expired_at0",
  "picked_up_at": "picked_up_at0",
  "canceled_at": "canceled_at4",
  "cancel_reason": "cancel_reason4",
  "is_curbside_pickup": false,
  "curbside_pickup_details": {
    "curbside_details": "curbside_details2",
    "buyer_arrived_at": "buyer_arrived_at8"
  }
}
```

