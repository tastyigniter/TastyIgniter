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

    public function beforeLogin()
    {
        if ($language = $this->staff->language)
            app('translator.localization')->setSessionLocale($language->code);
    }

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
}