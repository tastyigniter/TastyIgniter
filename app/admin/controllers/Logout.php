<?php

namespace Admin\Controllers;

use AdminAuth;

class Logout extends \Admin\Classes\AdminController
{
    protected $requireAuthentication = FALSE;

    public function index()
    {
        if ($user = AdminAuth::user())
            activity()->causedBy($user)->log(lang('system::activities.activity_logged_out'));

        AdminAuth::logout();

        flash()->set('success', lang('admin::login.alert_success_logout'));

        return $this->redirect('login');
    }
}