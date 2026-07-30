---
title: "Reservation"
section: "extensions"
sortOrder: 90
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-reservation -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

To manage dining areas and tables for each location in the admin area. Navigate to the _Restaurant > Dining Areas_ admin page.

### Location-specific settings

From your TastyIgniter Admin, you can configure the reservation settings for each location. Navigate to the _Manage > Locations_ admin page, and click on the _Settings Icon_ next to the location then click the _Reservation settings_ button under the _General_ tab. You can set the following reservation settings for each location:

- **Enable reservations:** Enable or disable reservations for the location.
- **Auto assign tables:** Whether to automatically assign tables to reservations.
- **Reservation time interval:** Set the time interval for reservations.
- **Reservation stay time:** Set the time customers can stay at a table.
- **Reservation guest capacity:** Set the number of guests that can be accommodated at a each booking time slot.
- **Reservation lead time:** Set the minimum and maximum time required to make a reservation.
- **Reservation cancellation time:** Set the minimum time required to cancel a reservation.

### Global reservation settings

From your TastyIgniter Admin, you can also configure the reservation settings for all locations. Navigate to the _Manage > Settings > Reservation_ admin page. You can set the following reservation settings for all locations:

- **Send reservation confirmation email:** Whether to send reservation confirmation emails to customers, location email and admin email.
- **Order status workflow:** Set the reservation status workflow for all locations. For example, you can set the reservation status to _Pending_ when a reservation is received, _Confirmed_ when the reservation is being confirmed, and _Canceled_ when the reservation is canceled.

## Usage

This section covers how to integrate the Reservation extension API into your own extension if you need to create reservations, generate reservation time slots, assign tables, update reservation status, assign staff members, or cancel reservations. The Reservation extension provides a simple API for managing reservations and their related features.

### Making a Reservation

To create a reservation, you can use the `Igniter\Reservation\Classes\BookingManager` class. The class provides methods to create a reservation, generate reservation time slots and get the next available bookable table.

```php
use Igniter\Reservation\Classes\BookingManager;

$bookingManager = resolve(BookingManager::class);

$reservation = $bookingManager->loadReservation();

$reservation = $bookingManager->saveReservation($reservation, $attributes);
```

The `$attributes` array may contain the following keys:

- `guest`: _(integer)_ The number of guests for the reservation.
- `first_name`: _(string)_ The first name of the customer.
- `last_name`: _(string)_ The last name of the customer.
- `email`: _(string)_ The email address of the customer.
- `telephone`: _(string)_ The telephone number of the customer.
- `comment`: _(string)_ The customer's comment for the reservation.
- `sdateTime`: _(string|DateTime)_ The reservation date and time.

### Generating reservation time slots

To generate reservation time slots, you can use the `makeTimeSlots` method on the booking manager instance. The method accepts three parameters: the `Carbon` instance for the current date, the interval in minutes, and lead time in minutes. The method returns an array of `DateTime` objects.

```php
$timeslots = $bookingManager->makeTimeSlots($date, $interval, $leadTime);
```

Both the `$interval` and `$leadTime` parameters are optional. The method will default to the reservation time interval and lead time configured in the admin area.

