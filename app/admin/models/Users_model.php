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
    }

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