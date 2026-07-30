subject = "Please verify your email address"
==
Hi {first_name},

Complete your registration with {site_name}.

Please click this link to verify your email address:

{account_activation_link}
==
Hi {first_name} {last_name},

## Complete your registration with {site_name}.

Please click the button below to verify your email address:

@partial('button', ['url' => '{account_activation_link}', 'type' => 'primary'])
Confirm my account
@endpartial

Alternatively, copy and paste the link below in a new browser window: <br>
{account_activation_link}