For more information on generating schedule time slots, see the [Local Extension](https://tastyigniter.com/docs/extensions/local#working-hours) documentation.

### Assigning tables

To assign tables to a reservation, you can use the `assignTable` method on the reservation model instance. The method automatically assigns tables to the reservation based on the reservation time, the number of guests and available tables.

```php
$reservation->assignTable();
```

You may also manually assign tables to a reservation using the `addReservationTables` method on the reservation model instance. The method accepts an array of table IDs as the first parameter.

```php
$reservation->addReservationTables($tableIds);
```

### Updating a reservation status

You can update a reservation status using the `addStatusHistory` method on the reservation model instance. The method accepts the status model instance as the first parameter and the status data array as the second parameter.

```php
$reservation->addStatusHistory($status, $statusData);
```

The `$statusData` array may contain the following keys:

- `staff_id`: The staff ID who updated the reservation status.
- `comment`: The comment for the reservation status update.
- `notify`: Whether to notify the customer of the reservation status update.

### Assigning staff members

You can assign staff members to an reservation using the `assignTo` method on the reservation model instance. The method accepts an instance of the `Igniter\User\Models\UserGroup` model as the first parameter and the `Igniter\User\Models\User` model as the second parameter.

```php
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;

$staff = User::find(1);
$group = UserGroup::find(1);

$reservation->updateAssignTo($group, $staff);
```

### Cancelling a reservation

You can cancel a reservation using the `markAsCanceled` method on the reservation model instance. The method updates the reservation status to canceled reservation status configured in the admin area. The method accepts the `$statusData` array as the first parameter.

```php
$reservation->markAsCanceled($statusData);
```

The `$statusData` array may contain the following keys:

- `staff_id`: The staff ID who canceled the reservation.
- `comment`: The reason for canceling the reservation.
- `notify`: Whether to notify the customer of the reservation cancellation.

### Automations Events

#### New Reservation Event

An automation event class used to capture the `igniter.reservation.confirmed` system event when a reservation is received. The event class is also used to prepare the order parameters for automation rules. The following parameters are available:

- `reservation`: The `Igniter\Reservation\Models\Reservation` model instance.
- `status`: The `Igniter\Admin\Models\Status` model instance.
- `reservation_number`: The reservation ID.
- `reservation_id`: The reservation ID.
- `reservation_time`: The reservation time.
- `reservation_date`: The reservation date.
- `reservation_guest_no`: The number of guests for the reservation.
- `first_name`: The first name of the customer.
- `last_name`: The last name of the customer.
- `email`: The email address of the customer.
- `telephone`: The telephone number of the customer.
- `reservation_comment`: The customer's comment for the reservation.
- `location_logo`: The location logo.
- `location_name`: The location name.
- `location_email`: The location email.
- `location_telephone`: The location telephone number.
- `status_name`: The reservation status name.
- `status_comment`: The reservation status comment.
- `reservation_view_url`: The reservation view URL.

#### Reservation Status Update Event

An automation event class used to capture the `igniter.reservation.statusAdded` system event when a reservation status is updated. Similar to the `New Reservation Event`, the event class is also used to prepare the reservation parameters for automation rules. The available parameters are the same as the `New Reservation Event`.

#### Reservation Assigned Event

An automation event class used to capture the `igniter.reservation.assigned` system event when a reservation is assigned to a staff member. Similar to the `New Reservation Event`, the event class is also used to prepare the reservation parameters for automation rules. The available parameters are the same as the `New Reservation Event` including the following additional parameters:

- `assignee`: The assignee `Igniter\User\Models\User` model instance.

### Automations Conditions

When setting up automation rules through the Admin Panel, you can use the following automation conditions registered by the this extension:

#### Reservation Attribute Condition

A condition class used to check if a reservation attribute match the specified value or rule. The following attributes are available:

- `first_name`: The first name of the customer.
- `last_name`: The last name of the customer.
- `email`: The email address of the customer.
- `location_id`: The location ID of the reservation.
- `status_id`: The last status ID of the reservation.
- `guest_num`: The number of guests for the reservation.
- `hours_since`: The number of hours since the reservation time.
- `hours_until`: The number of hours until the reservation time.
- `days_since`: The number of days since the reservation time.
- `days_until`: The number of days until the reservation time.

#### Reservation Status Attribute Condition

A condition class used to check if a reservation status attribute match the specified value or rule. The following attributes are available:

- `status_id`: The status ID of the reservation.
- `status_name`: The status name of the reservation.
- `notify_customer`: Whether the customer was notified of the status change.

### Mail templates

This extension registers the following mail templates, managed through the Admin Panel:

- `igniter.reservation::mail.reservation`: Reservation confirmation email sent to customers.
- `igniter.reservation::mail.reservation_alert`: New reservation notification email sent to administrators.
- `igniter.reservation::mail.reservation_update`: Reservation status update email sent to customers.

### Permissions

The Reservation extension registers the following permissions:

- `Admin.Tables`: Control who can manage dining areas and tables in the admin area.
- `Admin.Reservations`: Control who can manage reservations in the admin area.
- `Admin.DeleteReservations`: Control who can delete reservations in the admin area.
- `Admin.AssignReservations`: Control who can assign reservations to staff members in the admin area.
- `Admin.AssignReservationTables`: Control who can assign tables to reservations in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.

### Events

The Booking Manager used with this extension will fire some global events that can be useful for interacting with other
extensions.

| Event | Description | Parameters |
| ----- | ----------- | ---------- |
| `igniter.reservation.beforeSaveReservation` |    When a reservation is being created.    |      The `Igniter\Reservation\Models\Reservation` model instance and the reservation form attributes     |
| `igniter.reservation.confirmed` |      When a reservation has been placed.       |      The `Igniter\Reservation\Models\Reservation` model instance     |
| `igniter.reservation.isFullyBookedOn` | When a reservation is fully booked on a specific date. | The `DataTime` instance and the number of guests |
| `igniter.reservation.beforeAddStatus` | Before a reservation status is updated. | The `Igniter\Admin\Models\StatusHistory` model instance, the `Igniter\Reservation\Models\Reservation` model instance, `$statusId` status ID and the `$previousStatus` previous status ID |
| `igniter.reservation.statusAdded` | When a reservation status is updated. | The `Igniter\Reservation\Models\Reservation` model instance and the `Igniter\Admin\Models\StatusHistory` model instance |
| `igniter.reservation.assigned` | When a reservation is assigned to a staff member. | The `Igniter\Reservation\Models\Reservation` model instance and the `Igniter\User\Models\AssignableLog` model instance |

Here is an example of hooking an event in the `boot` method of an extension class:

```php
use Illuminate\Support\Facades\Event;

public function boot()
{
    Event::listen('igniter.reservation.confirmed', function($reservation) {
        // ...
    });
}
```
