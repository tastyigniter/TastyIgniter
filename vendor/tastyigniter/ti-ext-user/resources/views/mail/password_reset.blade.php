subject = "Password reset at {{$site_name}}"
==
Hi {{$full_name}},

Your password was changed successfully!

@isset($account_login_link)
    Please login using your new password:
    {{$account_login_link}}
@endisset

If you think this password update was a mistake, reset your password immediately.
==
Hi {{$first_name}} {{$last_name}},

## Your password was changed successfully!

@isset($account_login_link)
@partial('button', ['url' => $account_login_link, 'type' => 'primary'])
Login using your new password
@endpartial
@endisset

If you think this password update was a mistake, reset your password immediately.
