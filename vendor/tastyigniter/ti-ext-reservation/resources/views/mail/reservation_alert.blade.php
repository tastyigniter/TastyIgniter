subject = "New reservation on {{$site_name}}"
==
You received a table reservation from {{$site_name}}.

Customer name: {{$first_name}} {{$last_name}}
Reservation no: {{$reservation_number}}
Restaurant: {{$location_name}}
No of guest(s): {{$reservation_guest_no}} person(s)
Reservation date: {{$reservation_date}}
Reservation time: {{$reservation_time}}
==
## You received a table reservation from {{$site_name}}.

| | |
| -------- | -------- |
| **Customer name**     | {{$first_name}} {{$last_name}}     |
| **Reservation no**     | {{$reservation_number}}     |
| **Restaurant**     | {{$location_name}}     |
| **No of guest(s)**     | {{$reservation_guest_no}} person(s)     |
| **Reservation date**     | {{$reservation_date}}     |
| **Reservation time**     | {{$reservation_time}}     |
