subject = "Password reset request at {{ $site_name }}"
==
Hi, {{ $staff_name }}

Someone requested a password reset for your {{ $site_name }} account.

If you did request a password reset, copy and paste the link below in a new browser window: {{ $reset_link }}
==
Hi {{ $staff_name }},

Someone requested a password reset for your **{{ $site_name }}** account.

If you did request a password reset, click the button below to reset password.

@partial('button', ['url' => $reset_link, 'type' => 'primary'])
Reset your password
@endpartial

Alternatively, copy and paste the link below in a new browser window: <br>
{{ $reset_link }}
