<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;

class Logout extends \Admin\Classes\AdminController
{
    protected $requireAuthentication = FALSE;

    public function index()
    {
        if (AdminAuth::isImpersonator()) {
            AdminAuth::stopImpersonate();
        }
        else {
            AdminAuth::logout();
        }

        flash()->success(lang('admin::lang.login.alert_success_logout'));

        return $this->redirect('login');
    }
}
