<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Users Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Users_model.php
 * @link           http://docs.tastyigniter.com
 */
class Users_model extends Model
{
    use \Igniter\Traits\UserTrait;

    /**
	 * @var string The database table name
	 */
	protected $table = 'users';

	protected $primaryKey = 'user_id';

    protected $dates = [
        'reset_time',
        'date_activated',
    ];

    public function scopeJoinStaffTable($query)
    {
        $query->join('staffs', 'staffs.staff_id', '=', 'users.staff_id', 'left');

        return $query;
    }

    /**
     * Reset a staff password,
     * a password reset link is sent to the staff email
     *
     * @param string $username
     *
     * @return bool
     */
    public function resetPassword($username = '')
    {
        if (empty($username))
            return FALSE;

        $staffsTable = $this->tablePrefix('staffs');
        $query = $this->newQuery()->selectRaw("{$staffsTable}.staff_id, staff_email, staff_name, username");
        $query = $query->joinStaffTable()->where('username', $username);
        if (!$userModel = $query->first())
            return FALSE;

        $update = [
            'reset_code' => $this->createResetCode($userModel),
            'reset_time' => mdate('%Y-%m-%d %H:%i:%a', time()),
        ];

        $this->newQuery()->where('username', $username)->update($update);

        $mail_data['staff_name'] = $userModel->staff_name;
        $mail_data['staff_username'] = $userModel->username;
        $mail_data['reset_link'] = admin_url('login/reset/'.$update['reset_code']);

        $this->load->model('Mail_templates_model');
        $mail_template = $this->Mail_templates_model->getDefaultTemplateData('password_reset_request_alert');

        $this->sendMail($this->getReminderEmail(), $mail_template, $mail_data);

        return TRUE;
    }

    /**
     * Sets the new password on user requested reset
     *
     * @param $identity
     * @param $credentials
     *
     * @return bool
     */
    public function completeResetPassword($identity, $credentials)
    {
        $code = $credentials['reset_code'];
        $password = $credentials['password'];

        $userModel = $this->newQuery()
                          ->where($this->getAuthIdentifierName(), $identity)
                          ->where('reset_code', $code)->first();

        if (is_null($userModel))
            return FALSE;

        $userModel->password = $this->getHasher()->make($password);
        $userModel->reset_code = null;
        $userModel->save();

        $mail_data['staff_name'] = $userModel->staff_name;
        $mail_data['staff_username'] = $userModel->username;
        $mail_data['created_password'] = str_repeat('*', strlen($password));

        $this->load->model('Mail_templates_model');
        $mail_template = $this->Mail_templates_model->getDefaultTemplateData('password_reset_alert');

        $this->sendMail($this->getReminderEmail(), $mail_template, $mail_data);

        return TRUE;
    }

    /**
     * Update the user password
     */
    public function updatePassword()
    {
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
    public function sendMail($email, $template, $data = [])
    {
        $this->load->library('email');

        $this->email->initialize();

        $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
        $this->email->to(strtolower($email));
        $this->email->subject($template['subject'], $data);
        $this->email->message($template['body'], $data);

        if ($this->email->send()) {
            return TRUE;
        } else {
            log_message('debug', $this->email->print_debugger(['headers']));
        }
    }

    /**
     * Check if a username already exists in database
     *
     * @param string $username
     *
     * @return bool
     */
    public function validateUser($username = null)
    {
        $query = $this->newQuery();

        $query->where('username', $username);

        return $query->first() ? TRUE : FALSE;
    }

}

/* End of file Users_model.php */
/* Location: ./system/tastyigniter/models/Users_model.php */