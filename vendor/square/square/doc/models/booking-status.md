
# Booking Status

Supported booking statuses.

## Enumeration

`BookingStatus`

## Fields

| Name | Description |
|  --- | --- |
| `PENDING` | An unaccepted booking. It is visible to both sellers and customers. |
| `CANCELLED_BY_CUSTOMER` | A customer-cancelled booking. It is visible to both the seller and the customer. |
| `CANCELLED_BY_SELLER` | A seller-cancelled booking. It is visible to both the seller and the customer. |
| `DECLINED` | A declined booking. It had once been pending, but was then declined by the seller. |
| `ACCEPTED` | An accepted booking agreed to or accepted by the seller. |
| `NO_SHOW` | A no-show booking. The booking was accepted at one time, but have now been marked as a no-show by<br>the seller because the client either missed the booking or cancelled it without enough notice. |

