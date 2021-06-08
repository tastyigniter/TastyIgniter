<?php

namespace Admin\Controllers;

use AdminAuth;

class Logout extends \Admin\Classes\AdminController
{
    protected $requireAuthentication = FALSE;

    public function index()
    {
        AdminAuth::logout();
        session()->invalidate(); //invalidate and regenerate new session
        flash()->success(lang('admin::lang.login.alert_success_logout'));

        return $this->redirect('login');
    }
}
