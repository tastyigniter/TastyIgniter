subject = "Contact on {{$site_name}}"
==
Hi there,

Someone just contacted you!

Here is your form:

Name: {{$full_name}}
Subject: {{$contact_topic}}
E-mail: {{$contact_email}}
Telephone: {{$contact_telephone}}
Message: {{$contact_message}}

This inquiry was sent from {{$site_name}}.
==
Hi Admin,

## Someone just contacted you!

Here is your form.

| | |
| -------- | -------- |
| **From**     | {{$full_name}}     |
| **Subject**     | {{$contact_topic}}     |
| **E-mail**     | {{$contact_email}}     |
| **Telephone**     | {{$contact_telephone}}     |
| **Message**     | {{$contact_message}}     |

<br>This inquiry was sent from {{$site_name}}.
