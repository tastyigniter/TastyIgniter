
# Booking

Represents a booking as a time-bound service contract for a seller's staff member to provide a specified service
at a given location to a requesting customer in one or more appointment segments.

## Structure

`Booking`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique ID of this object representing a booking.<br>**Constraints**: *Maximum Length*: `36` | getId(): ?string | setId(?string id): void |
| `version` | `?int` | Optional | The revision number for the booking used for optimistic concurrency. | getVersion(): ?int | setVersion(?int version): void |
| `status` | [`?string (BookingStatus)`](../../doc/models/booking-status.md) | Optional | Supported booking statuses. | getStatus(): ?string | setStatus(?string status): void |
| `createdAt` | `?string` | Optional | The RFC 3339 timestamp specifying the creation time of this booking. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The RFC 3339 timestamp specifying the most recent update time of this booking. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `startAt` | `?string` | Optional | The RFC 3339 timestamp specifying the starting time of this booking. | getStartAt(): ?string | setStartAt(?string startAt): void |
| `locationId` | `?string` | Optional | The ID of the [Location](entity:Location) object representing the location where the booked service is provided. Once set when the booking is created, its value cannot be changed.<br>**Constraints**: *Maximum Length*: `32` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `customerId` | `?string` | Optional | The ID of the [Customer](entity:Customer) object representing the customer receiving the booked service.<br>**Constraints**: *Maximum Length*: `192` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `customerNote` | `?string` | Optional | The free-text field for the customer to supply notes about the booking. For example, the note can be preferences that cannot be expressed by supported attributes of a relevant [CatalogObject](entity:CatalogObject) instance.<br>**Constraints**: *Maximum Length*: `4096` | getCustomerNote(): ?string | setCustomerNote(?string customerNote): void |
| `sellerNote` | `?string` | Optional | The free-text field for the seller to supply notes about the booking. For example, the note can be preferences that cannot be expressed by supported attributes of a specific [CatalogObject](entity:CatalogObject) instance.<br>This field should not be visible to customers.<br>**Constraints**: *Maximum Length*: `4096` | getSellerNote(): ?string | setSellerNote(?string sellerNote): void |
| `appointmentSegments` | [`?(AppointmentSegment[])`](../../doc/models/appointment-segment.md) | Optional | A list of appointment segments for this booking. | getAppointmentSegments(): ?array | setAppointmentSegments(?array appointmentSegments): void |
| `transitionTimeMinutes` | `?int` | Optional | Additional time at the end of a booking.<br>Applications should not make this field visible to customers of a seller. | getTransitionTimeMinutes(): ?int | setTransitionTimeMinutes(?int transitionTimeMinutes): void |
| `allDay` | `?bool` | Optional | Whether the booking is of a full business day. | getAllDay(): ?bool | setAllDay(?bool allDay): void |
| `locationType` | [`?string (BusinessAppointmentSettingsBookingLocationType)`](../../doc/models/business-appointment-settings-booking-location-type.md) | Optional | Supported types of location where service is provided. | getLocationType(): ?string | setLocationType(?string locationType): void |
| `creatorDetails` | [`?BookingCreatorDetails`](../../doc/models/booking-creator-details.md) | Optional | Information about a booking creator. | getCreatorDetails(): ?BookingCreatorDetails | setCreatorDetails(?BookingCreatorDetails creatorDetails): void |
| `source` | [`?string (BookingBookingSource)`](../../doc/models/booking-booking-source.md) | Optional | Supported sources a booking was created from. | getSource(): ?string | setSource(?string source): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "version": 172,
  "status": "CANCELLED_BY_SELLER",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "start_at": "start_at2",
  "location_id": "location_id4",
  "customer_id": "customer_id8",
  "customer_note": "customer_note2",
  "seller_note": "seller_note8",
  "appointment_segments": [
    {
      "duration_minutes": 4,
      "service_variation_id": "service_variation_id4",
      "team_member_id": "team_member_id0",
      "service_variation_version": 172,
      "intermission_minutes": 178,
      "any_team_member": false,
      "resource_ids": [
        "resource_ids0",
        "resource_ids1"
      ]
    }
  ],
  "transition_time_minutes": 248,
  "all_day": false,
  "location_type": "BUSINESS_LOCATION",
  "creator_details": {
    "creator_type": "TEAM_MEMBER",
    "team_member_id": "team_member_id4",
    "customer_id": "customer_id2"
  },
  "source": "FIRST_PARTY_MERCHANT"
}
```

