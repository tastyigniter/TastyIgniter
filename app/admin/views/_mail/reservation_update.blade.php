subject = "Your Reservation Update - {{ $reservation_number }}"
==
Reservation Update!

Your reservation {{ $reservation_number }} at {{ $location_name }} has been updated to the following status: {{ $status_name }}

The comments for your reservation are:
{{ $status_comment }}

To view your reservation progress, click the link below
{{ $reservation_view_url }}
==
Hi {{ $first_name }} {{ $last_name }},

Your reservation **{{ $reservation_number }}** at **{{ $location_name }}** has been updated to the following status:
<br>
**{{ $status_name }}**

The comments for your reservation are: <br>
{{ $status_comment }}

@partial('button', ['url' => $reservation_view_url, 'type' => 'primary'])
View your reservation status
@endpartial
