subject = "Invitation to access {{ $site_name }}"
description = "Invite a new staff to access the TastyIgniter Admin"
==
{{ $staff_name }}, you've been invited to access {{ $site_name }}

Click the link below to accept this invitation to gain access to {{ $site_name }} Admin.

{{ admin_url('login/reset?code='.$invite_code) }}
==
{{ $staff_name }}, you've been invited to access {{ $site_name }}

Accept this invitation to gain access to {{ $site_name }} Admin.

@partial('button', ['url' => admin_url('login/reset?code='.$invite_code), 'type' => 'primary'])
Accept Invitation
@endpartial
