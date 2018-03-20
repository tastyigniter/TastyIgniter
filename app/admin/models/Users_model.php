<?php namespace Admin\Models;

use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User as AuthUserModel;
use Igniter\Flame\Database\Traits\Purgeable;

/**
 * Users Model Class
 * @package Admin
 */
class Users_model extends AuthUserModel
{
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $dates = [
        'reset_time',
        'date_activated',
    ];

    public $relation = [
        'belongsTo' => [
            'staff' => ['Admin\Models\Staffs_model', 'foreignKey' => 'staff_id'],
        ],
    ];

    protected $with = ['staff'];

    protected $fillable = ['username', 'super_user'];

    protected $appends = ['staff_name'];

    protected $hidden = ['password'];

    protected $purgeable = ['password_confirm'];

    public function getStaffNameAttribute()
    {
        if (!$staff = $this->staff)
            return null;

        return $staff->staff_name;
    }

    public function isSuperUser()
    {
        return ($this->super_user == 1);
    }

    /**
     * Reset a staff password,
     *
     */
    public function resetPassword()
    {
        $this->reset_code = $resetCode = $this->generateResetCode();
        $this->reset_time = Carbon::now();
        $this->save();

        return $resetCode;

//        if (!is_string($username))
//            return FALSE;
//
//        $query = $this->newQuery()->where('username', $username);
//        if (!$userModel = $query->first())
//            return FALSE;
//
//        $update = [
//            'reset_code' => $this->createResetCode($userModel),
//            'reset_time' => mdate('%Y-%m-%d %H:%i:%a', time()),
//        ];
//
//        $updated = $userModel->update($update);
//        if ($updated < 1)
//            return FALSE;
//
//        $mail_data['staff_name'] = $userModel->staff_name;
//        $mail_data['staff_username'] = $userModel->username;
//        $mail_data['reset_link'] = admin_url('login/reset?code='.$update['reset_code']);
//
//        $mail_template = Mail_layouts_model::getDefaultTemplateData('password_reset_request_alert');
//        $this->sendMail($this->getReminderEmail(), $mail_template, $mail_data);
//
//        return TRUE;
    }

    /**
     * Sets the new password on user requested reset
     *
     * @param $code
     * @param $password
     *
     * @return bool
     */
//    public function completeResetPassword($code, $password)
//    {
//        if (!$this->checkResetPasswordCode($code))
//            return FALSE;
//
//        $this->password = App::make('hash')->make($password);
//        $this->reset_time = null;
//        $this->reset_code = null;
//
//        return $this->save();

//        $mail_data['staff_name'] = $userModel->staff_name;
//        $mail_data['staff_username'] = $userModel->username;
//        $mail_data['created_password'] = str_repeat('*', strlen($password));
//
//        $mail_template = Mail_layouts_model::getDefaultTemplateData('password_reset_alert');
//
//        $this->sendMail($this->getReminderEmail(), $mail_template, $mail_data);
//
//        return TRUE;
//    }

    /**
     * Update the user password
     */
//    public function updatePassword($identity, array $credentials)
//    {
//        $password = $credentials['password'];
//
//        $userModel = $this->newQuery()
//                          ->where($this->getAuthIdentifierName(), $identity)->first();
//
//        if (is_null($userModel))
//            return FALSE;
//
//        $userModel->password = $this->getHasher()->make($password);
//        $userModel->save();
//    }

    public function getReminderEmail()
    {
        return $this->staff_email;
    }

    /**
     * Send email to staff
     *
     * @param string $email
     * @param array $template
     * @param array $data
     *
     * @return bool
     */
//    public function sendMail($email, $template, $data = [])
//    {
//        $this->ci()->load->library('email');
//
//        $this->ci()->email->initialize();
//
//        $this->ci()->email->from(setting('site_email'), setting('site_name'));
//        $this->ci()->email->to(strtolower($email));
//        $this->ci()->email->subject($template['subject'], $data);
//        $this->ci()->email->message($template['body'], $data);
//
//        if ($this->ci()->email->send()) {
//            return TRUE;
//        }
//        else {
//            log_message('debug', $this->ci()->email->print_debugger(['headers']));
//        }
//    }
}