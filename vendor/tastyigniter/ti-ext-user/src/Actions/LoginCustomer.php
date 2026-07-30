<?php

declare(strict_types=1);

namespace Igniter\User\Actions;

use Igniter\Flame\Exception\FlashException;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class LoginCustomer
{
    public function __construct(public array $credentials, public bool $remember = true) {}

    public function handle(): void
    {
        Event::dispatch('igniter.user.beforeAuthenticate', [$this, $this->credentials]);

        if (!Auth::check() && !Auth::attempt($this->credentials, $this->remember)) {
            throw new FlashException(lang('igniter.user::default.login.alert_invalid_login'));
        }

        Session::regenerate();

        Event::dispatch('igniter.user.login', [$this], true);
    }
}
