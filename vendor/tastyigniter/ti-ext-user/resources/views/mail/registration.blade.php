subject = "Welcome to {{$site_name}}"
==
Hi {{$first_name}} {{$last_name}},

Thank you for registering with {{$site_name}}.

Your account has now been created and you can log in using your email address and password by visiting our website or at the following URL: {{$account_login_link}}
==
Hi {{$first_name}} {{$last_name}},

## Thank you for registering with {{$site_name}}.

Your account has now been created and you can log in using your email address and password by clicking the button below:

@partial('button', ['url' => $account_login_link, 'type' => 'primary'])
Login into your account
@endpartial
