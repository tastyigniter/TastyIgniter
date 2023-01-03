<?php

namespace Admin\Controllers;

use Admin\Facades\AdminAuth;
use Admin\Facades\Template;
use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\ValidationException;
use Illuminate\Support\Facades\Mail;

class Login extends \Admin\Classes\AdminController
{
    use ValidatesForm;

    protected $requireAuthentication = false;

    public $bodyClass = 'page-login';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('throttle:'.config('system.authRateLimiter', '6,1'));
    }

    public function index()
    {
        if (AdminAuth::isLogged())
            return $this->redirect('dashboard');

        Template::setTitle(lang('admin::lang.login.text_title'));

        return $this->makeView('auth/login');
    }

    public function reset()
    {
        if (AdminAuth::isLogged()) {
            return $this->redirect('dashboard');
        }

        $code = input('code');
        if (strlen($code) && !Users_model::whereResetCode(input('code'))->first()) {
            flash()->error(lang('admin::lang.login.alert_failed_reset'));

            return $this->redirect('login');
        }

        Template::setTitle(lang('admin::lang.login.text_password_reset_title'));

        $this->vars['resetCode'] = input('code');

        return $this->makeView('auth/reset');
    }

    public function onLogin()
    {
        $data = post();

        $this->validate($data, [
            'username' => ['required'],
            'password' => ['required', 'min:6'],
        ], [], [
            'username' => lang('admin::lang.login.label_username'),
            'password' => lang('admin::lang.login.label_password'),
        ]);

        $credentials = [
            'username' => array_get($data, 'username'),
            'password' => array_get($data, 'password'),
        ];

        if (!AdminAuth::authenticate($credentials, true, true))
            throw new ValidationException(['username' => lang('admin::lang.login.alert_username_not_found')]);

        session()->regenerate();

        if ($redirectUrl = input('redirect'))
            return $this->redirect($redirectUrl);

        return $this->redirectIntended('dashboard');
    }

    public function onRequestResetPassword()
    {
        $data = post();

        $this->validate($data, [
            'email' => ['required', 'email:filter', 'max:96'],
        ], [], [
            'email' => lang('admin::lang.label_email'),
        ]);

        $staff = Staffs_model::whereStaffEmail(post('email'))->first();
        if ($staff && $user = $staff->user) {
            if (!$user->resetPassword())
                throw new ValidationException(['email' => lang('admin::lang.login.alert_failed_reset')]);
            $data = [
                'staff_name' => $staff->staff_name,
                'reset_link' => admin_url('login/reset?code='.$user->reset_code),
            ];
            Mail::queue('admin::_mail.password_reset_request', $data, function ($message) use ($staff) {
                $message->to($staff->staff_email, $staff->staff_name);
            });
        }

        flash()->success(lang('admin::lang.login.alert_email_sent'));

        return $this->redirect('login');
    }

    public function onResetPassword()
    {
        $data = post();

        $this->validate($data, [
            'code' => ['required'],
            'password' => ['required', 'min:6', 'max:32', 'same:password_confirm'],
            'password_confirm' => ['required'],
        ], [], [
            'code' => lang('admin::lang.login.label_reset_code'),
            'password' => lang('admin::lang.login.label_password'),
            'password_confirm' => lang('admin::lang.login.label_password_confirm'),
        ]);

        $code = array_get($data, 'code');
        $user = Users_model::whereResetCode($code)->first();

        if (!$user || !$user->completeResetPassword($code, post('password')))
            throw new ValidationException(['password' => lang('admin::lang.login.alert_failed_reset')]);

        $data = [
            'staff_name' => $user->staff->staff_name,
        ];

        Mail::queue('admin::_mail.password_reset', $data, function ($message) use ($user) {
            $message->to($user->staff->staff_email, $user->staff->staff_name);
        });

        flash()->success(lang('admin::lang.login.alert_success_reset'));

        return $this->redirect('login');
    }
}
