<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;

class Logout extends \Admin\Classes\AdminController
{
    protected $requireAuthentication = false;

    public function index()
    {
        if (AdminAuth::isImpersonator()) {
            AdminAuth::stopImpersonate();
        }
        else {
            AdminAuth::logout();

            session()->invalidate();

            session()->regenerateToken();
        }

        flash()->success(lang('admin::lang.login.alert_success_logout'));

        return $this->redirect('login');
    }
}
