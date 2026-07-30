<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Http\RedirectResponse;

class Logout extends AdminController
{
    protected $requireAuthentication = false;

    public static bool $skipRouteRegister = true;

    public function index(): RedirectResponse
    {
        if (AdminAuth::isImpersonator()) {
            AdminAuth::stopImpersonate();
        } else {
            AdminAuth::logout();

            session()->invalidate();

            session()->regenerateToken();
        }

        flash()->success(lang('igniter.user::default.login.alert_success_logout'));

        return $this->redirect('login');
    }
}
