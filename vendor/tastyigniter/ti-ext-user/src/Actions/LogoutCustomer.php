<?php

declare(strict_types=1);

namespace Igniter\User\Actions;

use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class LogoutCustomer
{
    public function handle(): void
    {
        $user = Auth::getUser();

        if (Auth::isImpersonator()) {
            Auth::stopImpersonate();
        } else {
            Auth::logout();

            Session::invalidate();

            Session::regenerateToken();

            if ($user) {
                Event::dispatch('igniter.user.logout', [$user]);
            }
        }

        flash()->success(lang('igniter.user::default.alert_logout_success'));
    }
}
