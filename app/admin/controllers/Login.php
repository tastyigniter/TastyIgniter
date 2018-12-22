<?php namespace Admin\Controllers;

use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Admin\Traits\ValidatesForm;
use AdminAuth;
use Mail;
use Template;

class Login extends \Admin\Classes\AdminController
{
    use ValidatesForm;

    protected $requireAuthentication = FALSE;

    public $bodyClass = 'page-login';

    public function index()
    {
        if (AdminAuth::isLogged())
            return $this->redirect('dashboard');

        Template::setTitle(lang('admin::lang.login.text_title'));

        if (!($this->validateLoginForm() === FALSE)) {
            $credentials = [
                'username' => post('user'),
                'password' => post('password'),
            ];

            if (!AdminAuth::authenticate($credentials, TRUE, TRUE)) {
                flash()->danger(lang('admin::lang.login.alert_username_not_found'));

                return $this->redirectBack();
            }

            activity()->causedBy(AdminAuth::getUser())
                      ->log(lang('system::lang.activities.activity_logged_in'));

            if ($redirectUrl = input('redirect'))
                return $this->redirect($redirectUrl);

            return $this->redirectIntended('dashboard');
        }

        return $this->makeView('auth/login');
    }

    public function reset()
    {
        if (AdminAuth::islogged()) {
            return $this->redirect('dashboard');
        }

        Template::setTitle(lang('admin::lang.login.text_password_reset_title'));

        $this->vars['resetCode'] = input('code');

        if ($this->_resetPassword()) {
            return $this->redirect('login');
        }

        return $this->makeView('auth/reset');
    }

    protected function _resetPassword()
    {
        if ($this->validateResetForm()) {
            if (!$code = input('code')) {
                $staff = Staffs_model::whereStaffEmail(post('email'))->first();
                $user = $staff->user;

                if ($user AND $user->resetPassword()) {
                    $data = [
                        'staff_name' => $staff->staff_name,
                        'reset_link' => admin_url('login/reset?code='.$user->reset_code),
                    ];

                    Mail::send('admin::_mail.password_reset_request', $data, function ($message) use ($staff) {
                        $message->to($staff->staff_email, $staff->staff_name);
                    });

                    flash()->success(lang('admin::lang.login.alert_email_sent'));

                    return TRUE;
                }

                $error = lang('admin::lang.login.alert_email_not_sent');
            }
            else {
                $user = Users_model::whereResetCode($code)->first();

                if ($user AND $user->completeResetPassword($code, post('password'))) {

                    $data = [
                        'staff_name' => $user->staff->staff_name,
                    ];

                    Mail::send('admin::_mail.password_reset', $data, function ($message) use ($user) {
                        $message->to($user->staff->staff_email, $user->staff->staff_name);
                    });

                    flash()->success(lang('admin::lang.login.alert_success_reset'));

                    return TRUE;
                }

                $error = lang('admin::lang.login.alert_failed_reset');
            }

            flash()->danger($error);

            return $this->redirect(current_url());
        }
    }

    protected function validateLoginForm()
    {
        if (!$post = post())
            return FALSE;

        return $this->validatePasses($post, [
            ['user', 'lang:admin::lang.login.label_username', 'required|exists:users,username'],
            ['password', 'lang:admin::lang.login.label_password', 'required|min:6'],
        ]);
    }

    protected function validateResetForm()
    {
        if (!$post = post())
            return FALSE;

        if (input('code')) {
            $rules = [
                ['password', 'lang:admin::lang.login.label_password', 'required|min:6|max:32|same:password_confirm'],
                ['password_confirm', 'lang:admin::lang.login.label_password_confirm', 'required'],
            ];
        }
        else {
            $rules[] = ['email', 'lang:admin::lang.login.label_email', 'required|email|exists:staffs,staff_email'];
        }

        return $this->validatePasses($post, $rules);
    }
}