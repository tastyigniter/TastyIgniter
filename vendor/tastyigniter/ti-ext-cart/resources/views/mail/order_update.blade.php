subject = "Your Order Update - {{ $order_number }}"
==
Order Update!

Your order {{ $order_number }} has been updated to the following status: {{ $status_name }}

The comments for your order are:
{{ $status_comment }}

To view your order progress, click the link below
{{ $order_view_url }}
==
Hi {{ $first_name }} {{ $last_name }},

Your order **{{ $order_number }}** has been updated to the following status: <br>
**{{ $status_name }}**

The comments for your order are: <br>
**{{ $status_comment }}**

@partial('button', ['url' => $order_view_url, 'type' => 'primary'])
View your order progress
@endpartial
