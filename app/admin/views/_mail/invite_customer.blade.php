subject = "Invitation to access {{ $site_name }}"
==
{{ $full_name }}, you've been invited to access {{ $site_name }}

Click the link below to accept this invitation to gain access to {{ $site_name }}.

{{ site_url('forgot-password?code='.$invite_code) }}
==
{{ $full_name }}, you've been invited to access {{ $site_name }}

Accept this invitation to gain access to {{ $site_name }}.

@partial('button', ['url' => site_url('forgot-password?code='.$invite_code), 'type' => 'primary'])
Accept Invitation
@endpartial
